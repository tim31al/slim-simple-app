<?php

$rootPath = realpath(__DIR__ . '/..');

return [
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'name' => 'slim',
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

    // Log path
    'log_path' => $rootPath . '/var/log',

];
