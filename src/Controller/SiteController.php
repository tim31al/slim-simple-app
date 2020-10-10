<?php


namespace App\Controller;

use App\Service\AuthenticationService;
use App\Service\SessionStorage;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SiteController extends AbstractController
{

    public function index(Request $request, Response $response)
    {
        return $this->render($response, 'site/index.php');
    }

    public function server(Request $request, Response $response)
    {
        return $this->render($response, 'site/server.php');
    }

    public function login(Request $request, Response $response)
    {
        $result = '';
        $data['username'] = $data['password'] = '';

        // Сохранить ссылку для перехода на вызвавшую страницу
        if ($request->getMethod() == 'GET') {
            $session = $this->container->get(SessionStorage::class);
            $session->write('referer', $_SERVER['HTTP_REFERER']);
        }

        if ($request->getMethod() == 'POST') {
            $data = $request->getParsedBody();

            // аутентификация
            $auth = $this->container->get(AuthenticationService::class);
            $auth->setUsername($data['username']);
            $auth->setPassword($data['password']);
            $result = $auth->authenticate();

            if ($result->isValid()) {
                $session = $this->container->get(SessionStorage::class);
                $referer = $session->read('referer');
                $session->clear('referer');

                return $response
                    ->withHeader('Location', $referer)
                    ->withStatus(302);
            }
        }

        return $this->render($response, 'site/login.php',
            ['result' => $result, 'data' => $data]);

    }
}