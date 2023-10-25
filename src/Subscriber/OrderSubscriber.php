<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Subscriber;

use Madco\Tecsafe\Core\Checkout\Cart\LineItem\LineItemFactory;
use Madco\Tecsafe\Tecsafe\ApiClient;
use Psr\Log\LoggerInterface;
use Shopware\Core\Checkout\Cart\Event\CheckoutOrderPlacedEvent;
use Shopware\Core\PlatformRequest;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class OrderSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly ApiClient $apiClient,
        private readonly LoggerInterface $logger,
        private readonly ?RequestStack $requestStack
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            CheckoutOrderPlacedEvent::class => 'onOrderCreated',
        ];
    }

    public function onOrderCreated(CheckoutOrderPlacedEvent $event): void
    {
        if ($this->requestStack === null) {
            return;
        }

        $mainRequest = $this->requestStack->getMainRequest();

        $salesChannelContext = $mainRequest->attributes->get(PlatformRequest::ATTRIBUTE_SALES_CHANNEL_CONTEXT_OBJECT);

        if (!$salesChannelContext instanceof SalesChannelContext) {
            return;
        }

        $lineItems = $event->getOrder()->getLineItems();
        $item = null;

        foreach ($lineItems as $lineItem) {
            if ($lineItem->getType() === LineItemFactory::TYPE) {
                $item = $lineItem;
                break;
            }
        }

        if ($item === null) {
            return;
        }

        $payload = [
            'customer' => $salesChannelContext->getToken(),
            'price' => (int) $item->getPrice()->getTotalPrice(),
        ];

        try {
            $response = $this->apiClient->createOfcpOrderInApp($payload);
        } catch (
            ClientExceptionInterface
            |RedirectionExceptionInterface
            |ServerExceptionInterface
            |TransportExceptionInterface $e
        ) {
            $this->logger->error($e->getMessage(), [
                'exception' => $e,
            ]);

            return;
        }

        $response = json_decode($response, true);

        if (!isset($response['success']) || (bool) $response['success'] === false) {
            $prefix = 'Could not create OFCP order, reason';

            if (isset($response['message'])) {
                throw new \Exception($prefix . ': ' . $response['message']);
            }

            throw new \Exception($prefix . ' unknown. ' . json_encode($response));
        }
    }
}
