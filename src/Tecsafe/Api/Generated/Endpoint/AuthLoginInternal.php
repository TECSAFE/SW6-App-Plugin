<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Endpoint;

class AuthLoginInternal extends \Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Client\BaseEndpoint implements \Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Client\Endpoint
{
    /**
     * 
     *
     * @param \Madco\Tecsafe\Tecsafe\Api\Generated\Model\LoginRequest $requestBody 
     */
    public function __construct(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\LoginRequest $requestBody)
    {
        $this->body = $requestBody;
    }
    use \Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Client\EndpointTrait;
    public function getMethod(): string
    {
        return 'GET';
    }
    public function getUri(): string
    {
        return '/v1/auth/internal';
    }
    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null): array
    {
        if ($this->body instanceof \Madco\Tecsafe\Tecsafe\Api\Generated\Model\LoginRequest) {
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
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginInternalBadRequestException
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginInternalTooManyRequestsException
     *
     * @return null
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (is_null($contentType) === false && (200 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            return json_decode($body);
        }
        if (is_null($contentType) === false && (400 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            throw new \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginInternalBadRequestException($serializer->deserialize($body, 'Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorValidationResponse', 'json'), $response);
        }
        if (is_null($contentType) === false && (429 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            throw new \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\AuthLoginInternalTooManyRequestsException($serializer->deserialize($body, 'Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorResponse', 'json'), $response);
        }
    }
    public function getAuthenticationScopes(): array
    {
        return [];
    }
}