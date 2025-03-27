<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Config;

use Psr\Http\Message\UriFactoryInterface;
use Shopware\Core\PlatformRequest;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class Factory
{
    public function __construct(
        private SystemConfigService $systemConfigService,
        private UriFactoryInterface $uriFactory,
        private ?RequestStack $requestStack = null,
        private ?string $tecsafeSalesChannelSecretIdEnv = null,
        private ?string $tecsafeSalesChannelSecretKeyEnv = null,
        private ?string $tecsafeShopApiGatewayUrlEnv = null,
        private ?string $tecsafeAppUrlEnv = null,
    ) {}

    public function create(): PluginConfig
    {
        $salesChannelId = null;

        if ($this->requestStack !== null) {
            $salesChannelId = $this->requestStack->getMainRequest()?->attributes->get(PlatformRequest::ATTRIBUTE_SALES_CHANNEL_ID);
        }

        $salesChannelSecretId = $this->tecsafeSalesChannelSecretIdEnv ?? $this->systemConfigService->getString(
            PluginConfig::SALES_CHANNEL_SECRET_ID,
            $salesChannelId
        );

        $salesChannelSecretKey = $this->tecsafeSalesChannelSecretKeyEnv ?? $this->systemConfigService->getString(
            PluginConfig::SALES_CHANNEL_SECRET_KEY,
            $salesChannelId
        );

        $shopApiGatewayUrl = $this->tecsafeShopApiGatewayUrlEnv ?? $this->systemConfigService->getString(
            PluginConfig::SHOP_API_GATEWAY_URL_KEY,
            $salesChannelId
        );

        $appUrl = $this->tecsafeAppUrlEnv ?? $this->systemConfigService->getString(
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
