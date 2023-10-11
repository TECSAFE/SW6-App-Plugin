<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Cockpit;

use Psr\Clock\ClockInterface;

class AccessTokenValidator
{
    public function __construct(
        private readonly ClockInterface $clock
    ) {
    }

    public function isValid(AccessToken $accessToken): bool
    {
        return $accessToken->validUntil > $this->clock->now()->getTimestamp();
    }
}