<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Model;

class ErrorResponse extends \ArrayObject
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
     * @var float
     */
    protected $statusCode;
    /**
     * 
     *
     * @var string
     */
    protected $message;
    /**
     * 
     *
     * @return float
     */
    public function getStatusCode(): float
    {
        return $this->statusCode;
    }
    /**
     * 
     *
     * @param float $statusCode
     *
     * @return self
     */
    public function setStatusCode(float $statusCode): self
    {
        $this->initialized['statusCode'] = true;
        $this->statusCode = $statusCode;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
    /**
     * 
     *
     * @param string $message
     *
     * @return self
     */
    public function setMessage(string $message): self
    {
        $this->initialized['message'] = true;
        $this->message = $message;
        return $this;
    }
}