<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Messages\TecsafeApi;

use Shopware\Core\Framework\MessageQueue\AsyncMessageInterface;

final class MergeCustomerCommand implements AsyncMessageInterface
{
    public function __construct(
        public string $fromCustomerIdentifier,
        public string $toCustomerIdentifier,
        public string $salesChannelContextToken,
        public string $salesChannelId,
    ) {}
}
