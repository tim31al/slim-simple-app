<?php


namespace Lib\Middleware;


use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AuthenticationMiddleware
{

    private EntityRepository $userRepository;

    /**
     * AuthenticationMiddleware constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->userRepository = ($container->get(EntityManager::class))->getRepository(User::class);
    }


    public function __invoke(Request $request, RequestHandler $handler)
    {

        if (!isset($_SERVER['PHP_AUTH_USER'])
            || !isset($_SERVER['PHP_AUTH_PW'])
            || !$this->checkUser($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {

            return (new Response())
                ->withHeader('WWW-Authenticate',
                    'Basic realm="Access to site", charset="UTF-8');

        } else {
            unset($_SERVER['PHP_AUTH_USER']);
            unset($_SERVER['PHP_AUTH_PW']);

            return $handler->handle($request);
        }

    }

    private function checkUser($username, $password): bool
    {
        $username = htmlspecialchars($username);
        $user = $this->userRepository->findOneBy(['username' => $username]);
        if (! $user instanceof User)
            return false;

        return password_verify($password, $user->getPassword());
    }
}