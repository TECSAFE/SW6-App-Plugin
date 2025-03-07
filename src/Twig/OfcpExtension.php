<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Twig;

use Madco\Tecsafe\Config\PluginConfig;
use Shopware\Core\Content\Product\ProductEntity;
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
            new TwigFunction('ofcp_is_tecsafe_product', [$this, 'isTecsafeProduct']),
            new TwigFunction('ofcp_allowed_origins', [$this, 'getOfcpAllowedOrigins']),
        ];
    }

    /**
     * @todo Refactor to really using product data
     */
    public function isTecsafeProduct(ProductEntity $productEntity): bool
    {
        return true;
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

    public function getOfcpAllowedOrigins(): array
    {
        return [$this->pluginConfig->shopApiGatewayUrl->__toString()];
    }
}
