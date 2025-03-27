<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Core\Checkout\Cart\LineItem;

use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\LineItemFactoryHandler\LineItemFactoryInterface;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

/**
 * @deprecated
 */
class LineItemFactory implements LineItemFactoryInterface
{
    final public const TYPE = 'tecsafe-ofcp';

    public function supports(string $type): bool
    {
        return $type === self::TYPE;
    }

    /**
     * Creates a new line item.
     *
     * @param array               $data    the data to be used for creating the line item
     * @param SalesChannelContext $context the sales channel context
     *
     * @return LineItem the created line item
     */
    public function create(array $data, SalesChannelContext $context): LineItem
    {
        return new LineItem($data['id'], self::TYPE, Uuid::randomHex(), 1);
    }

    /**
     * Not implemented yet.
     */
    public function update(LineItem $lineItem, array $data, SalesChannelContext $context): void {}
}
