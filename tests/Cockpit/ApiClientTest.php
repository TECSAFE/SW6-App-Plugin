<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Tests\Cockpit;

use Google\Auth\Cache\MemoryCacheItemPool;
use Madco\Tecsafe\Cockpit\AccessToken;
use Madco\Tecsafe\Cockpit\ApiClient;
use Madco\Tecsafe\Config\PluginConfig;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClientTest extends TestCase
{
    public function test_can_obtain_and_cache_access_token(): void
    {
        $now = new \DateTime();
        $issuedAt = clone $now;
        $expiry = $now->modify('+900 minutes');

        $tokenResponse = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.'
            . \base64_encode(\json_encode(['iat' => $issuedAt->getTimestamp(), 'exp' => $expiry->getTimestamp()]))
            . '.WzDWoZ99YdK6p9FcyoNkPANTKPupYPXkjhPH4vKi3vk'
        ;

        $responses = [
            new MockResponse($tokenResponse),
        ];

        $expectedToken = new AccessToken($tokenResponse, $expiry->getTimestamp());

        $httpClient = new MockHttpClient($responses);

        $pluginConfig = new PluginConfig(
            'foobar',
            'foo',
            'barsecret',
            'foo',
            'bar',
            'baz',
            'wdwd'
        );

        $cache = new ArrayAdapter();

        $this->assertCount(0, $cache->getValues());
        $apiClient = new ApiClient($httpClient, $pluginConfig, $cache);

        $firstToken = $apiClient->obtainAccessToken();

        $this->assertEquals($expectedToken, $firstToken);

        $this->assertCount(1, $cache->getValues());

        $secondToken = $apiClient->obtainAccessToken();

        $this->assertEquals($firstToken, $secondToken);
    }

    public function test_can_obtain_access_token_with_expired_cache_item(): void
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
            'foo',
            'bar',
            'baz',
            'wdwd'
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
            new MockResponse($newTokenResponse),
        ];
        $httpClient = new MockHttpClient($responses);

        $apiClient = new ApiClient($httpClient, $pluginConfig, $cache);

        $firstToken = $apiClient->obtainAccessToken();

        $expectedToken = new AccessToken($newTokenResponse, $newTokenExpiry->getTimestamp());

        $this->assertEquals($expectedToken, $firstToken);
    }
}
