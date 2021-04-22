<?php

namespace App\Controller;

use App\DataObject\CourseData;
use App\Entity\Course;
use App\Repository\CourseRepository;
use App\Service\RequestContentDecoder;
use App\View\CoursesView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    private CourseRepository $repository;
    private CoursesView $coursesView;

    public function __construct(CourseRepository $repository, CoursesView $coursesView)
    {
        $this->repository = $repository;
        $this->coursesView = $coursesView;
    }

    /**
     * @Route("/courses/search", name="course_search", methods={"POST"})
     *
     * @param Request $request
     * @param RequestContentDecoder $contentDecoder
     * @return Response
     * @throws \Exception
     */
    public function findByName(Request $request, RequestContentDecoder $contentDecoder): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');

        $search =  $contentDecoder->decodeIfJson($request)['search'];
        return $this->json($this->coursesView->createList($this->repository->findByName($search)));
    }

    /**
     * @Route("/courses", name="courses", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');

        return $this->json(
            $this->coursesView->createList($this->repository->findAll()),
        );
    }

    /**
     * @Route("/courses/{id}", name="course", methods={"GET"}, requirements={"id"="\d+"})
     * @return Response
     */
    public function detail(Course $course): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');

        return $this->json(
            $this->coursesView->create($course),
        );
    }

    /**
     * @Route("/courses/{id}", name="course_update", methods={"POST"}, requirements={"id"="\d+"})
     *
     * @param Course $course
     * @return Response
     */
    public function update(Request $request, Course $course, CourseData $courseData): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');

        dd($courseData);
        return $this->json($this->coursesView->create($course));
    }

}
