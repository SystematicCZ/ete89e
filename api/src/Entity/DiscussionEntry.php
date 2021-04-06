<?php

namespace App\Entity;

use App\Repository\DiscussionEntryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiscussionEntryRepository::class)
 */
class DiscussionEntry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="text")
     */
    private string $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $date;

    /**
     * @ORM\OneToMany(targetEntity="DiscussionEntry", mappedBy="answersTo")
     */
    private Collection $answers;

    /**
     * @ORM\ManyToOne(targetEntity="DiscussionEntry", inversedBy="answers")
     * @ORM\JoinColumn(name="entry_id", referencedColumnName="id", nullable=true)
     */
    private ?DiscussionEntry $answerTo;

    public function __construct(string $text, \DateTimeInterface $date)
    {
        $this->id = null;
        $this->text = $text;
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function isAnswerTo(): ?self
    {
        return $this->answerTo;
    }

    /**
     * @return self[]
     */
    public function getAnswers(): array
    {
        return $this->answers->getValues();
    }

    public function addAnswer(self $answer): self
    {
        $this->answers->add($answer);
        $answer->setAnswerTo($this);

        return $this;
    }

    public function setAnswerTo(self $entry): self
    {
        $this->answerTo = $entry;
        return $this;
    }
}
