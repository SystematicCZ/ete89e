<?php

namespace App\View;

use App\Entity\Course;
use App\Entity\Professor;
use JetBrains\PhpStorm\ArrayShape;

class ProfessorView
{
    public function createList(array $professors): array
    {
        return array_map(fn(Professor $professor) => $this->create($professor), $professors);
    }

    #[ArrayShape(['id' => "int|null", 'name' => "string", 'title' => "null|string", 'courses' => "array|array[]"])]
    public function create(
        Professor $professor
    ): array {
        return [
            'id' => $professor->getId(),
            'name' => $professor->getName(),
            'title' => $professor->getDegree(),
            'courses' => array_map(fn(Course $course) => $this->transformCourse($course), $professor->getCourses()),
        ];
    }

    #[ArrayShape(['id' => "int|null", 'slug' => "string", 'name' => "string"])]
    private function transformCourse(Course $course): array
    {
        return [
            'id' => $course->getId(),
            'slug' => $course->getSlug(),
            'name' => $course->getName(),
        ];
    }
}
