<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

class HomeController extends BaseController
{

    public function index(Request $request, Response $response, array $args = [])
    {
        return $this->view->render($response, 'home/index.php', ['title' => 'First page']);
    }

    public function hello(Request $request, Response $response, array $args = [])
    {
        return $this->view->render($response, 'home/hello.php', ['name' => 'Alex']);
    }

    public function server(Request $request, Response $response, array $args = [])
    {
        return $this->render($response, 'home/server.php');
    }

}
