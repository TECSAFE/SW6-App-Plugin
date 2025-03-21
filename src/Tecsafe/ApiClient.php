<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Tecsafe;

use Madco\Tecsafe\Config\PluginConfig;
use Psr\Cache\CacheItemPoolInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly PluginConfig $pluginConfig,
        private readonly CacheItemPoolInterface $cacheItemPool
    ) {}

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws \Exception
     */
    public function obtainAccessToken(): AccessToken
    {
        $cacheKey = $this->pluginConfig->salesChannelId . '_access-token';

        $cacheItem = $this->cacheItemPool->getItem($cacheKey);

        if (!$cacheItem->isHit()) {
            $tokenUrl = $this->pluginConfig->shopApiGatewayUrl->withPath('/store-api/tecsafe/v1/token/shop');

            $response = $this->httpClient->request(Request::METHOD_POST, $tokenUrl->__toString(), [
                'json' => [
                    'salesChannel' => $this->pluginConfig->salesChannelName,
                    'secret' => $this->pluginConfig->salesChannelSecret,
                ],
                'headers' => [
                    'sw-access-key' => $this->pluginConfig->salesChannelSecret,
                ],
                'verify_peer' => false,
                'verify_host' => false,
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

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function obtainCustomerTokenFromCockpit(SalesChannelContext $context): string
    {
        $accessToken = $this->obtainAccessToken();

        $fields = [
            'customer' => $context->getToken(),
            //'callback' => $this->pluginConfig->callbackUrl->withPath('/api/tecsafe/ofcp/webhook')->__toString(),
            'extra' => ['salesChannel' => $context->getSalesChannel()->getId()],
            'email' => $context->getCustomer()->getEmail(),
            'firstname' => $context->getCustomer()->getFirstName(),
            'lastname' => $context->getCustomer()->getLastName(),
            'street' => $context->getCustomer()->getDefaultBillingAddress()->getStreet(),
            'zip' => $context->getCustomer()->getDefaultBillingAddress()->getZipcode(),
            'city' => $context->getCustomer()->getDefaultBillingAddress()->getCity(),
            'country' => $context->getCustomer()->getDefaultBillingAddress()->getCountry()->getIso(),
        ];

        $customerTokenUrl = $this->pluginConfig->shopApiGatewayUrl->withPath('/store-api/tecsafe/v1/token/customer')->__toString();
        $response = $this->httpClient->request(Request::METHOD_POST, $customerTokenUrl, [
            'json' => $fields,
            'auth_bearer' => $accessToken->token,
            'verify_peer' => false,
            'verify_host' => false,
        ]);

        return $response->getContent();
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function createOfcpOrderInApp(array $payload): string
    {
        $accessToken = $this->obtainAccessToken();

        //$orderUrl = $this->pluginConfig->internalAppUrl->withPath('api/shop/order');
        $response = $this->httpClient->request(Request::METHOD_POST, $orderUrl->__toString(), [
            'json' => $payload,
            'auth_bearer' => $accessToken->token,
        ]);

        return $response->getContent();
    }
}
