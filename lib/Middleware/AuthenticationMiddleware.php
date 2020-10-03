<?php


namespace Lib\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AuthenticationMiddleware
{
    private const LOGIN = 'alex';
    private const PASS = 'r477ed';

    public function __invoke(Request $request, RequestHandler $handler)
    {

        if (!isset($_SERVER['PHP_AUTH_USER'])
            || !isset($_SERVER['PHP_AUTH_PW'])
            || !$this->checkUser($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {

            return (new Response())
                ->withHeader('WWW-Authenticate',
                    'Basic realm="Access to site", charset="UTF-8');

        } else {
            return $handler->handle($request);
        }

    }

    private function checkUser($user, $pass): bool
    {
        return $user == self::LOGIN && $pass == self::PASS;

    }
}