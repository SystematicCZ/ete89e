<?php

namespace App\Entity;

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


    public function __construct(string $name, \DateTimeInterface $date)
    {
        $this->id = null;
        $this->name = $name;
        $this->date = $date;
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
