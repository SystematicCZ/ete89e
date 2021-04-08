<?php

namespace App\DataObject;

use StartupJobsCom\Shared\DataObject\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Properties cannot be accessed directly.
 * Calling these method before validations results in exception
 *
 * @method string getName()
 * @method \DateTimeInterface getDate()
 */
class EventData extends DataObject
{
    /**
     * @Assert\NotBlank()
     */
    protected string $name;

    /**
     * @Assert\InFuture()
     */
    protected \DateTimeInterface $date;
}
