<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Exception;

class AuthLoginInternalBadRequestException extends BadRequestException
{
    /**
     * @var \Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorValidationResponse
     */
    private $errorValidationResponse;
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $response;
    public function __construct(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorValidationResponse $errorValidationResponse, \Psr\Http\Message\ResponseInterface $response)
    {
        parent::__construct('Bad request, invalid input (see response for details)');
        $this->errorValidationResponse = $errorValidationResponse;
        $this->response = $response;
    }
    public function getErrorValidationResponse(): \Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorValidationResponse
    {
        return $this->errorValidationResponse;
    }
    public function getResponse(): \Psr\Http\Message\ResponseInterface
    {
        return $this->response;
    }
}