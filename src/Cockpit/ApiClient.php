<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Cockpit;

use Madco\Tecsafe\Config\PluginConfig;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly PluginConfig $pluginConfig,
        private readonly CacheItemPoolInterface $cacheItemPool
    ) {
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Exception
     */
    public function obtainAccessToken(): AccessToken
    {
        $cacheKey = $this->pluginConfig->salesChannelId . '_' . 'access-token';

        $cacheItem = $this->cacheItemPool->getItem($cacheKey);

        if (!$cacheItem->isHit()) {
            $tokenUrl = $this->pluginConfig->cockpitUrl . 'v1/token/shop';

            $response = $this->httpClient->request(Request::METHOD_POST, $tokenUrl, [
                'json' => [
                    'salesChannel' => $this->pluginConfig->salesChannelName,
                    'secret' => $this->pluginConfig->salesChannelSecret,
                ]
            ]);

            $responseBody = $response->getContent();

            $accessToken = AccessToken::validateAndExtract($responseBody);

            $cacheItem->set($accessToken);
            $expiresAt = new \DateTime();
            $expiresAt->setTimestamp($accessToken->validUntil);
            $cacheItem->expiresAt($expiresAt);
            $this->cacheItemPool->save($cacheItem);
        }

        return $cacheItem->get();
    }
}
