<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Endpoint;

class MergeControllerMigrateFromCustomer extends \Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Client\BaseEndpoint implements \Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Client\Endpoint
{
    /**
     * 
     *
     * @param \Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromCustomerRequest $requestBody 
     */
    public function __construct(\Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromCustomerRequest $requestBody)
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
        return '/v1/merge/by-token';
    }
    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null): array
    {
        if ($this->body instanceof \Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromCustomerRequest) {
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
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\MergeControllerMigrateFromCustomerBadRequestException
     * @throws \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\MergeControllerMigrateFromCustomerTooManyRequestsException
     *
     * @return null
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (204 === $status) {
            return null;
        }
        if (is_null($contentType) === false && (400 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            throw new \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\MergeControllerMigrateFromCustomerBadRequestException($serializer->deserialize($body, 'Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorValidationResponse', 'json'), $response);
        }
        if (is_null($contentType) === false && (429 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            throw new \Madco\Tecsafe\Tecsafe\Api\Generated\Exception\MergeControllerMigrateFromCustomerTooManyRequestsException($serializer->deserialize($body, 'Madco\Tecsafe\Tecsafe\Api\Generated\Model\ErrorResponse', 'json'), $response);
        }
    }
    public function getAuthenticationScopes(): array
    {
        return [];
    }
}