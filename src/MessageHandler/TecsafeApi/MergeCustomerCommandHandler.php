<?php

declare(strict_types=1);

namespace Madco\Tecsafe\MessageHandler\TecsafeApi;

use Madco\Tecsafe\Messages\TecsafeApi\MergeCustomerCommand;
use Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromSalesChannelRequest;
use Madco\Tecsafe\Tecsafe\ApiClient;
use Shopware\Core\System\SalesChannel\Context\AbstractSalesChannelContextFactory;

readonly class MergeCustomerCommandHandler
{
    public function __construct(
        private ApiClient $apiClient,
        private AbstractSalesChannelContextFactory $salesChannelContextFactory
    ){}

    public function __invoke(MergeCustomerCommand $command): void
    {
        $salesChannelContext = $this->salesChannelContextFactory->create(
            $command->salesChannelContextToken,
            $command->salesChannelId
        );

        $salesChannelJwt = $this->apiClient->loginSalesChannel($salesChannelContext);

        $response = $this->apiClient->mergeControllerMigrateFromSalesChannel(
            (new MergeFromSalesChannelRequest())
                ->setFromId($command->fromCustomerIdentifier)
                ->setToId($command->toCustomerIdentifier)
                ->setToken($salesChannelJwt->token)
        );
    }
}
