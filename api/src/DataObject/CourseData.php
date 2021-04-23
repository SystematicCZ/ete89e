<?php

namespace App\DataObject;

use App\Entity\Professor;
use StartupJobsCom\Shared\DataObject\DataObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @method string getName()
 * @method string|null getDescription()
 * @method Professor getProfessor()
 */
class CourseData extends DataObject
{

    /**
     * @Assert\NotBlank
     * @Assert\Length(max="50")
     */
    protected ?string $name;

    /**
     * @Assert\NotBlank
     */
    protected ?string $description;

    /**
     * @Assert\NotBlank
     */
    protected ?Professor $professor;
}
