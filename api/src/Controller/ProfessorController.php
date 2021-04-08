<?php

namespace App\Controller;

use App\Repository\ProfessorRepository;
use App\View\ProfessorView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfessorController extends AbstractController
{
    /**
     * @Route("/professors", name="professors", methods={"GET"})
     *
     * @param ProfessorRepository $repository
     * @return Response
     */
    public function professors(ProfessorRepository $repository, ProfessorView $view): Response
    {
        $professors = $repository->findAll();

        return $this->json($view->createList($professors));
    }
}
