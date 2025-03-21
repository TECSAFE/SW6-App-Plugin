<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Storefront\Controller;

use Madco\Tecsafe\Tecsafe\ApiClient as CockpitApiClient;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(defaults: ['_routeScope' => ['storefront']])]
class TokenApiController
{
    public function __construct(
        private readonly CockpitApiClient $cockpitApiClient
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
        $token = $this->cockpitApiClient->obtainCustomerTokenFromCockpit($salesChannelContext);

        return new JsonResponse([
            'token' => $token,
        ]);
    }
}
