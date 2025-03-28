<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Tecsafe;

final class AccessToken
{
    public function __construct(
        public readonly string $token,
        public readonly int $validUntil
    ) {}

    public static function validateAndExtract(string $tokenResponse): self
    {
        $jwt_parts = explode('.', $tokenResponse);

        if (\count($jwt_parts) !== 3) {
            throw new \Exception('Invalid token received: Invalid JWT format');
        }

        $jwt_payload = json_decode(base64_decode($jwt_parts[1], true), true);

        if (!isset($jwt_payload['exp'])) {
            throw new \Exception('Invalid token received: No expiration date');
        }

        return new AccessToken($tokenResponse, (int) $jwt_payload['exp']);
    }
}
