<?php

use Slim\App;

return function (App $app) {
    $app->get('/', 'App\Controller\HomeController:index')->setName('home');

    $app->get('/hello', 'App\Controller\HomeController:hello')->setName('hello');
    $app->get('/server', 'App\Controller\HomeController:server');

    $app->get('/articles', 'App\Controller\ArticleController:index')->setName('articles');

    $app->get('/api/articles', 'App\Api\Articles:index')->setName('api-articles');
    $app->get('/api/article/{id}', 'App\Api\Articles:show')->setName('api-article');

    $app->get('/user', 'App\Controller\UserController:index');

    // включить кеширование, если debug NOT false
    $container = $app->getContainer();

    if (!$container->get('debug')) {
        $routeCollector = $app->getRouteCollector();
        $routeCollector->setCacheFile($container->get('route_cache'));
    }
};