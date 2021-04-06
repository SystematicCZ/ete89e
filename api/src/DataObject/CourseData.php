<?php

namespace App\DataObject;

use App\Entity\Professor;
use StartupJobsCom\Shared\DataObject\DataObject;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method string getName()
 * @method string|null getDescription()
 * @method Professor getProfessor()
 */
class CourseData extends DataObject
{
    protected string $name;
    protected ?string $description;
    protected Professor $professor;

    public static function fromRequest(Request $request): self
    {

    }
}
