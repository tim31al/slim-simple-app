<?php

$rootPath = realpath(__DIR__ . '/..');

return [
    'fixtures' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'port' => 3306,
        'name' => 'slim',
        'user' => 'alex',
        'password' => 'r477ed'
    ],

    'app_name' => 'MyApp',

    'base_path' => '',

    'debug' => true,
    'applicationMode' => 'development', // production

    // Temporary directory
    'temporary_path' => $rootPath . '/var/tmp',

    // Route cache
    'route_cache' => $rootPath . '/var/cache/routes.cache',

    // Path to Views
    'view_path' => $rootPath . '/src/View',

    // Log path
    'log_path' => $rootPath . '/var/log',

    // doctrine
    'doctrine' => [
        'isDevMode' => true,
        'cache_dir' => $rootPath . '/var/doctrine',
        'proxies_dir' => $rootPath . '/src/Proxies',
        'metadata_dirs' => [$rootPath . '/src/Entity'],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'port' => 3306,
            'dbname' => 'slim',
            'user' => 'alex',
            'password' => 'r477ed'
        ]
    ]

];
