<?php

namespace App\Controller;

use App\Model\ModelInterface;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

use Throwable;

abstract class BaseController
{

    /**
     * @var PhpRenderer $view
     */
    protected PhpRenderer $view;

    protected Logger $log;

    protected ModelInterface $model;

    protected ContainerInterface $container;


    /**
     * BaseController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->view = new PhpRenderer($container->get('templates_path'));
        $this->view->setLayout('layout.php');

        $this->log = $container->get('log');

        $this->container = $container;

    }

    protected function render(Response $response, string $template, array $params = []): Response
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
