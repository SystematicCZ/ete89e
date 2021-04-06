<?php

namespace App\Entity;

use App\DataObject\UserData;
use App\Repository\UserRepository;
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
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $aboutMe;

    private function __construct(string $firstName, ?string $lastName, string $email, ?string $aboutMe)
    {
        $this->id = null;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->aboutMe = $aboutMe;
    }

    public static function create(UserData $data): self
    {
        $instance = new self($data->getFirstName(), $data->getLastName(), $data->getEmail(), $data->getAboutMe());
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

    public function getRoles(): array
    {
        return [];
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
}
