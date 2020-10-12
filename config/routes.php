<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\BasicAuthMiddleware;
use App\Service\AuthenticationService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {

    $container = $app->getContainer();

    $app->group('/', function (RouteCollectorProxy $group) use ($container) {
        $group->get('', 'App\Controller\SiteController:index');
        $group->map(['GET', 'POST'], 'login', 'App\Controller\SiteController:login');
        $group->get('logout', function (Request $request, Response $response) use ($container) {
            $auth = $container->get(AuthenticationService::class);
            $auth->clearIdentity();

            return $response
                ->withHeader('Location', '/')
                ->withStatus(302);
        });

        $group->get('articles', 'App\Controller\ArticleController:index');
        $group->get('article/{id:[0-9]+}', 'App\Controller\ArticleController:show');
    });

    $app->get('/server', 'App\Controller\SiteController:server');

    $app->group('/user', function (RouteCollectorProxy $group) {
        $group->get('s', 'App\Controller\UserController:index');
        $group->get('/{id:[0-9]+}', 'App\Controller\UserController:view');
    })->add(new AuthMiddleware($container, 'admin'));

    // Api Article routes
    $app->get('/api/articles', 'App\Api\Articles:read');
    $app->get('/api/article/{id:\d+}', 'App\Api\Articles:read');
    // with Basic auth
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->post('/article', 'App\Api\Articles:create');
        $group->put('/article/{id:\d+}', 'App\Api\Articles:update');
        $group->delete('/article/{id:\d+}', 'App\Api\Articles:delete');
    })->add(new BasicAuthMiddleware($container, 'editor'));


    // включить кеширование, если dev === prod
    if ($container->get('env') === 'prod') {
        $routeCollector = $app->getRouteCollector();
        $routeCollector->setCacheFile($container->get('route_cache'));
    }
};