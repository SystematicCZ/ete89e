<?php

namespace App\DataObject;

use StartupJobsCom\Shared\DataObject\DataObject;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method string getFirstName()
 * @method string|null getLastName()
 * @method string getEmail()
 * @method string|null getAboutMe()
 * @method string|null getImage()
 * @method string getFaculty()
 */
class UserData extends DataObject
{
    protected string $firstName;
    protected ?string $lastName;
    protected string $email;
    protected ?string $aboutMe;
    protected ?string $image;
    protected string $faculty;

    public static function fromRequest(Request $request): self
    {

    }
}
