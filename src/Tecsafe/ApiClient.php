<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Tecsafe;

use Madco\Tecsafe\Config\PluginConfig;
use Psr\Cache\CacheItemPoolInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpClient\Psr18Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Madco\Tecsafe\Tecsafe\Api\Generated\Client as GeneratedClient;

final class ApiClient
{
    private readonly GeneratedClient $generatedClient;

    /**
     * @todo Symfony configurator verwenden https://symfony.com/doc/7.0/service_container/configurators.html
     */
    public function __construct(
        HttpClientInterface $httpClient,
        private readonly PluginConfig $pluginConfig,
        private readonly CacheItemPoolInterface $cacheItemPool,
    ) {
        $baseUri = $this->pluginConfig->shopApiGatewayUrl;

        $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

        $symfonyHttpClient = $httpClient->withOptions([
            'base_uri' => $baseUri->__toString(),
        ]);

        $psr18Client = new Psr18Client($symfonyHttpClient);

        $psr18Client = $psr18Client->withOptions([
            'verify_peer' => false,
            'verify_host' => false,
        ]);

        $normalizers = [
            new \Symfony\Component\Serializer\Normalizer\ArrayDenormalizer(),
            new \Madco\Tecsafe\Tecsafe\Api\Generated\Normalizer\JaneObjectNormalizer(),
        ];

        $serializer = new \Symfony\Component\Serializer\Serializer(
            $normalizers,
            [
                new \Symfony\Component\Serializer\Encoder\JsonEncoder(
                    new \Symfony\Component\Serializer\Encoder\JsonEncode(),
                    new \Symfony\Component\Serializer\Encoder\JsonDecode(['json_decode_associative' => true])
                )
            ]
        );

        $this->generatedClient = new GeneratedClient($psr18Client, $psr17Factory, $serializer, $psr17Factory);
    }

    public function getJwks(string $fetch = GeneratedClient::FETCH_OBJECT)
    {
        return $this->generatedClient->keyGetJwks($fetch);
    }

    /**
     *
     *
     * @param \Madco\Tecsafe\Tecsafe\Api\Generated\Model\SalesChannelLoginRequest $requestBody
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginSalesChannelBadRequestException
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginSalesChannelTooManyRequestsException
     *
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    public function loginSalesChannel(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\SalesChannelLoginRequest $requestBody): string
    {
        $response = $this->generatedClient->authLoginSalesChannel($requestBody);

        return $response->getBody()->getContents();
    }
    /**
     *
     *
     * @param \Madco\Tecsafe\Tecsafe\Api\Generated\Model\CustomerLoginRequest $requestBody
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginCustomerBadRequestException
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginCustomerTooManyRequestsException
     *
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    public function loginCustomer(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\CustomerLoginRequest $requestBody)
    {
        $this->generatedClient->authLoginCustomer($requestBody);
    }

    /**
     *
     *
     * @param \Madco\Tecsafe\Tecsafe\Api\Generated\Model\LoginRequest $requestBody
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginInternalBadRequestException
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginInternalTooManyRequestsException
     *
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    public function loginInternal(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\LoginRequest $requestBody)
    {
        return $this->generatedClient->authLoginInternal($requestBody);
    }

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
