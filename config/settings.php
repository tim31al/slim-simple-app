<?php

$rootPath = realpath(__DIR__ . '/..');

return [
    'app_name' => 'MyApp',

    'base_path' => '',

    'env' => 'dev', // change "prod" in production

    // Temporary directory
    'temporary_path' => $rootPath . '/var/tmp',

    // Route cache
    'route_cache' => $rootPath . '/var/cache/routes.cache',

    // Path to templates
    'templates_path' => $rootPath . '/templates',

    // Log path
    'log_path' => $rootPath . '/var/log',

    // session
    'session' => [
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'security' => false,
        'http_only' => true,
    ],

    // doctrine
    'doctrine' => [
        'isDevMode' => true,
        'cache_dir' => $rootPath . '/var/doctrine',
        'proxies_dir' => $rootPath . '/src/Proxies',
        'metadata_dirs' => [$rootPath . '/src/Entity'],
        'connection' => [
            'driver' => '',
            'host' => '',
            'port' => '',
            'dbname' => '',
            'user' => '',
            'password' => ''
        ]
    ]

];
