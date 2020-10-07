<?php


namespace App\Middleware;


use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use function count;

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
        $username = null;
        $password = null;


        if (isset($_SESSION['user'])) {
            return $handler->handle($request);
        }
        if (isset($_SERVER["HTTP_AUTHORIZATION"]) && 0 === stripos($_SERVER["HTTP_AUTHORIZATION"], 'basic ')) {
            $exploded = explode(':', base64_decode(substr($_SERVER["HTTP_AUTHORIZATION"], 6)), 2);
            if (2 == count($exploded)) {
                list($username, $password) = $exploded;
            }
        } elseif (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];
        }

        $isValidUser = $username && $password && $this->checkUser($username, $password);
        if ($isValidUser) {
            $_SESSION['user'] = $username;
            return $handler->handle($request);
        }

        return (new Response())
            ->withHeader('WWW-Authenticate',
                'Basic realm="Access to site", charset="UTF-8');

    }

    private function checkUser($username, $password): bool
    {
        $username = htmlspecialchars($username);
        $user = $this->userRepository->findOneBy(['username' => $username]);
        if (!$user instanceof User)
            return false;

        return password_verify($password, $user->getPassword());
    }
}