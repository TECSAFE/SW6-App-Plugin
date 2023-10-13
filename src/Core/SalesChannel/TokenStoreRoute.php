<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Core\SalesChannel;

use Madco\Tecsafe\Tecsafe\ApiClient as CockpitApiClient;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(defaults: ['_routeScope' => ['store-api']])]
class TokenStoreRoute
{
    public function __construct(
        private readonly CockpitApiClient $cockpitApiClient
    ) {
    }

    #[Route(
        path: '/store-api/tecsafe/ofcp/token',
        name: 'store-api.tecsafe.ofcp.login',
        defaults: [
            '_loginRequired' => true,
        ],
        methods: ['GET']
    )]
    public function index(SalesChannelContext $salesChannelContext): JsonResponse
    {
        $token = $this->cockpitApiClient->obtainCustomerTokenFromCockpit($salesChannelContext);

        return new JsonResponse([
            'token' => $token,
        ]);
    }
}
