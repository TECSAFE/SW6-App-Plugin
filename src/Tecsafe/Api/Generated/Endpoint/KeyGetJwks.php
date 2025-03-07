<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Endpoint;

class KeyGetJwks extends \Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Client\BaseEndpoint implements \Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Client\Endpoint
{
    use \Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Client\EndpointTrait;
    public function getMethod(): string
    {
        return 'GET';
    }
    public function getUri(): string
    {
        return '/v1/jwks';
    }
    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null): array
    {
        return [[], null];
    }
    public function getExtraHeaders(): array
    {
        return ['Accept' => ['application/json']];
    }
    /**
     * {@inheritdoc}
     *
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\KeyGetJwksBadRequestException
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\KeyGetJwksTooManyRequestsException
     *
     * @return null
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return null;
        }
        if (is_null($contentType) === false && (400 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            throw new \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\KeyGetJwksBadRequestException($serializer->deserialize($body, 'Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorValidationResponse', 'json'), $response);
        }
        if (is_null($contentType) === false && (429 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            throw new \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\KeyGetJwksTooManyRequestsException($serializer->deserialize($body, 'Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorResponse', 'json'), $response);
        }
    }
    public function getAuthenticationScopes(): array
    {
        return [];
    }
}