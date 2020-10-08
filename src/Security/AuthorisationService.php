<?php


namespace App\Security;


use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use InvalidArgumentException;
use Laminas\Session\Config\StandardConfig;
use Laminas\Session\SessionManager;
use Laminas\Session\Storage\SessionArrayStorage;
use Psr\Container\ContainerInterface;

class AuthorisationService
{
    protected EntityRepository $er;
    protected StorageInterface $storage;
    protected string $username;
    protected string $password;

    /**
     * AuthorisationService constructor.
     *
     * @param ContainerInterface $container
     * @param StorageInterface|null $storage
     */
    public function __construct(ContainerInterface $container, StorageInterface $storage = null)
    {
        $this->er = $container
            ->get(EntityManager::class)
            ->getRepository(User::class);

        $this->storage = $storage ? $storage : $this->setSessionStorage();
    }

    private function setSessionStorage(ContainerInterface $container)
    {
        $config = new StandardConfig();
        $config->setOptions([
            'remember_me_seconds' => 3600,
            'name'                => $container->get('app_name'),
        ]);

        $manager = new SessionManager($config);

        $manager->setStorage(new SessionArrayStorage());

    }

    public function authenticate()
    {
        if (!$this->username || !$this->password )
            throw New InvalidArgumentException('username/password must be set to calling authenticate()');

        $user = $this->er->findOneBy(['username' => $this->username]);
        if (!$user instanceof User)
            return false;
        if (!password_verify($this->password, $user->getPassword()))
            return false;

        return true;
    }

    public function authorisation()
    {

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