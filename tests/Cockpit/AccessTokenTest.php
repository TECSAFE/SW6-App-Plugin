<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Tests\Cockpit;

use Madco\Tecsafe\Cockpit\AccessToken;
use PHPUnit\Framework\TestCase;

class AccessTokenTest extends TestCase
{
    public function test_can_serialize_and_unserialize(): void
    {
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyLCJleHAiOjEyMzEzMTMxM30.FEakIu5cr0osbBFUMxBY5QeCHHdAC72fedxlo07QjWw';
        $accessToken = new AccessToken($token, 1697024393);

        $serialized = \serialize($accessToken);

        $unserialized = \unserialize($serialized);

        $this->assertEquals($unserialized, $accessToken);
    }
}
