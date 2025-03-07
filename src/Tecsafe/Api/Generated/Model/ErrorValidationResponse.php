<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Model;

class ErrorValidationResponse extends \ArrayObject
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
     * @var mixed
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
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
    /**
     * 
     *
     * @param mixed $message
     *
     * @return self
     */
    public function setMessage($message): self
    {
        $this->initialized['message'] = true;
        $this->message = $message;
        return $this;
    }
}