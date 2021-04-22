<?php

namespace App\Entity;

use App\DataObject\UserData;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
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
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $lastName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $aboutMe;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $faculty;

    /**
     * @ORM\ManyToMany(targetEntity="Course", inversedBy="users")
     * @ORM\JoinTable(name="users_to_courses")
     */
    private Collection $courses;

    private function __construct(string $firstName, ?string $lastName, string $email, string $faculty, ?string $aboutMe, ?string $image)
    {
        $this->id = null;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->aboutMe = $aboutMe;
        $this->image = $image;
        $this->faculty = $faculty;
        $this->courses = new ArrayCollection();
    }

    public static function create(UserData $data): self
    {
        $instance = new self(
            $data->getFirstName(),
            $data->getLastName(),
            $data->getEmail(),
            $data->getFaculty(),
            $data->getAboutMe(),
            $data->getImage()
        );
        return $instance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function getEmail(): string
    {
        return $this->email;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function updatePassword(string $password, UserPasswordEncoderInterface $encoder): self
    {
        $this->password = $encoder->encodePassword($this, $password);

        return $this;
    }

    public function getAboutMe(): ?string
    {
        return $this->aboutMe;
    }

    public function getFaculty(): string
    {
        return $this->faculty;
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }


    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @deprecated
     *
     * Not supported but dictated by the interface.
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * @deprecated
     *
     * Not supported but dictated by the interface.
     */
    public function getSalt(): ?string
    {
        return null;
    }

    public function getProfilePicture(): ?string
    {
        return $this->image;
    }

    public function toggleCourse(Course $course): self
    {
        if ($this->courses->contains($course)) {
            $this->courses->removeElement($course);
        } else {
            $this->courses->add($course);
        }

        return $this;
    }
}
