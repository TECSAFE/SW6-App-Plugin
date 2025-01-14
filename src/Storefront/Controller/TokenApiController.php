<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Storefront\Controller;

use Madco\Tecsafe\Config\PluginConfig;
use Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginSalesChannelBadRequestException;
use Madco\Tecsafe\Tecsafe\Api\Generated\Model\CustomerLoginRequest;
use Madco\Tecsafe\Tecsafe\Api\Generated\Model\SalesChannelLoginRequest;
use Madco\Tecsafe\Tecsafe\ApiClient;
use Psr\Log\LoggerInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: ['_routeScope' => ['storefront']])]
readonly class TokenApiController
{
    public function __construct(
        private ApiClient $client,
        private PluginConfig $pluginConfig,
        private LoggerInterface $logger,
    ) {}

    #[Route(
        path: '/tecsafe/ofcp/token',
        name: 'frontend.tecsafe.ofcp.login',
        defaults: [
            '_loginRequired' => false,
            'XmlHttpRequest' => true,
        ],
        methods: ['GET']
    )]
    public function index(SalesChannelContext $salesChannelContext): JsonResponse
    {
        /* @todo Rework with Shop-Gateway */
        #$token = $this->cockpitApiClient->obtainCustomerTokenFromCockpit($salesChannelContext);
        $customerLoginRequest = new CustomerLoginRequest();

        $salesChannelLoginRequest = (new SalesChannelLoginRequest())
            ->setId($this->pluginConfig->salesChannelSecretId)
            ->setSecret($this->pluginConfig->salesChannelSecretKey)
        ;

        try {
            $salesChannelJwt = $this->client->loginSalesChannel($salesChannelLoginRequest);
        } catch (AuthLoginSalesChannelBadRequestException $e) {
            $this->logger->error($e->getMessage());

            throw new HttpException(
                (int) $e->getErrorValidationResponse()->getStatusCode(),
                $e->getErrorValidationResponse()->getMessage()
            );
        }

        $customerLoginRequest->setSecret($salesChannelJwt->token)
            ->setEmail('foo@bar.com')
            ->setIdentifier($salesChannelContext->getToken())
            ->setIsGuest(true)
            ->setCurrency($salesChannelContext->getCurrency()->getIsoCode())
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setCompany('Test Company')
            ->setGroupIdentifier($salesChannelContext->getCurrentCustomerGroup()->getId())
        ;

        try {
            $customerJwt = $this->client->loginCustomer($customerLoginRequest);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw new HttpException(
                (int) $e->getCode(),
                $e->getMessage()
            );
        }

        return new JsonResponse([
            'token' => $customerJwt->token,
        ]);
    }
}
