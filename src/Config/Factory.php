<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Config;

use Psr\Http\Message\UriFactoryInterface;
use Shopware\Core\PlatformRequest;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\HttpFoundation\RequestStack;

final class Factory
{
    private const TECSAFE_SALES_CHANNEL_SECRET_ID = 'TECSAFE_SALES_CHANNEL_SECRET_ID';
    private const TECSAFE_SALES_CHANNEL_SECRET_KEY = 'TECSAFE_SALES_CHANNEL_SECRET_KEY';
    private const TECSAFE_SHOP_API_GATEWAY_URL = 'TECSAFE_SHOP_API_GATEWAY_URL';
    private const TECSAFE_APP_URL = 'TECSAFE_APP_URL';

    public function __construct(
        private readonly SystemConfigService $systemConfigService,
        private readonly UriFactoryInterface $uriFactory,
        private readonly ?RequestStack $requestStack = null,
    ) {}

    public function create(): PluginConfig
    {
        $salesChannelId = null;

        if ($this->requestStack !== null) {
            $salesChannelContext = $this->requestStack->getCurrentRequest()?->attributes->get(PlatformRequest::ATTRIBUTE_SALES_CHANNEL_CONTEXT_OBJECT);

            if ($salesChannelContext instanceof SalesChannelContext) {
                $salesChannelId = $salesChannelContext->getSalesChannelId();
            }
        }

        $salesChannelSecretId = \getenv(self::TECSAFE_SALES_CHANNEL_SECRET_ID) ?? $this->systemConfigService->getString(
            PluginConfig::SALES_CHANNEL_SECRET_ID,
            $salesChannelId
        );

        $salesChannelSecretKey = \getenv(self::TECSAFE_SALES_CHANNEL_SECRET_KEY) ?? $this->systemConfigService->getString(
            PluginConfig::SALES_CHANNEL_SECRET_KEY,
            $salesChannelId
        );

        $shopApiGatewayUrl = \getenv(self::TECSAFE_SHOP_API_GATEWAY_URL) ?? $this->systemConfigService->getString(
            PluginConfig::SHOP_API_GATEWAY_URL_KEY,
            $salesChannelId
        );

        $appUrl = \getenv(self::TECSAFE_APP_URL) ?? $this->systemConfigService->getString(
            PluginConfig::APP_URL_KEY,
            $salesChannelId
        );

        return new PluginConfig(
            $salesChannelId,
            $salesChannelSecretId,
            $salesChannelSecretKey,
            $this->uriFactory->createUri($shopApiGatewayUrl),
            $this->uriFactory->createUri($appUrl),
        );
    }
}
