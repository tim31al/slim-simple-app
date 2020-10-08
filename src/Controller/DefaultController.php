<?php


namespace App\Controller;


use App\Entity\Article;
use App\Security\Auth;
use Doctrine\ORM\EntityRepository;
use Laminas\Session\Storage\SessionStorage;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DefaultController extends BaseController
{
    public function login(Request $request, Response $response)
    {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';


        if ($request->getMethod() == 'POST') {
            $data = $request->getParsedBody();

            $auth = new Auth($this->container);

            $result = $auth->identity($data['username'], $data['password']);

            if ($result->isValid())
                return $response->withHeader('Location', '/')->withStatus(302);
        }
        return $this->render($response, 'home/login.php');

    }

    public function test(Request $request, Response $response)
    {
        return $this->render($response, 'home/server.php');
    }


}