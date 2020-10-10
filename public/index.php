<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';


$builder = new ContainerBuilder();
// add setting
$builder->addDefinitions(__DIR__ .  '/../config/settings.php');
// add services
$builder->addDefinitions(__DIR__. '/../config/services.php');
$container = null;
try {
    $container = $builder->build();
} catch (Exception $e) {
    print_r($e->getTrace());
    exit($e->getCode());
}

$app = AppFactory::createFromContainer($container);

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

// Add MethodOverride middleware
$app->add(new MethodOverrideMiddleware());

// Add display Error handler
$app->addErrorMiddleware(true, true, true);

// register routes
$routes = require __DIR__ . '/../config/routes.php';
$routes($app);

$app->run();