<?php


namespace App\Middleware;

use App\Service\AuthenticationService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use function count;

class BasicAuthenticationMiddleware
{

    private AuthenticationService $authService;

    /**
     * AuthenticationMiddleware constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->authService = $container->get(AuthenticationService::class);
    }


    public function __invoke(Request $request, RequestHandler $handler)
    {
        if ($this->authService->hasIdentity())
            return $handler->handle($request);

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
                    'Basic realm="Access to site", charset="UTF-8');
        }

        $this->authService->setUsername($username);
        $this->authService->setPassword($password);

        $result = $this->authService->authenticate();

        if($result->isValid())
            return $handler->handle($request);
        else {
            return (new Response())
                ->withHeader('WWW-Authenticate',
                    'Basic realm="Access to site", charset="UTF-8');
        }




    }
}