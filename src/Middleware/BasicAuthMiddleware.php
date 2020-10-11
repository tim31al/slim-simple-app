<?php


namespace App\Middleware;

use App\Service\AuthenticationService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use function count;

class BasicAuthMiddleware
{

    private AuthenticationService $authService;
    private string $appName;
    private string $role;

    /**
     * AuthenticationMiddleware constructor.
     * @param ContainerInterface $container
     * @param string|null $role
     */
    public function __construct(ContainerInterface $container, $role = null)
    {
        $this->authService = $container->get(AuthenticationService::class);
        $this->appName = $container->get('app_name');
        if (null !== $role)
            $this->role = $role;
    }


    public function __invoke(Request $request, RequestHandler $handler)
    {
//        if ($this->authService->hasIdentity())
//            return $handler->handle($request);

        $username = $password = '';

        if (isset($_SERVER["HTTP_AUTHORIZATION"]) && 0 === stripos($_SERVER["HTTP_AUTHORIZATION"], 'basic ')) {
            $exploded = explode(':', base64_decode(substr($_SERVER["HTTP_AUTHORIZATION"], 6)), 2);
            if (2 == count($exploded)) {
                list($username, $password) = $exploded;
            }
        } elseif (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];
            unset($_SERVER['PHP_AUTH_USER']);
            unset($_SERVER['PHP_AUTH_PW']);
        } else {
            return (new Response())
                ->withHeader('WWW-Authenticate',
                    sprintf('Basic realm="%s", charset="UTF-8', $this->appName));
        }

        $this->authService->setUsername($username);
        $this->authService->setPassword($password);

        $result = $this->authService->authenticate();
        $isAuthorised = true;
        if (null !== $this->role) {
            $isAuthorised = $this->authService->authorisation($this->role);
        }


        if ($result->isValid() && $isAuthorised)
            return $handler->handle($request);
        else {
            return (new Response())
                ->withHeader('WWW-Authenticate',
                    sprintf('Basic realm="%s", charset="UTF-8', $this->appName));
        }


    }
}