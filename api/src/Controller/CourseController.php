<?php

namespace App\Controller;

use App\DataObject\CourseData;
use App\Entity\Course;
use App\Entity\User;
use App\Repository\CourseRepository;
use App\Service\SlugifyService;
use App\View\CoursesView;
use App\View\UserView;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/courses", name="courses", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function list(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $search = $request->get('search', null);
        $courses = $search ? $this->repository->findByName($search) : $this->repository->findAll();

        return $this->json(
            $this->coursesView->createList($courses),
        );
    }

    /**
     * @Route("/courses/{id}", name="course", methods={"GET"}, requirements={"id"="\d+"})
     * @param Course $course
     * @return Response
     */
    public function detail(Course $course): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->json(
            $this->coursesView->create($course),
        );
    }

    /**
     * @Route("/courses/{id}", name="course_update", methods={"PUT"}, requirements={"id"="\d+"})
     *
     * @param Request $request
     * @param Course $course
     * @param CourseData $courseData
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function update(Request $request, Course $course, CourseData $courseData, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $course->update($courseData);
        $manager->flush();


        return $this->json($this->coursesView->create($course));
    }

    /**
     * @Route("/courses/{id}/toggle_subscription", name="course_subscription", methods={"POST"}, requirements={"id"="\d+"})
     *
     * @param Request $request
     * @param Course $course
     * @param UserView $userView
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function toggleSubscription(Request $request, Course $course, UserView $userView, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /**
         * @var $user User
         */
        $user = $this->getUser();
        $user->toggleCourse($course);

        $manager->flush();

        return $this->json($userView->create($user));
    }

    /**
     * @Route("/courses", name="course_update", methods={"POST"})
     *
     * @param CourseData $data
     * @param EntityManagerInterface $manager
     * @param SlugifyService $slugifyService
     * @return Response
     */
    public function add(CourseData $data, EntityManagerInterface $manager, SlugifyService $slugifyService): Response
    {
        $course = Course::create($data, $slugifyService, $this->repository);
        $manager->persist($course);
        $manager->flush();

        return $this->json($this->coursesView->create($course));
    }
}
