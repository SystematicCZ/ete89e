<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\View\UserView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users", methods={"GET"})
     *
     * @param UserRepository $repository
     * @param UserView $view
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
   public function users(UserRepository $repository, UserView $view): Response
   {
        $users = $repository->findAll();

        return $this->json($view->createList($users));
   }

    /**
     * @Route("/users/{id}", name="user", methods={"GET"})
     *
     * @param UserRepository $repository
     * @param UserView $view
     * @param int $id
     * @return Response
     */
   public function detail(UserRepository $repository, UserView $view, int $id): Response
   {
       return $this->json($view->create($repository->findOneBy(['id' => $id])));
   }
}
