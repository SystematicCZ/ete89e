<?php

namespace App\DataObject;

use StartupJobsCom\Shared\DataObject\DataObject;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method string getFirstName()
 * @method string|null getLastName()
 * @method string|null getEmail()
 * @method string|null getAboutMe()
 */
class UserData extends DataObject
{
    protected string $firstName;
    protected ?string $lastName;
    protected string $email;
    protected ?string $aboutMe;

    public static function fromRequest(Request $request): self
    {

    }
}
