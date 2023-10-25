<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Tests\Tecsafe;

use Madco\Tecsafe\Tecsafe\AccessToken;
use PHPUnit\Framework\TestCase;

class AccessTokenTest extends TestCase
{
    public function testCanSerializeAndUnserialize(): void
    {
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyLCJleHAiOjEyMzEzMTMxM30.FEakIu5cr0osbBFUMxBY5QeCHHdAC72fedxlo07QjWw';
        $accessToken = new AccessToken($token, 1_697_024_393);

        $serialized = \serialize($accessToken);

        $unserialized = \unserialize($serialized);

        $this->assertEquals($unserialized, $accessToken);
    }
}
