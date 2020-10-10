<?php


namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;

class AuthenticationService
{
    const STORAGE_KEY = 'identity';

    protected EntityRepository $er;
    protected StorageInterface $storage;
    protected string $username;
    protected string $password;

    /**
     * AuthenticationService constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->er = $container
            ->get(EntityManager::class)
            ->getRepository(User::class);

        $this->storage = $container->get(SessionStorage::class);

        $this->username = $this->password = '';
    }

    /**
     * @return Result
     */
    public function authenticate(): Result
    {
        if (null === $this->username || null === $this->password)
            throw new InvalidArgumentException('username/password must be set to calling authenticate()');


        $user = $this->er->findOneBy(['username' => $this->username]);

        if (!$user instanceof User) {
            $result = new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                $this->username,
                array('Username Not Found.')
            );
        } else if (!password_verify($this->password, $user->getPassword())) {
            $result = new Result(
                Result::FAILURE_CREDENTIAL_INVALID,
                $this->username,
                array('Invalid password.'));
        } else {
            $result = new Result(
                Result::SUCCESS,
                [
                    'username' => $user->getUsername(),
                    'fullName' => $user->getFullName(),
                    'role' => $user->getRole()
                ]
            );
        }

        if ($this->hasIdentity()) {
            $this->clearIdentity();
        }

        if ($result->isValid()) {
            $this->storage->write(self::STORAGE_KEY, $result->getIdentity());
        }

        return $result;
    }

    public function authorisation($role = 'user'): bool
    {
        if (!$this->hasIdentity())
            return false;

        if (! array_key_exists($role, User::ROLES))
            throw new InvalidArgumentException('Role not found in ' . User::class . '.');

        $statement = false;
        $currentRole = $this->getRole();

        switch ($role) {
            case 'user':
                $statement = true;
                break;
            case 'editor':
                if ($currentRole === User::ROLES['editor'] ||
                $currentRole === User::ROLES['admin'])
                    $statement = true;
                break;

            case 'admin':
                if ($currentRole === User::ROLES['admin'])
                    $statement = true;
                break;
        }

        return $statement;
    }

    /**
     * Returns true if and only if an identity is available from storage
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->storage->hasKey(self::STORAGE_KEY);
    }

    /**
     * Returns the identity from storage or null if no identity is available
     *
     * @return mixed|null
     */
    public function getIdentity()
    {
        if ($this->storage->isEmpty(self::STORAGE_KEY)) {
            return null;
        }

        return $this->storage->read(self::STORAGE_KEY);
    }

    /**
     * Clears the identity from persistent storage
     *
     * @return void
     */
    public function clearIdentity()
    {
        $this->storage->clear(self::STORAGE_KEY);
    }

    /**
     * Return role identity
     *
     * @return string|null
     */
    public function getRole()
    {
        if ($this->hasIdentity()) {
            return $this->storage->read(self::STORAGE_KEY)['role'];
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isUser()
    {
        return User::ROLES['user'] === $this->getRole();
    }

    /**
     * @return bool
     */
    public function isEditor()
    {
        return User::ROLES['editor'] === $this->getRole();
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return User::ROLES['admin'] === $this->getRole();
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


}