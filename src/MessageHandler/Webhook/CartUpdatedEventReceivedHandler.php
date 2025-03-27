<?php

declare(strict_types=1);

namespace Madco\Tecsafe\MessageHandler\Webhook;

use Madco\Tecsafe\Core\Checkout\Cart\LineItem\LineItemFactory;
use Madco\Tecsafe\Messages\Webhook\CartUpdatedEventReceived;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\Price\Struct\AbsolutePriceDefinition;
use Shopware\Core\Checkout\Cart\Price\Struct\CalculatedPrice;
use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Core\Checkout\Cart\Tax\Struct\CalculatedTaxCollection;
use Shopware\Core\Checkout\Cart\Tax\Struct\TaxRuleCollection;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SalesChannel\Context\AbstractSalesChannelContextFactory;

/**
 * @deprecated Has to be replaced
 */
class CartUpdatedEventReceivedHandler
{
    public function __construct(
        private readonly AbstractSalesChannelContextFactory $salesChannelContextFactory,
        private readonly CartService $cartService,
    ) {}

    public function __invoke(CartUpdatedEventReceived $cartUpdatedWebhook): void
    {
        $total = 0;
        $data = $cartUpdatedWebhook->data;

        foreach ($data['cart'] as $id => $item) {
            $total += $item['price'];
        }

        $context = $this->salesChannelContextFactory->create(
            $data['user']['aud'],
            $data['user']['extra']['salesChannel']
        );

        $cart = $this->cartService->getCart($data['user']['aud'], $context);

        $lineItems = $cart->getLineItems()->getFlat();

        foreach ($lineItems as $lineItem) {
            if ($lineItem->getType() === 'tecsafe-ofcp') {
                $lineItem->setRemovable(true);
                $this->cartService->remove($cart, $lineItem->getId(), $context);
            }
        }

        if (empty($data['cart'])) {
            return;
        }

        $definedPrice = new AbsolutePriceDefinition($total);
        $absolutePrice = new CalculatedPrice($total, $total, new CalculatedTaxCollection(), new TaxRuleCollection());

        $lineItem = new LineItem(Uuid::randomHex(), LineItemFactory::TYPE, null, 1);
        $lineItem->setLabel('tecsafe-ofcp');
        $lineItem->setPriceDefinition($definedPrice);
        $lineItem->setPrice($absolutePrice);
        $lineItem->setStackable(true);
        $lineItem->setRemovable(false);

        $this->cartService->add($cart, $lineItem, $context);
    }
}
