<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Tests\Tecsafe;

use Madco\Tecsafe\Tecsafe\AccessToken;
use Madco\Tecsafe\Tecsafe\Api\Generated\Model\SalesChannelLoginRequest;
use Madco\Tecsafe\Tecsafe\ApiClient;
use Madco\Tecsafe\Config\PluginConfig;
use Madco\Tecsafe\Tecsafe\CacheKeyBuilder;
use Nyholm\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Shopware\Core\Framework\Script\Execution\Awareness\SalesChannelContextAwareTrait;
use Shopware\Core\Framework\Test\Seo\StorefrontSalesChannelTestHelper;
use Shopware\Core\Framework\Test\TestCaseBase\SalesChannelFunctionalTestBehaviour;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiClientTest extends TestCase
{
    use SalesChannelFunctionalTestBehaviour;
    use StorefrontSalesChannelTestHelper;

    public function testCanObtainAndCacheAccessToken(): void
    {
        $now = new \DateTime();
        $issuedAt = clone $now;
        $expiry = $now->modify('+900 minutes');

        $tokenResponse = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.'
            . \base64_encode(\json_encode(['iat' => $issuedAt->getTimestamp(), 'exp' => $expiry->getTimestamp()]))
            . '.WzDWoZ99YdK6p9FcyoNkPANTKPupYPXkjhPH4vKi3vk'
        ;

        $responses = [
            new MockResponse($tokenResponse, [
                'http_code' => Response::HTTP_CREATED,
            ]),
        ];

        $expectedToken = new AccessToken($tokenResponse, $expiry->getTimestamp());

        $httpClient = new MockHttpClient($responses);

        $pluginConfig = new PluginConfig(
            'foobar',
            'foo',
            'barsecret',
            new Uri('http://app.local'),
            new Uri('http://app.local'),
        );

        $cache = new ArrayAdapter();

        $this->assertCount(0, $cache->getValues());
        $apiClient = new ApiClient($httpClient, $pluginConfig, $cache, new CacheKeyBuilder(), new NullLogger());

        $salesChannelContext = $this->createStorefrontSalesChannelContext(Uuid::randomHex(), 'foobar');

        $firstToken = $apiClient->loginSalesChannel($salesChannelContext);

        $this->assertEquals($expectedToken, $firstToken);

        $this->assertCount(1, $cache->getValues());

        $secondToken = $apiClient->loginSalesChannel($salesChannelContext);

        $this->assertEquals($firstToken, $secondToken);
    }

    public function testCanObtainAccessTokenWithExpiredCacheItem(): void
    {
        $now = new \DateTime();
        $issuedAt = clone $now;
        $expiry = $now->modify('-60 seconds');

        $expiredTokenResponse = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.'
            . \base64_encode(\json_encode(['iat' => $issuedAt->getTimestamp(), 'exp' => $expiry->getTimestamp()]))
            . '.WzDWoZ99YdK6p9FcyoNkPANTKPupYPXkjhPH4vKi3vk'
        ;

        $pluginConfig = new PluginConfig(
            'foobar',
            'foo',
            'barsecret',
            new Uri('http://app.local'),
            new Uri('http://app.local'),
        );

        /* prepare cache with expired token */
        $expiredAccessToken = new AccessToken($expiredTokenResponse, $expiry->getTimestamp());
        $cache = new ArrayAdapter();
        $cacheItem = $cache->getItem('foobar_access-token');
        $cacheItem->set($expiredAccessToken);
        $cacheItem->expiresAt($expiry);

        $cache->save($cacheItem);

        $this->assertFalse($cache->hasItem('foobar_access-token'));

        $newTokenExpiry = $now->modify('+1 second');

        $newTokenResponse = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.'
            . \base64_encode(\json_encode(['iat' => $issuedAt->getTimestamp(), 'exp' => $newTokenExpiry->getTimestamp()]))
            . '.WzDWoZ99YdK6p9FcyoNkPANTKPupYPXkjhPH4vKi3vk'
        ;

        $responses = [
            new MockResponse($newTokenResponse, [
                'http_code' => Response::HTTP_CREATED,
            ]),
        ];
        $httpClient = new MockHttpClient($responses);

        $apiClient = new ApiClient($httpClient, $pluginConfig, $cache, new CacheKeyBuilder(), new NullLogger());

        $salesChannelContext = $this->createStorefrontSalesChannelContext(Uuid::randomHex(), 'foobar');
        $firstToken = $apiClient->loginSalesChannel($salesChannelContext);

        $expectedToken = new AccessToken($newTokenResponse, $newTokenExpiry->getTimestamp());

        $this->assertEquals($expectedToken, $firstToken);
    }
}
