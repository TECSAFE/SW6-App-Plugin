<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Storefront\Controller;

use Madco\Tecsafe\Config\PluginConfig;
use Madco\Tecsafe\Tecsafe\Api\Generated\Model\CustomerLoginRequest;
use Madco\Tecsafe\Tecsafe\Api\Generated\Model\SalesChannelLoginRequest;
use Madco\Tecsafe\Tecsafe\ApiClient;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: ['_routeScope' => ['storefront']])]
readonly class TokenApiController
{
    public function __construct(
        private ApiClient $client,
        private PluginConfig $pluginConfig
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
        $token = $this->client->loginSalesChannel($salesChannelLoginRequest);

        return new JsonResponse([
            'token' => $token,
        ]);
    }
}
