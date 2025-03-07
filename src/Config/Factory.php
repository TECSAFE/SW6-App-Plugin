<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Config;

use Psr\Http\Message\UriFactoryInterface;
use Shopware\Core\PlatformRequest;
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
        private readonly ?string $tecsafeSalesChannelSecretIdEnv = null,
        private readonly ?string $tecsafeSalesChannelSecretKeyEnv = null,
        private readonly ?string $tecsafeShopApiGatewayUrlEnv = null,
        private readonly ?string $tecsafeAppUrlEnv = null,
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
