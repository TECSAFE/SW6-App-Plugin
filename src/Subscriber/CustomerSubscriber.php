<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Subscriber;

use Madco\Tecsafe\Messages\TecsafeApi\MergeCustomerCommand;
use Madco\Tecsafe\Tecsafe\CustomerTokenStruct;
use Shopware\Core\Checkout\Customer\Event\CustomerLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class CustomerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private MessageBusInterface $messageBus,
    ){}

    public static function getSubscribedEvents(): array
    {
        return [
            CustomerLoginEvent::class => 'onCustomerLogin',
        ];
    }

    public function onCustomerLogin(CustomerLoginEvent $event): void
    {
        try {
            $session = $this->requestStack->getSession();
        } catch (SessionNotFoundException $sessionNotFoundException) {
            return;
        }

        $struct = $session->get(CustomerTokenStruct::API_ALIAS);

        if ($struct instanceof CustomerTokenStruct) {
            $fromCustomerIdentifier = $struct->getCustomerToken()->meta->customerIdentifier;
            $toCustomerIdentifier = $event->getSalesChannelContext()->getCustomer()->getId();

            if ($fromCustomerIdentifier !== $toCustomerIdentifier) {
                $this->messageBus->dispatch(
                    new MergeCustomerCommand(
                        $fromCustomerIdentifier,
                        $toCustomerIdentifier,
                        $event->getSalesChannelContext()->getToken(),
                        $event->getSalesChannelContext()->getSalesChannel()->getId(),
                    )
                );
            }
        }
    }
}
