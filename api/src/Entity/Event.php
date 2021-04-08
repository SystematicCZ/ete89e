<?php

namespace App\Entity;

use App\DataObject\EventData;
use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $date;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="events")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private Course $course;


    private function __construct(string $name, \DateTimeInterface $date, Course $course)
    {
        $this->id = null;
        $this->name = $name;
        $this->date = $date;
        $this->course = $course;
    }

    public static function create(EventData $data, Course $course): self
    {
        return new self($data->getName(), $data->getDate(), $course);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }
}
