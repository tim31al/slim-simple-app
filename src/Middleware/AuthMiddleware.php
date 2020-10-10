<?php


namespace App\Middleware;

use App\Entity\User;
use App\Service\AuthenticationService;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface;


class AuthMiddleware
{
    protected AuthenticationService $auth;
    protected string $role;

    public function __construct(ContainerInterface $container, $role = 'user')
    {
        $this->auth = $container->get(AuthenticationService::class);
        $this->role = $role;
    }

    public function __invoke(Request $request, RequestHandlerInterface $handler): Response
    {
        $isAuthenticate = $this->auth->authorisation($this->role);

        if (!$isAuthenticate) {
            header('Location: /');
            exit();
        }

        return $handler->handle($request);
    }

}