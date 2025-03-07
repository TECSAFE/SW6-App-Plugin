<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Model;

class SalesChannelLoginRequest extends \ArrayObject
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
     * Sales Channel identifier
     *
     * @var string
     */
    protected $id;
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
    /**
     * Sales Channel identifier
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
    /**
     * Sales Channel identifier
     *
     * @param string $id
     *
     * @return self
     */
    public function setId(string $id): self
    {
        $this->initialized['id'] = true;
        $this->id = $id;
        return $this;
    }
}