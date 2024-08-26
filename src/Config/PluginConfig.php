<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Config;

use Psr\Http\Message\UriInterface;

final class PluginConfig
{
    private const CONFIG_KEY_PREFIX = 'MadTecsafe.config.';

    public const SALES_CHANNEL_SECRET_ID = self::CONFIG_KEY_PREFIX . 'salesChannelSecretId';

    public const SALES_CHANNEL_SECRET_KEY = self::CONFIG_KEY_PREFIX . 'salesChannelSecretKey';

    public const SHOP_API_GATEWAY_URL_KEY = self::CONFIG_KEY_PREFIX . 'shopApiGatewayUrl';

    public const APP_URL_KEY = self::CONFIG_KEY_PREFIX . 'appUrl';

    public function __construct(
        public readonly ?string $salesChannelId,
        public readonly string $salesChannelSecretId,
        public readonly string $salesChannelSecretKey,
        public readonly UriInterface $shopApiGatewayUrl,
        public readonly UriInterface $appUrl,
    ) {}
}
