<?php

namespace App\Entity;

use App\DataObject\CourseData;
use App\DataObject\EventsData;
use App\Repository\CourseRepository;
use App\Service\SlugifyService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="course", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private Collection $events;

    /**
     * @ORM\OneToMany(targetEntity="DiscussionEntry", mappedBy="course")
     */
    private Collection $discussionEntries;

    /**
     * @ORM\ManyToOne(targetEntity="Professor", inversedBy="courses")
     * @ORM\JoinColumn(name="professor_id", referencedColumnName="id")
     */
    private Professor $professor;

    /**
     * ORM\ManyToMany(targetEntity="User", mappedBy="courses")
     */
    private $users;

    private function __construct(string $slug, string $name, Professor $professor, ?string $description)
    {
        $this->id = null;
        $this->slug = $slug;
        $this->name = $name;
        $this->description = $description;
        $this->events = new ArrayCollection();
        $this->discussionEntries = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->professor = $professor;
    }

    public static function create(CourseData $data, SlugifyService $slugifyService, CourseRepository $repository): self
    {
        $instance = new self(
            $slugifyService->slugify($data->getName(), $repository), $data->getName(), $data->getProfessor(), $data->getDescription()
        );
        $data->getProfessor()->addCourse($instance);

        return $instance;
    }

    public function update(CourseData $courseData): self
    {
        $this->name = $courseData->getName();
        $this->description = $courseData->getDescription();
        $this->professor = $courseData->getProfessor();

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getEvents(): array
    {
        return $this->events->getValues();
    }

    public function getProfessor(): Professor
    {
        return $this->professor;
    }

    public function updateEvents(EventsData $data): self
    {
        $this->events->clear();
        foreach ($data->getEvents() as $event) {
            $this->events->add(Event::create($event, $this));
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
        }

        return $this;
    }
}
