<?php

namespace App\Controller;

use App\Security\Auth;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;
use Monolog\Logger;

class HomeController extends BaseController
{

    public function index(Request $request, Response $response)
    {
        return $this->render($response, 'home/index.php', ['title' => 'First page']);
    }


    public function server(Request $request, Response $response, array $args = [])
    {
        return $this->render($response, 'home/server.php');
    }

}
