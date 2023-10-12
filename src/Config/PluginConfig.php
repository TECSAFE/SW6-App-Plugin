<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Config;

final class PluginConfig
{
    private const CONFIG_KEY_PREFIX = 'MadTecsafe.config.';

    public const SALES_CHANNEL_NAME_KEY = self::CONFIG_KEY_PREFIX . 'salesChannelName';

    public const SALES_CHANNEL_SECRET = self::CONFIG_KEY_PREFIX . 'salesChannelSecret';

    public const COCKPIT_URL_KEY = self::CONFIG_KEY_PREFIX . 'cockpitUrl';

    public const APP_URL_KEY = self::CONFIG_KEY_PREFIX . 'appUrl';

    public const INTERNAL_APP_URL_KEY = self::CONFIG_KEY_PREFIX . 'internalAppUrl';

    public const CALLBACK_URL_KEY = self::CONFIG_KEY_PREFIX . 'callbackUrl';

    public function __construct(
        public readonly ?string $salesChannelId,
        public readonly string $salesChannelName,
        public readonly string $salesChannelSecret,
        public readonly string $cockpitUrl,
        public readonly string $appUrl,
        public readonly string $internalAppUrl,
        public readonly string $callbackUrl
    ) {
    }
}
