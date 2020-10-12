<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Controller\ErrorController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;


class ErrorMiddleware implements MiddlewareInterface
{
    private ContainerInterface $container;

    /**
     * ErrorMiddleware constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param Throwable $e
     * @return ResponseInterface
     */
    public function handleException(Throwable $e): ResponseInterface
    {
        if ($e->getCode() == 404 || $e->getCode() == 403) {
            $error = ['code' => $e->getCode(), 'message' => $e->getMessage()];
        } else {
            $error = ['code' => 500, 'message' => 'Internal Server Error'];
        }

        return (new ErrorController($this->container, $error))->show();
    }


}
