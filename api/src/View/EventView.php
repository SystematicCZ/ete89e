<?php

namespace App\View;

use App\Entity\Event;
use JetBrains\PhpStorm\ArrayShape;

class EventView
{
    public function create(Event $event): array
    {
        return [
            'id' => $event->getId(),
            'name' => $event->getName(),
            'date' => [
                'date' => $event->getDate()->format('Y-m-d'),
                'time' => $event->getDate()->format('H:i'),
            ],
        ];
    }
}
