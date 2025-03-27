<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated;

use Psr\Http\Message\ResponseInterface;

class Client extends \Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Client\Client
{
    /**
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\KeyGetJwksBadRequestException
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\KeyGetJwksTooManyRequestsException
     *
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    public function keyGetJwks(): ?ResponseInterface
    {
        return $this->executeRawEndpoint(new \Madco\Tecsafe\Tecsafe\Api\Generated\Endpoint\KeyGetJwks());
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
    public function authLoginSalesChannel(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\SalesChannelLoginRequest $requestBody): ?ResponseInterface
    {
        return $this->executeRawEndpoint(new \Madco\Tecsafe\Tecsafe\Api\Generated\Endpoint\AuthLoginSalesChannel($requestBody));
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
    public function authLoginCustomer(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\CustomerLoginRequest $requestBody): ?ResponseInterface
    {
        return $this->executeRawEndpoint(new \Madco\Tecsafe\Tecsafe\Api\Generated\Endpoint\AuthLoginCustomer($requestBody));
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
    public function authLoginInternal(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\LoginRequest $requestBody): ?ResponseInterface
    {
        return $this->executeRawEndpoint(new \Madco\Tecsafe\Tecsafe\Api\Generated\Endpoint\AuthLoginInternal($requestBody));
    }

    /**
     *
     *
     * @param \Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromSalesChannelRequest $requestBody
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\MergeControllerMigrateFromSalesChannelBadRequestException
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\MergeControllerMigrateFromSalesChannelTooManyRequestsException
     *
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    public function mergeControllerMigrateFromSalesChannel(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromSalesChannelRequest $requestBody): ?ResponseInterface
    {
        return $this->executeRawEndpoint(new \Madco\Tecsafe\Tecsafe\Api\Generated\Endpoint\MergeControllerMigrateFromSalesChannel($requestBody));
    }

    /**
     *
     *
     * @param \Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromCustomerRequest $requestBody
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\MergeControllerMigrateFromCustomerBadRequestException
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\MergeControllerMigrateFromCustomerTooManyRequestsException
     *
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    public function mergeControllerMigrateFromCustomer(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromCustomerRequest $requestBody): ?ResponseInterface
    {
        return $this->executeRawEndpoint(new \Madco\Tecsafe\Tecsafe\Api\Generated\Endpoint\MergeControllerMigrateFromCustomer($requestBody));
    }

    public static function create($httpClient = null, array $additionalPlugins = [], array $additionalNormalizers = [])
    {
        if (null === $httpClient) {
            $httpClient = \Http\Discovery\Psr18ClientDiscovery::find();
            $plugins = [];
            if (count($additionalPlugins) > 0) {
                $plugins = array_merge($plugins, $additionalPlugins);
            }
            $httpClient = new \Http\Client\Common\PluginClient($httpClient, $plugins);
        }
        $requestFactory = \Http\Discovery\Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = \Http\Discovery\Psr17FactoryDiscovery::findStreamFactory();
        $normalizers = [new \Symfony\Component\Serializer\Normalizer\ArrayDenormalizer(), new \Madco\Tecsafe\Tecsafe\Api\Generated\Normalizer\JaneObjectNormalizer()];
        if (count($additionalNormalizers) > 0) {
            $normalizers = array_merge($normalizers, $additionalNormalizers);
        }
        $serializer = new \Symfony\Component\Serializer\Serializer($normalizers, [new \Symfony\Component\Serializer\Encoder\JsonEncoder(new \Symfony\Component\Serializer\Encoder\JsonEncode(), new \Symfony\Component\Serializer\Encoder\JsonDecode(['json_decode_associative' => true]))]);
        return new static($httpClient, $requestFactory, $serializer, $streamFactory);
    }
}