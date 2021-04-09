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

    /**
     * @Route("/professors/find/{search}", name="test", methods={"GET"})
     *
     * @return Response
     */
    public function findByName(ProfessorRepository $repository, string $search, ProfessorView $view): Response
    {
        return $this->json($view->createList($repository->findByName($search)));
    }
}
