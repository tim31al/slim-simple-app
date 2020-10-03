<?php

namespace App\Controller;

use App\Model\ModelInterface;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

use Throwable;

abstract class BaseController {

    /**
     * @var PhpRenderer $view
     */
    protected PhpRenderer $view;

    protected Logger $log;

    protected ModelInterface $model;

    /**
     * BaseController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->view = new PhpRenderer($container->get('view_path'));
        $this->view->setLayout('layout.php');

        $this->log = $container->get('log');
    }

    protected function render(Response $response, string $template, array $params = []) : Response
    {
        try {
            return $this->view->render($response, $template, $params);
        } catch (Throwable $e) {
            print_r($e->getTrace());
            exit($e->getCode());
        }
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
