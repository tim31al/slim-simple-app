<?php

namespace App\Controller;

use App\Service\AuthenticationService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

abstract class AbstractController
{

    /**
     * @var PhpRenderer $view
     */
    protected PhpRenderer $view;

    protected ContainerInterface $container;


    /**
     * BaseController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->view = new PhpRenderer($container->get('templates_path'));
        $this->view->setLayout('layout.php');
        $this->view->addAttribute('auth', $container->get(AuthenticationService::class));
        $this->view->addAttribute('title', $container->get('app_name'));
        $this->container = $container;

    }

    protected function render(Response $response, string $template, array $params = []): Response
    {
        return $this->view->render($response, $template, $params,);
    }

}
