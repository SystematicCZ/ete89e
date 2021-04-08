<?php

namespace App\DataObject;

use StartupJobsCom\Shared\DataObject\DataObject;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method array getEvents()
 */
class EventsData extends DataObject
{
    /**
     * @var \App\DataObject\EventData[]
     */
    protected array $events;

    public static function fromRequest(Request $request): self
    {

    }
}
