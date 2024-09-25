<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Model;

class CustomerLoginRequest extends \ArrayObject
{
    /**
     * @var array
     */
    protected $initialized = [];

    public function isInitialized($property): bool
    {
        return array_key_exists($property, $this->initialized);
    }

    protected string $secret;

    /**
     * @var string
     */
    protected string $email;

    /**
     * @var string
     */
    protected string $identifier;

    /**
     * @var bool
     */
    protected bool $isGuest;
    
    public function getSecret(): string
    {
        return $this->secret;
    }

    public function setSecret(string $secret): self
    {
        $this->initialized['secret'] = true;
        $this->secret = $secret;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->initialized['email'] = true;
        $this->email = $email;

        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->initialized['identifier'] = true;
        $this->identifier = $identifier;

        return $this;
    }

    public function getIsGuest(): bool
    {
        return $this->isGuest;
    }

    public function setIsGuest(bool $isGuest): self
    {
        $this->initialized['isGuest'] = true;
        $this->isGuest = $isGuest;

        return $this;
    }
}
