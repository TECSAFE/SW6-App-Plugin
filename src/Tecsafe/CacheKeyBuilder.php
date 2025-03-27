<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Tecsafe;

class CacheKeyBuilder
{
    public function buildSalesChannelTokenKey(string $salesChannelId): string
    {
        return \sprintf('%s_sales-channel-token', $salesChannelId);
    }

    public function buildCustomerTokenKey(string $salesChannelId, string $identifier, bool $isGuest): string
    {
        $suffix = $isGuest ? '_guest' : '_customer';

        return \sprintf('%s_customer-token_%s_%s', $salesChannelId, $identifier, $suffix);
    }
}
