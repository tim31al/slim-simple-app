<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

abstract class BaseController {

    /**
     * @var PhpRenderer $view
     */
    protected PhpRenderer $view;

    /**
     * BaseController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->view = new PhpRenderer($container->get('view_path'));
        $this->view->setLayout('layout.php');
    }

    protected function render(Response $response, string $template, array $params = []) : Response
    {
        return $this->view->render($response, $template, $params);
    }

    /**
     * @return string
     */
    protected function getNameOfClass()
    {
        $className = self::class;

        return substr($className, 0, strlen('Controller'));
    }



}
