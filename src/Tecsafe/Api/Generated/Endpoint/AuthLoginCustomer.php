<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Endpoint;

class AuthLoginCustomer extends \Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Client\BaseEndpoint implements \Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Client\Endpoint
{
    /**
     * 
     *
     * @param \Madco\Tecsafe\Tecsafe\Api\Generated\Model\CustomerLoginRequest $requestBody 
     */
    public function __construct(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\CustomerLoginRequest $requestBody)
    {
        $this->body = $requestBody;
    }
    use \Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Client\EndpointTrait;
    public function getMethod(): string
    {
        return 'POST';
    }
    public function getUri(): string
    {
        return '/v1/auth/customer';
    }
    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null): array
    {
        if ($this->body instanceof \Madco\Tecsafe\Tecsafe\Api\Generated\Model\CustomerLoginRequest) {
            return [['Content-Type' => ['application/json']], $serializer->serialize($this->body, 'json')];
        }
        return [[], null];
    }
    public function getExtraHeaders(): array
    {
        return ['Accept' => ['application/json']];
    }
    /**
     * {@inheritdoc}
     *
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginCustomerBadRequestException
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginCustomerTooManyRequestsException
     *
     * @return null
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (is_null($contentType) === false && (201 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            return json_decode($body);
        }
        if (is_null($contentType) === false && (400 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            throw new \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginCustomerBadRequestException($serializer->deserialize($body, 'Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorValidationResponse', 'json'), $response);
        }
        if (is_null($contentType) === false && (429 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            throw new \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginCustomerTooManyRequestsException($serializer->deserialize($body, 'Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorResponse', 'json'), $response);
        }
    }
    public function getAuthenticationScopes(): array
    {
        return [];
    }
}