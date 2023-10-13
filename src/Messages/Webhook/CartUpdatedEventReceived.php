<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Messages\Webhook;

class CartUpdatedEventReceived
{
    public function __construct(public readonly array $data)
    {
    }
}
