<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RequestResponseSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [];
    }


    public function onResponse()
    {
    }

    public function onRequest()
    {
    }
}
