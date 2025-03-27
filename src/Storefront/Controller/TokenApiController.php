<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Storefront\Controller;

use Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginSalesChannelBadRequestException;
use Madco\Tecsafe\Tecsafe\Api\Generated\Model\CustomerLoginRequest;
use Madco\Tecsafe\Tecsafe\ApiClient;
use Madco\Tecsafe\Tecsafe\CustomerTokenStruct;
use Psr\Log\LoggerInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;
use Tecsafe\OFCP\JWT\SDK\JWTParser;

#[Route(defaults: ['_routeScope' => ['storefront']])]
readonly class TokenApiController
{
    public function __construct(
        private ApiClient $client,
        private LoggerInterface $logger,
    ) {}

    #[Route(
        path: '/tecsafe/ofcp/token',
        name: 'frontend.tecsafe.ofcp.token',
        defaults: [
            '_loginRequired' => false,
            'XmlHttpRequest' => true,
        ],
        methods: ['GET']
    )]
    public function index(SalesChannelContext $salesChannelContext, Request $request): JsonResponse
    {
        try {
            $salesChannelJwt = $this->client->loginSalesChannel($salesChannelContext);
        } catch (AuthLoginSalesChannelBadRequestException $e) {
            $this->logger->error($e->getMessage());

            throw new HttpException(
                (int) $e->getErrorValidationResponse()->getStatusCode(),
                $e->getErrorValidationResponse()->getMessage()
            );
        }

        $isGuestContext = true;

        $customer = null;

        if ($salesChannelContext->getCustomer() !== null) {
            $customer = $salesChannelContext->getCustomer();
            if ($customer->getGuest() !== false) {
                $isGuestContext = false;
            }
        }

        $customerLoginRequest = (new CustomerLoginRequest())
            ->setSecret($salesChannelJwt->token)
            ->setEmail($customer?->getEmail() ?? \sprintf('%s@%s', $salesChannelContext->getToken(), $salesChannelContext->getSalesChannel()->getId()))
            ->setIdentifier($customer?->getId() ?? $salesChannelContext->getToken())
            ->setIsGuest($isGuestContext)
            ->setCurrency($salesChannelContext->getCurrency()->getIsoCode())
            ->setFirstName($customer?->getFirstName() ?? 'John')
            ->setLastName($customer?->getLastName() ?? 'Doe')
            ->setGroupIdentifier($salesChannelContext->getCurrentCustomerGroup()->getId())
            ->setCompany($customer?->getCompany() ?? '')
        ;

        try {
            $customerToken = $this->client->loginCustomer($customerLoginRequest);
            $customerJwt = JWTParser::parseCustomerJwt($customerToken->token, null);
            $customerJwtStruct = new CustomerTokenStruct($customerJwt);

            $request->getSession()->set(CustomerTokenStruct::API_ALIAS, $customerJwtStruct);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());

            throw new HttpException(
                (int) $e->getCode(),
                $e->getMessage()
            );
        }

        return new JsonResponse([
            'token' => $customerToken->token,
        ]);
    }
}
