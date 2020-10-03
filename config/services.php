<?php
use Psr\Container\ContainerInterface;
use Lib\Database\DatabaseConnection;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

return [
    // DatabaseConnection
    'db' => function (ContainerInterface $container) {
        return new DatabaseConnection($container->get('database'));
    },

    // monolog logger
    'log' => function(ContainerInterface $container) {
        $logFile = $container->get('log_path') . '/app.log';
        if (!file_exists($logFile))
            touch($logFile);

        $log = new Logger('app');
        $log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
        return $log;
    }
];
