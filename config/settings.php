<?php

use Psr\Container\ContainerInterface;
use function DI\factory;

$rootPath = realpath(__DIR__ . '/..');

return [
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'name' => 'fast_route',
        'user' => 'root',
        'password' => ''
    ],
    'base_path' => '',

    'debug' => true,

    // Temporary directory
    'temporary_path' => $rootPath . '/var/tmp',

    // Route cache
    'route_cache' => $rootPath . '/var/cache/routes.cache',

    // Path to Views
    'view_path' => $rootPath . '/src/View',

    // DatabaseConnection
    'db' => function (ContainerInterface $container) {
        return new \lib\Database\DatabaseConnection($container->get('database'));
    }
];
