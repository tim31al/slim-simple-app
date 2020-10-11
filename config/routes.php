<?php

use App\Api\Articles;
use App\Middleware\AuthMiddleware;
use App\Middleware\BasicAuthMiddleware;
use App\Service\AuthenticationService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/', 'App\Controller\SiteController:index');

    // login
    $app->map(['GET', 'POST'], '/login', 'App\Controller\SiteController:login');

    $app->get('/logout', function (Request $request, Response $response) use ($app) {

        $auth = $app->getContainer()->get(AuthenticationService::class);
        $auth->clearIdentity();

        return $response
            ->withHeader('Location', '/')
            ->withStatus(302);
    });


    $app->get('/server', 'App\Controller\SiteController:server')//                ->add(new BasicAuthMiddleware($app->getContainer()))
    ;

    $app->get('/articles', 'App\Controller\ArticleController:index');
    $app->get('/article/{id:\d+}', 'App\Controller\ArticleController:show');

    $app->group('/user', function (RouteCollectorProxy $group) {
        $group->get('s', 'App\Controller\UserController:index');
        $group->get('/{id:[0-9]+}', 'App\Controller\UserController:view');
    })->add(new AuthMiddleware($app->getContainer(), 'editor'));

    // Api Article routes
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->get('/articles', 'App\Api\Articles:read');
        $group->get('/article/{id:\d+}', 'App\Api\Articles:read');
        $group->post('/article', 'App\Api\Articles:create');
        $group->put('/article/{id:\d+}', 'App\Api\Articles:update');
        $group->delete('/article/{id:\d+}', 'App\Api\Articles:delete');
    })
        ->add(new BasicAuthMiddleware($app->getContainer(), 'editor'))
    ;

    $app->get('/test', function (Request $request, Response $response, array $args) {

        $data = !empty($_SESSION) ? array_merge($_SERVER, $_SESSION) : $_SERVER;
        $data = !empty($_COOKIE) ? array_merge($data, $_COOKIE) : $data;

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');

    })
        ->add(function (Request $request, RequestHandlerInterface $handler) use ($app) {

            $auth = $app->getContainer()->get(AuthenticationService::class);
            $isAuth = $auth->authenticate();

            if (!$isAuth) {

                $response = new \Slim\Psr7\Response();
                $response->getBody()->write(json_encode('Not authorized'));

                return $response
                    ->withHeader('WWW-Authenticate', 'Basic realm="My realm"');
            }


            return $handler->handle($request);


        });


    // включить кеширование, если debug not false
    $container = $app->getContainer();

    if (!$container->get('debug')) {
        $routeCollector = $app->getRouteCollector();
        $routeCollector->setCacheFile($container->get('route_cache'));
    }
};