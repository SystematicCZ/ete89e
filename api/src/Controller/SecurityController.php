<?php

namespace App\Controller;

use App\View\UserView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(UserView $view): Response
    {
        $user = $this->getUser();

        return $this->json($view->create($user));
    }

    /**
     * @Route("/logout", name="logout", methods={"POST"})
     */
    public function logout(): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');

        return $this->json('');
    }
}
