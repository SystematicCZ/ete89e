<?php

namespace App\View;

use App\Entity\Course;
use App\Entity\Event;
use JetBrains\PhpStorm\ArrayShape;

class CoursesView
{
    private ProfessorView $professorView;
    private EventView $eventView;

    public function __construct(ProfessorView $professorView, EventView $eventView)
    {
        $this->professorView = $professorView;
        $this->eventView = $eventView;
    }

    /**
     * Creates list view for given courses
     *
     * @param array $courses
     * @return array
     */
    public function createList(array $courses): array
    {
        return array_map(
            fn(Course $course) => $this->create($course),
            $courses
        );
    }

    #[ArrayShape([
        'id' => "int|null",
        'slug' => "string",
        'name' => "string",
        'description' => "null|string",
        'professor' => "array",
        'events' => "array|array[]"
    ])] public function create(Course $course): array
    {
        return [
            'id' => $course->getId(),
            'slug' => $course->getSlug(),
            'name' => $course->getName(),
            'description' => $course->getDescription(),
            'professor' => $this->professorView->create($course->getProfessor()),
            'events' => array_map(fn(Event $event) => $this->eventView->create($event), $course->getEvents()),
        ];
    }
}
