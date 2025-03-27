<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Model;

class MergeFromCustomerRequest extends \ArrayObject
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
    protected $oldToken;
    /**
     * 
     *
     * @var string
     */
    protected $newToken;
    /**
     * 
     *
     * @return string
     */
    public function getOldToken(): string
    {
        return $this->oldToken;
    }
    /**
     * 
     *
     * @param string $oldToken
     *
     * @return self
     */
    public function setOldToken(string $oldToken): self
    {
        $this->initialized['oldToken'] = true;
        $this->oldToken = $oldToken;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getNewToken(): string
    {
        return $this->newToken;
    }
    /**
     * 
     *
     * @param string $newToken
     *
     * @return self
     */
    public function setNewToken(string $newToken): self
    {
        $this->initialized['newToken'] = true;
        $this->newToken = $newToken;
        return $this;
    }
}