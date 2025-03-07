<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Model;

class LoginRequest extends \ArrayObject
{
    /**
     * @var array
     */
    protected $initialized = [];
    public function isInitialized($property): bool
    {
        return array_key_exists($property, $this->initialized);
    }
    /**
     * Secret to authenticate, JWT or Static Token
     *
     * @var string
     */
    protected $secret;
    /**
     * Secret to authenticate, JWT or Static Token
     *
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }
    /**
     * Secret to authenticate, JWT or Static Token
     *
     * @param string $secret
     *
     * @return self
     */
    public function setSecret(string $secret): self
    {
        $this->initialized['secret'] = true;
        $this->secret = $secret;
        return $this;
    }
}