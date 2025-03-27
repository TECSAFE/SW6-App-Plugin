<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Api\Controller;

use Madco\Tecsafe\Messages\Webhook\CartUpdatedEventReceived;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @deprecated
 */
#[Route(defaults: ['_routeScope' => ['api']])]
class WebhookController
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $messageBus
    ) {
        $this->messageBus = $messageBus;
    }

    #[Route(
        path: '/api/tecsafe/ofcp/webhook',
        name: 'api.tecsafe.ofcp.webhook',
        methods: ['POST']
    )]
    public function index(Request $request): JsonResponse
    {
        $fullData = json_decode($request->getContent(), true);
        $event = $fullData['event'];
        $data = $fullData['data'];

        if ($event === 'cart:updated') {
            $message = new CartUpdatedEventReceived($data);

            $result = $this->handle($message);

            return new JsonResponse([
                'success' => true,
            ]);
        }

        return new JsonResponse(
            [
                'error' => 'Invalid event.',
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
