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
     * @param ProfessorRepository $repository
     * @return Response
     */
    public function professors(ProfessorRepository $repository, ProfessorView $view): Response
    {
        $professors = $repository->findAll();

        return $this->json($view->createList($professors));
    }

    /**
     * @Route("/professors/search", name="test", methods={"POST"})
     *
     * @param Request $request
     * @param ProfessorRepository $repository
     * @param ProfessorView $view
     * @return Response
     */
    public function findByName(Request $request, ProfessorRepository $repository, ProfessorView $view, RequestContentDecoder $contentDecoder): Response
    {
        $search =  $contentDecoder->decodeIfJson($request)['search'];
        return $this->json($view->createList($repository->findByName($search)));
    }
}
