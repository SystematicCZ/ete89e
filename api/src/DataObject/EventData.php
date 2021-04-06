<?php

namespace App\DataObject;

use StartupJobsCom\Shared\DataObject\DataObject;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method string getName()
 * @method \DateTimeInterface getDate()
 */
class EventData extends DataObject
{
    protected string $name;
    protected \DateTimeInterface $date;

    public static function fromRequest(Request $request): self
    {

    }
}
