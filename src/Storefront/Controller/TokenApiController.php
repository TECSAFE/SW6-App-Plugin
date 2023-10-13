<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Storefront\Controller;

use Madco\Tecsafe\Cockpit\ApiClient as CockpitApiClient;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(defaults: ['_routeScope' => ['storefront']])]
class TokenApiController
{
    public function __construct(
        private readonly CockpitApiClient $cockpitApiClient
    ) {
    }

    #[Route(
        path: '/tecsafe/ofcp/token',
        name: 'frontend.tecsafe.ofcp.login',
        defaults: [
            '_loginRequired' => true,
            'XmlHttpRequest' => true,
        ],
        methods: ['GET']
    )]
    public function index(SalesChannelContext $salesChannelContext): JsonResponse
    {
        $token = $this->cockpitApiClient->obtainCustomerToken($salesChannelContext);

        return new JsonResponse([
            'token' => $token,
        ]);
    }
}
