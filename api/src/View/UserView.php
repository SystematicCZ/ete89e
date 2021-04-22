<?php

namespace App\View;

use App\Entity\Course;
use App\Entity\User;
use JetBrains\PhpStorm\ArrayShape;

class UserView
{
    public function createList(array $users): array
    {
        $result = [];

        foreach ($users as $user) {
            $result[] = $this->create($user);
        }

        return $result;
    }

    #[ArrayShape([
        'id' => "int|null",
        'firstName' => "string",
        'lastName' => "null|string",
        'fullName' => "string",
        'profilePicture' => "null|string",
        'faculty' => "string",
        'aboutMe' => "null|string",
        'email' => "string",
        'courses' => 'array'
    ])] public function create(User $user): array
    {
        return [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'fullName' => $user->getFullName(),
            'profilePicture' => $user->getProfilePicture(),
            'faculty' => $user->getFaculty(),
            'aboutMe' => $user->getAboutMe(),
            'email' => $user->getEmail(),
            'courses' => array_map(fn(Course $course) => $this->transformCourse($course), $user->getCourses()),
        ];
    }

    #[ArrayShape(['id' => "int|null", 'name' => "string", 'slug' => "string"])]
    private function transformCourse(Course $course): array
    {
        return [
            'id' => $course->getId(),
            'name' => $course->getName(),
            'slug' => $course->getSlug(),
        ];
    }
}
