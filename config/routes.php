<?php

//use App\Middleware\AuthenticationMiddleware;
use App\Security\Auth;
use App\Security\BasicAuth;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/', 'App\Controller\HomeController:index');

    // login
    $app->map(['GET', 'POST'], '/login', 'App\Controller\DefaultController:login');

    $app->get('/logout', function (Response $response, $app) {

        $referer = '/';

        if (isset($_SESSION['referer'])) {
            $referer = $_SESSION['referer'];
            unset($_SESSION['referer']);
        } elseif (isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
        }

        $auth = new Auth($app->getContainer());
        $auth->getAuthService()->clearIdentity();

        return $response
            ->withHeader('Location', $referer)
            ->withStatus(302);
    });


    $app->get('/server', 'App\Controller\HomeController:server')//        ->add(new AuthenticationMiddleware($app->getContainer()))
    ;

    $app->get('/articles', 'App\Controller\ArticleController:index');
    $app->get('/article/{id:\d+}', 'App\Controller\ArticleController:view');

    $app->get('/products', 'App\Controller\ProductController:index');
    $app->get('/product/{id:[0-9]+}', 'App\Controller\ProductController:view');

    $app->get('/users', 'App\Controller\UserController:index');
    $app->get('/user/{id:[0-9]+}', 'App\Controller\UserController:view');

    // Api Article routes
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->get('/articles', 'App\Api\Articles:read');
        $group->get('/article/{id:\d+}', 'App\Api\Articles:read');
        $group->post('/article', 'App\Api\Articles:create');
        $group->put('/article/{id:\d+}', 'App\Api\Articles:update');
        $group->delete('/article/{id:\d+}', 'App\Api\Articles:delete');
    });

    $app->get('/test', function (Request $request, Response $response, array $args) {

        $data = !empty($_SESSION) ? array_merge($_SERVER, $_SESSION) : $_SERVER;
        $data = !empty($_COOKIE) ? array_merge($data, $_COOKIE) : $data;

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');

    })
        ->add(function (Request $request, RequestHandlerInterface $handler) use ($app) {


            $auth = new BasicAuth($app->getContainer());
            $isAuth = $auth->authenticate();

            if (!$isAuth) {

                $response = new \Slim\Psr7\Response();
                $response->getBody()->write(json_encode('Not authorized'));

                return $response
                    ->withHeader('WWW-Authenticate', 'Basic realm="My realm"');
            }


            return $handler->handle($request);


        });


    $app->get('/test-session', function (Request $request, Response $response) use ($app) {

        $arr = ['name' => 'alex', 'role' => 'admin'];


        $session = $app->getContainer()->get(\App\Service\SessionStorage::class);
        $session->write('new', 'new');
        $sessionId = $session->getId();
        $identity = $session->hasKey('identity') ? $session->read('identity') : '';
        $counter = $session->hasKey('counter') ? $session->read('counter') : 0;

        $global = "_SESSION\n";
        foreach($_SESSION as $k => $v)
            $global .= $k .': '.$v."\n";

        $body = sprintf(
            '<html><body><h3>Session ID: %s</h3><h3>Identity: %s</h3><h3>Counter: %d</h3><hr></h4><pre>%s</pre></body></html>',
            $sessionId, implode(':', $identity), $counter, $global);


        $session->write('identity', $arr);
        $session->write('counter', ++$counter);

        $response->getBody()->write($body);
        return $response;
    });


    // включить кеширование, если debug not false
    $container = $app->getContainer();

    if (!$container->get('debug')) {
        $routeCollector = $app->getRouteCollector();
        $routeCollector->setCacheFile($container->get('route_cache'));
    }
};