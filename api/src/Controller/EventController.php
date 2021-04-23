<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{

    /**
     * @Route("/events/{id}", name="event_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     *
     * @param Event $event
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Event $event, EntityManagerInterface $manager): Response
    {
        $event->getCourse()->removeEvent($event);
        $manager->flush();

        return $this->json(null);
    }

}
