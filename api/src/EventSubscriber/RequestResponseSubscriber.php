<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class RequestResponseSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => 'onRequest',
            ResponseEvent::class => 'onResponse',
        ];
    }


    public function onResponse(ResponseEvent $event): void
    {
        dump(
            [
                'contentType' => $event->getResponse()->headers->get('content-type'),
                'content' => json_encode(json_decode($event->getResponse()->getContent(), true), JSON_PRETTY_PRINT),
            ]
        );
    }

    public function onRequest(RequestEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        dump(
            [
                'method' => $event->getRequest()->getMethod(),
                'uri' => $event->getRequest()->getUri(),
                'body' => json_encode(json_decode($event->getRequest()->getContent(), true), JSON_PRETTY_PRINT),
            ]
        );
    }
}
