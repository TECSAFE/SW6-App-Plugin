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
     * 
     *
     * @var string
     */
    protected $secret;
    /**
     * 
     *
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }
    /**
     * 
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