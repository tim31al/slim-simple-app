<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */
class User
{

    public const ROLES = [
        'user' => 'ROLE_USER',
        'editor' => 'ROLE_EDITOR',
        'admin' => 'ROLE_ADMIN'
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;
    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected string $username;
    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected string $email;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected string $password;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected string $fullName;
    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    protected bool $active;
    /**
     * @ORM\Column(type="string", options={"default":"ROLE_USER"})
     */
    protected string $role;
    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $createdAt;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected DateTime $lastVisit;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->active = false;
    }


    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = in_array($role, self::ROLES) ? $role : self::ROLES['user'];
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @ORM\PrePersist
     *
     */
    public function cryptPass(): string
    {
        $pass = password_hash($this->password, PASSWORD_DEFAULT);
        $this->password = $pass ? $pass : $this->password;
        return $pass;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }


    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @return DateTime
     */
    public function getLastVisit(): DateTime
    {
        return $this->lastVisit;
    }

    /**
     * @param DateTime $lastVisit
     */
    public function setLastVisit(DateTime $lastVisit): void
    {
        $this->lastVisit = $lastVisit;

    }


}