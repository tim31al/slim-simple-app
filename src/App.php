<?php

namespace App;

use DI\ContainerBuilder;
use Exception;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;
use Slim\App as SlimApp;

class App
{
    private SlimApp $app;

    public function __construct($test = false)
    {
        if (!$test) {
            session_start([
                'cookie_lifetime' => 86400,
            ]);
        }

        $rootPath = realpath(__DIR__ . '/..');

        $builder = new ContainerBuilder();
        // add setting
        $builder->addDefinitions($rootPath . '/config/settings.php');
        // add services
        $builder->addDefinitions($rootPath . '/config/services.php');
        $container = null;
        try {
            $container = $builder->build();
        } catch (Exception $e) {
            print_r($e->getTrace());
            exit($e->getCode());
        }

        $this->app = AppFactory::createFromContainer($container);

        $this->app->addBodyParsingMiddleware();

        $this->app->addRoutingMiddleware();

        // Add MethodOverride middleware
        $this->app->add(new MethodOverrideMiddleware());

        // Add display Error handler
        $this->app->addErrorMiddleware(true, true, true);

        // register routes
        $routes = require $rootPath . '/config/routes.php';
        $routes($this->app);
    }


    public function get()
    {
        return $this->app;
    }


}
