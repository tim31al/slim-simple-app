<?php

use App\Middleware\ErrorMiddleware;
use DI\ContainerBuilder;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
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
    // slim default error middleware
    $app->addErrorMiddleware(true, false, false);
else
    $app->add(new ErrorMiddleware($app->getContainer()));

// routes
(require __DIR__ . '/../config/routes.php')($app);

$app->run();