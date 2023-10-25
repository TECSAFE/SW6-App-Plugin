<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Twig;

use Madco\Tecsafe\Config\PluginConfig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class OfcpExtension extends AbstractExtension
{
    public function __construct(
        private readonly PluginConfig $pluginConfig
    ) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('ofcp_app_url', [$this, 'getOfcpAppUrl']),
            new TwigFunction('ofcp_app_checkout_cart_url', [$this, 'getOfcpAppCheckoutCartUrl']),
            new TwigFunction('ofcp_app_widget_url', [$this, 'getOfcpAppWidgetUrl']),
        ];
    }

    public function getOfcpAppUrl(): string
    {
        return $this->pluginConfig->appUrl->__toString();
    }

    public function getOfcpAppCheckoutCartUrl(): string
    {
        return $this->pluginConfig->appUrl->withPath('checkout/cart')->__toString();
    }

    public function getOfcpAppWidgetUrl(): string
    {
        return $this->pluginConfig->appUrl->withPath('widget')->__toString();
    }
}
