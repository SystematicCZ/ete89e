<?php

namespace App\View;

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
        'aboutMe' => "null|string",
        'email' => "string"
    ])] public function create(User $user): array
    {
        return [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'fullName' => $user->getFullName(),
            'profilePicture' => $user->getProfilePicture(),
            'aboutMe' => $user->getAboutMe(),
            'email' => $user->getEmail(),
        ];
    }
}
