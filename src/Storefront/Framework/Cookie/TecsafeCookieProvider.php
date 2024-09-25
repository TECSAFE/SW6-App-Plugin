<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Storefront\Framework\Cookie;

use Shopware\Storefront\Framework\Cookie\CookieProviderInterface;

class TecsafeCookieProvider implements CookieProviderInterface
{
    private const TECSAFE_FOAM_CONFIGURATION_COOKIES = [
        'snippet_name' => 'cookie.tecsafeFoamConfigurator.name',
        'snippet_description' => 'cookie.tecsafeFoamConfigurator.description',
        'cookie' => 'tecsafe-foam-configurator-enabled',
        'value' => '1',
        'expiration' => '30'
    ];

    private CookieProviderInterface $originalService;

    public function __construct(CookieProviderInterface $originalService)
    {
        $this->originalService = $originalService;
    }

    public function getCookieGroups(): array
    {
        return array_merge(
            $this->originalService->getCookieGroups(),
            [
                self::TECSAFE_FOAM_CONFIGURATION_COOKIES
            ]
        );
    }
}
