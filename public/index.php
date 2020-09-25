<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

$rootPath = realpath(__DIR__ . '/..');

require $rootPath . '/vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions($rootPath . '/config/settings.php');
$container = null;
try {
    $container = $builder->build();
} catch (Exception $e) {

}

$app = AppFactory::createFromContainer($container);

// register routes
$routes = require $rootPath . '/config/routes.php';
$routes($app);

$app->run();


