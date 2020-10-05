<?php
//declare(strict_types=1);

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
    private const USER = 'ROLE_USER';
    private const CREATOR = 'ROLE_CREATOR';
    private const ADMIN = 'ROLE_ADMIN';

    public const ROLES = [self::USER, self::CREATOR, self::ADMIN];

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
    protected string $fullname;
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
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $fullname
     * @param bool $active
     * @param string $role
     */
    public function __construct(string $username = '', string $email  = '', string $password = '',
                                string $fullname = '', bool $active = false, string $role = self::USER)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->fullname = $fullname;
        $this->active = $active;
        $this->role = $role;
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
        $this->role = in_array($role, self::ROLES) ? $role : self::USER;
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
     */
    public function cryptPass()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    /**
     * @return string
     */
    public function getFullname(): string
    {
        return $this->fullname;
    }

    /**
     * @param string $fullname
     */
    public function setFullname(string $fullname): void
    {
        $this->fullname = $fullname;
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
     * @param DateTime
     */
    public function setLastVisit(DateTime $lastVisit): void
    {
        $this->lastVisit = $lastVisit;

    }



}