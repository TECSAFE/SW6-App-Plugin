<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Tecsafe;

use Madco\Tecsafe\Config\PluginConfig;
use Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginSalesChannelBadRequestException;
use Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorValidationResponse;
use Madco\Tecsafe\Tecsafe\Api\Generated\Model\SalesChannelLoginRequest;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpClient\Psr18Client;
use Symfony\Component\HttpFoundation\Response;
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

        /* @todo muss noch refactored werden: nur für dev-umgebung */
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
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginSalesChannelTooManyRequestsException
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginSalesChannelBadRequestException
     * @throws \Exception
     * @throws InvalidArgumentException
     */
    public function loginSalesChannel(SalesChannelContext $salesChannelContext): AccessToken
    {
        $salesChannelLoginRequest = (new SalesChannelLoginRequest())
            ->setId($this->pluginConfig->salesChannelSecretId)
            ->setSecret($this->pluginConfig->salesChannelSecretKey)
        ;

        $cacheKey = $this->pluginConfig->salesChannelId . '_sales-channel-token';
        $cacheItem = $this->cacheItemPool->getItem($cacheKey);

        if (!$cacheItem->isHit()) {
            $response = $this->generatedClient->authLoginSalesChannel($salesChannelLoginRequest);

            $responseBody = $response->getBody()->getContents();

            if ($response->getStatusCode() === Response::HTTP_CREATED) {
                $accessToken = AccessToken::validateAndExtract($responseBody);

                $cacheItem->set($accessToken);
                $expiresAt = new \DateTime('now');
                $expiresAt->setTimestamp($accessToken->validUntil);

                $cacheItem->expiresAt($expiresAt);
                $this->cacheItemPool->save($cacheItem);
            } else {
                throw new AuthLoginSalesChannelBadRequestException(
                    (new ErrorValidationResponse())
                    ->setMessage($response->getReasonPhrase())
                    ->setStatusCode($response->getStatusCode()),
                    $response
                );
            }
        }

        return $cacheItem->get();
    }

    /**
     *
     *
     * @param \Madco\Tecsafe\Tecsafe\Api\Generated\Model\CustomerLoginRequest $requestBody
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginCustomerBadRequestException
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginCustomerTooManyRequestsException
     *
     */
    public function loginCustomer(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\CustomerLoginRequest $requestBody): AccessToken
    {
        $response = $this->generatedClient->authLoginCustomer($requestBody);

        $responseBody = $response->getBody()->getContents();

        if ($response->getStatusCode() === Response::HTTP_CREATED) {
            return AccessToken::validateAndExtract($responseBody);
        }
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
}
