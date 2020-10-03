<?php


namespace App\Model;

use DateTime;
use InvalidArgumentException;
use PDO;
use phpDocumentor\Reflection\Types\Object_;

class User extends BaseModel implements IdentityInterface
{
    protected const TABLE = 'user';

    protected const ROLES = ['user' => 'ROLE_USER', 'creator' => 'ROLE_CREATOR', 'admin' => 'ROLE_ADMIN'];

    protected int $id;

    protected string $username;

    protected string $email;

    protected string $password;

    protected string $fullName;

    protected string $role;

    protected DateTime $createdAt;


    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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

    private function cryptPassword(): string
    {
        return password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 9]);
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
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        if (!in_array($role, self::ROLES))
            throw new InvalidArgumentException('Role not declared');

        $this->role = $role;
    }

    public function login(): bool
    {
        $sql = 'SELECT * FROM ' . self::TABLE . ' WHERE username=:username';
        $smtp = $this->pdo->prepare($sql);
        $smtp->bindParam(':username', $this->username);
        $smtp->execute();

        $user = $smtp->fetch();

        if (empty($user))
            return false;

        if (!password_verify($this->password, $user['password']))
            return false;

        unset($user['password']);

        $_SESSION['user'] = serialize($user);

        return true;
    }

    public static function logout()
    {
        if (isset($_SESSION['user']))
            unset($_SESSION['user']);
    }


    public static function isLogged(): bool
    {
        if (isset($_SESSION['user']))
            return true;

        return false;
    }

    public function isCreator(): bool
    {
        return $this->role === self::ROLES['creator'];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLES['admin'];
    }

    public function create(): int
    {
        if (empty($this->role))
            $this->role = self::ROLES['user'];
        if (empty($this->createdAt))
            $this->setCreatedAt();

        if (!$this->validate())
            throw new InvalidArgumentException('Empty or incorrect data data');

        $sql = "INSERT INTO user (
                  username, email, password, 
                  fullname, role, createdAt) VALUES (:username, :email, :password, 
                                                     :fullname, :role, :createdAt)";

        $smtp = $this->pdo->prepare($sql);
        $smtp->bindParam(':username', $this->username);
        $smtp->bindParam(':email', $this->email);

        $pass = $this->cryptPassword();
        $smtp->bindParam(':password', $pass);

        $smtp->bindParam(':fullname', $this->fullName);
        $smtp->bindParam(':role', $this->role);

        $date = $this->createdAt->format('Y-m-d H:i:s');
        $smtp->bindParam(':createdAt', $date);

        $smtp->execute();

        $this->id = $this->pdo->lastInsertId();

        return $this->id;
    }

    public function read(int $id = null)
    {
        if ($id) {
            $sql = "SELECT * FROM " . self::TABLE . " WHERE id=:id LIMIT 1";
            $smtp = $this->pdo->prepare($sql);
            $smtp->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM user";
            $smtp = $this->pdo->prepare($sql);
        }
        $smtp->execute();

        return $id ? $smtp->fetch() : $smtp->fetchAll();
    }

    public function update(): bool
    {
        if (!$this->validate(false)) {
            throw new InvalidArgumentException('Empty or incorrect data data');
        }

        $sql = "UPDATE user SET username=:username, email=:email, password=:password, fullname=:fullname, role=:role WHERE id=:id";

        $smtp = $this->pdo->prepare($sql);
        $smtp->bindParam(':id', $this->id);
        $smtp->bindParam(':username', $this->username);
        $smtp->bindParam(':email', $this->email);
        $smtp->bindParam(':password', $this->password);
        $smtp->bindParam(':fullname', $this->fullName);
        $smtp->bindParam(':role', $this->role);

        return $smtp->execute();
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM " . self::TABLE . " WHERE id=:id";
        $smtp = $this->pdo->prepare($sql);
        $smtp->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $smtp->execute();
    }

    public function validate($isNew = true): bool
    {

        $isValid =
            !empty($this->username) &&
            !empty($this->email) &&
            !empty($this->password) &&
            !empty($this->role);

        $isValid &= (bool)filter_var($this->email, FILTER_VALIDATE_EMAIL);

        return $isNew ? $isValid && empty($this->id) : !empty($this->id);
    }
}