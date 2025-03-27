<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Exception;

class KeyGetJwksTooManyRequestsException extends TooManyRequestsException
{
    /**
     * @var \Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorResponse
     */
    private $errorResponse;
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $response;
    public function __construct(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorResponse $errorResponse, \Psr\Http\Message\ResponseInterface $response)
    {
        parent::__construct('Too many requests');
        $this->errorResponse = $errorResponse;
        $this->response = $response;
    }
    public function getErrorResponse(): \Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorResponse
    {
        return $this->errorResponse;
    }
    public function getResponse(): \Psr\Http\Message\ResponseInterface
    {
        return $this->response;
    }
}