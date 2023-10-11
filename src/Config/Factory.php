<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Config;

use Shopware\Core\PlatformRequest;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\HttpFoundation\RequestStack;

final class Factory
{
    public function __construct(
        private readonly SystemConfigService $systemConfigService,
        private readonly ?RequestStack $requestStack = null
    ) {
    }

    public function create(): PluginConfig
    {
        $salesChannelId = null;

        if ($this->requestStack !== null) {
            $salesChannelContext = $this->requestStack->getCurrentRequest()->attributes->get(PlatformRequest::ATTRIBUTE_SALES_CHANNEL_CONTEXT_OBJECT);

            if ($salesChannelContext instanceof SalesChannelContext) {
                $salesChannelId = $salesChannelContext->getSalesChannelId();
            }
        }

        $salesChannelName = $this->systemConfigService->getString(
            PluginConfig::SALES_CHANNEL_NAME_KEY,
            $salesChannelId
        );

        $salesChannelSecret = $this->systemConfigService->getString(
            PluginConfig::SALES_CHANNEL_SECRET,
            $salesChannelId
        );

        $cockpitUrl = $this->systemConfigService->getString(
            PluginConfig::COCKPIT_URL_KEY,
            $salesChannelId
        );

        $appUrl = $this->systemConfigService->getString(
            PluginConfig::APP_URL_KEY,
            $salesChannelId
        );

        $internalAppUrl = $this->systemConfigService->getString(
            PluginConfig::INTERNAL_APP_URL_KEY,
            $salesChannelId
        );

        $callbackUrl = $this->systemConfigService->getString(
            PluginConfig::CALLBACK_URL_KEY,
            $salesChannelId
        );

        return new PluginConfig(
            $salesChannelId,
            $salesChannelName,
            $salesChannelSecret,
            $cockpitUrl,
            $appUrl,
            $internalAppUrl,
            $callbackUrl
        );
    }
}
