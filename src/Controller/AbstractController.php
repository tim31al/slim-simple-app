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

    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * BaseController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->view = new PhpRenderer($container->get('templates_path'));
        $this->view->setLayout('layout.php');
        $this->view->addAttribute('auth', $container->get(AuthenticationService::class));
        $this->view->addAttribute('style', '/css/style.css');
        $this->view->addAttribute('title', $container->get('app_name'));
    }

    protected function render(Response $response, string $template, array $params = []): Response
    {
        return $this->view->render($response, $template, $params);
    }

}
