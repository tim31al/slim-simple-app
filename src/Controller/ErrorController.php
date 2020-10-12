<?php


namespace App\Controller;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;


class ErrorController extends AbstractController
{
    private array $error;

    /**
     * ErrorController constructor.
     * @param ContainerInterface $c
     * @param array $error
     */
    public function __construct(ContainerInterface $c, array $error)
    {
        parent::__construct($c);
        $this->error = $error;
    }

    public function show(): ResponseInterface
    {
        return $this->render(new Response(), 'error/error.php', [
            'error' => $this->error]);
    }


}