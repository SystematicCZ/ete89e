<?php

namespace App\Controller;

use App\Repository\ProfessorRepository;
use App\Repository\UserRepository;
use App\Service\RequestContentDecoder;
use App\View\ProfessorView;
use App\View\UserView;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users", methods={"GET"})
     *
     * @param Request $request
     * @param UserRepository $repository
     * @param UserView $view
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
   public function users(Request $request, UserRepository $repository, UserView $view): Response
   {
       $this->denyAccessUnlessGranted('ROLE_USER');

       $search = $request->get('search', null);
       $users = $search ? $repository->findByName($search) : $repository->findAll();

        return $this->json($view->createList($users));
   }

    /**
     * @Route("/users/{id}", name="user", methods={"GET"}, requirements={"id"="\d+"}))
     *
     * @param UserRepository $repository
     * @param UserView $view
     * @param int $id
     * @return Response
     */
   public function detail(UserRepository $repository, UserView $view, int $id): Response
   {
       $this->denyAccessUnlessGranted('ROLE_USER');

       return $this->json($view->create($repository->findOneBy(['id' => $id])));
   }

}
