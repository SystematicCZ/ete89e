<?php

namespace App\Controller;

use App\Repository\ProfessorRepository;
use App\Service\RequestContentDecoder;
use App\View\ProfessorView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfessorController extends AbstractController
{
    /**
     * @Route("/professors", name="professors", methods={"GET"})
     *
     * @param Request $request
     * @param ProfessorRepository $repository
     * @param ProfessorView $view
     * @return Response
     */
    public function professors(Request $request, ProfessorRepository $repository, ProfessorView $view): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $search = $request->get('search', null);
        $professors = $search ? $repository->findByName($search) : $repository->findAll();

        return $this->json($view->createList($professors));
    }

}
