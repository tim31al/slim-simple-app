<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';


$builder = new ContainerBuilder();
// add setting

$builder->addDefinitions(
    __DIR__ . '/../config/settings.php',
    __DIR__ . '/../config/settings.local.php'
);
// add services
$builder->addDefinitions(__DIR__ . '/../config/services.php');

$container = $builder->build();

$app = AppFactory::createFromContainer($container);

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

// Add MethodOverride middleware
$app->add(new MethodOverrideMiddleware());

// Add display Error handler
if ($container->get('env') === 'dev')
    $app->addErrorMiddleware(true, true, true);

// routes
(require __DIR__ . '/../config/routes.php')($app);

$app->run();