<?php


namespace App\Security;

use Laminas\Authentication\Result;
use Laminas\Authentication\Storage\Session as SessionStorage;
use Laminas\Db\Adapter\Adapter as DbAdapter;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;
use Laminas\Authentication\AuthenticationService;
use Psr\Container\ContainerInterface;

class Auth
{
    protected DbAdapter $dbAdapter;
    protected AuthAdapter $authAdapter;
    protected AuthenticationService $auth;

    /**
     * Auth constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $dbAdapter = new DbAdapter([
            'driver' => 'Pdo_Mysql',
            'fixtures' => $container->get('fixtures')['name'],
            'username' => $container->get('fixtures')['user'],
            'password' => $container->get('fixtures')['password'],
            'hostname' => $container->get('fixtures')['host'],
            'port' => $container->get('fixtures')['port']
        ]);

        $passwordValidation = function ($hash, $password) {
            return password_verify($password, $hash);
        };

        $this->authAdapter = new AuthAdapter(
            $dbAdapter,
            'user',
            'username',
            'password',
            $passwordValidation
            );

        $this->auth = new AuthenticationService();

        $storage = new SessionStorage('MyApp');
        $this->auth->setStorage($storage);
    }

    public function identity($username, $password): Result {
        $this->authAdapter
            ->setIdentity($username)
            ->setCredential($password);

        return $this->auth->authenticate($this->authAdapter);
    }



}