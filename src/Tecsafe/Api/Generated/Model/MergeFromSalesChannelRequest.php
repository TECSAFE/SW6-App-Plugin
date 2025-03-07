<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Model;

class MergeFromSalesChannelRequest extends \ArrayObject
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
    protected $fromId;
    /**
     * 
     *
     * @var string
     */
    protected $toId;
    /**
     * 
     *
     * @var string
     */
    protected $token;
    /**
     * 
     *
     * @return string
     */
    public function getFromId(): string
    {
        return $this->fromId;
    }
    /**
     * 
     *
     * @param string $fromId
     *
     * @return self
     */
    public function setFromId(string $fromId): self
    {
        $this->initialized['fromId'] = true;
        $this->fromId = $fromId;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getToId(): string
    {
        return $this->toId;
    }
    /**
     * 
     *
     * @param string $toId
     *
     * @return self
     */
    public function setToId(string $toId): self
    {
        $this->initialized['toId'] = true;
        $this->toId = $toId;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
    /**
     * 
     *
     * @param string $token
     *
     * @return self
     */
    public function setToken(string $token): self
    {
        $this->initialized['token'] = true;
        $this->token = $token;
        return $this;
    }
}