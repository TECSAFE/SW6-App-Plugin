<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Tecsafe;

use Shopware\Core\Framework\Struct\Struct;
use Tecsafe\OFCP\JWT\Types\JwtCustomer;

class CustomerTokenStruct extends Struct
{
    public const API_ALIAS = 'ofcp_customer_token';

    protected JwtCustomer $customerToken;

    public function __construct(JwtCustomer $customerToken)
    {
        $this->customerToken = $customerToken;
    }

    public function getCustomerToken(): JwtCustomer
    {
        return $this->customerToken;
    }

    public function getApiAlias(): string
    {
        return self::API_ALIAS;
    }
}
