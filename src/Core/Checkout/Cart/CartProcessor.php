<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Core\Checkout\Cart;

use Madco\Tecsafe\Core\Checkout\Cart\LineItem\LineItemFactory;
use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\CartBehavior;
use Shopware\Core\Checkout\Cart\CartProcessorInterface;
use Shopware\Core\Checkout\Cart\LineItem\CartDataCollection;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

/**
 * Cart processor for the Tecsafe line item.
 */
class CartProcessor implements CartProcessorInterface
{
    /**
     * This function allows items with the type "tecsafe-ofcp" to be added to the cart.
     */
    public function process(
        CartDataCollection $data,
        Cart $original,
        Cart $toCalculate,
        SalesChannelContext $context,
        CartBehavior $behavior
    ): void {
        $lineItems = $original->getLineItems()->filterFlatByType(LineItemFactory::TYPE);

        foreach ($lineItems as $lineItem) {
            $toCalculate->add($lineItem);
        }
    }
}
