<?php

namespace App\Entity\User;

use App\Repository\User\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $role;

    /**
     * @ORM\Column(type="datetime")
     */
    private $loginAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return null|DateTimeInterface
     */
    public function getLoginAt(): ?DateTimeInterface
    {
        return $this->loginAt;
    }

    /**
     * @return $this
     */
    public function setLoginAt(): self
    {
        $this->loginAt = new DateTime();

        return $this;
    }

    /**
     * @return string[]
     */
    public function getRoles()
    {
        return [$this->role];
    }

    /**
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }
}
