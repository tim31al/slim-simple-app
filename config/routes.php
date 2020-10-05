<?php

use Lib\Middleware\AuthenticationMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

return function (App $app) {
    $app->get('/', 'App\Controller\HomeController:index')->setName('home');

    // login
    $app->map(['GET', 'POST'], '/login', 'App\Controller\HomeController:login');

//    $app->get('/login', 'App\Controller\HomeController:login');
//
//    $app->post('/login', function (Request $request, Response $response) {
//
//        $data = $request->getParsedBody();
//
//        if ($data['username'] == 'alex' && $data['password'] == 'r477ed') {
//
//            $_SESSION['user'] = $data['username'];
//
//            $referer = '/';
//
//            if (isset($_SESSION['referer'])) {
//                $referer = $_SESSION['referer'];
//                unset($_SESSION['referer']);
//            }
//
//
//            return $response
//                ->withHeader('Location', $referer)
//                ->withStatus(302);
//        } else {
//            return $response->withHeader('Location', '/login');
//        }
//    });
//
//    $app->get('/logout', function (Request $request, Response $response) {
//
//        $referer = '/';
//
//        if (isset($_SESSION['referer'])) {
//            $referer = $_SESSION['referer'];
//            unset($_SESSION['referer']);
//        } elseif (isset($_SERVER['HTTP_REFERER'])) {
//            $referer = $_SERVER['HTTP_REFERER'];
//        }
//
//        if (isset($_SESSION['user'])) {
//            unset($_SESSION['user']);
//        }
//
//        return $response
//            ->withHeader('Location', $referer)
//            ->withStatus(302);
//    });


    $app->get('/server', 'App\Controller\HomeController:server');
//        ->add(new AuthenticationMiddleware($app->getContainer()));

    $app->get('/articles', 'App\Controller\ArticleController:index')->setName('articles');
    $app->get('/article/{id:\d+}', 'App\Controller\ArticleController:view');

    $app->get('/products', 'App\Controller\ProductController:index');
    $app->get('/product/{id:[0-9]+}', 'App\Controller\ProductController:view');

    $app->get('/users', 'App\Controller\UserController:index');
    $app->get('/user/{id:[0-9]+}', 'App\Controller\UserController:view');

    // Api Article routes
    $app->get('/api/articles', 'App\Api\Articles:read');
    $app->get('/api/article/{id:\d+}', 'App\Api\Articles:read');
    $app->post('/api/article', 'App\Api\Articles:create')
        ->add(new AuthenticationMiddleware($app->getContainer()));
    $app->put('/api/article/{id:\d+}', 'App\Api\Articles:update');
    $app->delete('/api/article/{id:\d+}', 'App\Api\Articles:delete')
        ->add(new AuthenticationMiddleware($app->getContainer()));


    // включить кеширование, если debug not false
    $container = $app->getContainer();

    if (!$container->get('debug')) {
        $routeCollector = $app->getRouteCollector();
        $routeCollector->setCacheFile($container->get('route_cache'));
    }
};