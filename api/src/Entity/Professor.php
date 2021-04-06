<?php

namespace App\Entity;

use App\Repository\ProfessorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfessorRepository::class)
 */
class Professor
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
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $degree;

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="professor")
     */
    private Collection $courses;

    public function __construct(string $name, ?string $degree = null)
    {
        $this->id = null;
        $this->name = $name;
        $this->degree = $degree;
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDegree(): ?string
    {
        return $this->degree;
    }

    public function getCourses(): array
    {
        return $this->courses->getValues();
    }

    public function addCourse(Course $course): self
    {
        if(!$this->courses->contains($course)){
            $this->courses->add($course);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if($this->courses->contains($course)){
            $this->courses->removeElement($course);
        }

        return $this;
    }
}
