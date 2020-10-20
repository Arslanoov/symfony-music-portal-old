<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ErrorEventListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onError',
        ];
    }

    public function onError(ExceptionEvent $event)
    {
        $e = $event->getThrowable();
        $event->setResponse(new JsonResponse([
            'message' => $e->getMessage()
        ], $e->getCode() === 0 ? 500 : $e->getCode()));
    }
}
