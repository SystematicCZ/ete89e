<?php

namespace App\View;

use App\Entity\Professor;
use JetBrains\PhpStorm\ArrayShape;

class ProfessorView
{
    public function create(Professor $professor): array
    {
        return [
            'id' => $professor->getId(),
            'name' => $professor->getName(),
            'title' => $professor->getDegree(),
        ];
    }
}
