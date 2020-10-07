<?php

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\ApcuCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use App\Database\DatabaseConnection;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

return [
    // DatabaseConnection
    'db' => function (ContainerInterface $container) {
        return new DatabaseConnection($container->get('fixtures'));
    },

    // monolog logger
    'log' => function (ContainerInterface $container) {
        $logFile = $container->get('log_path') . '/app.log';
        if (!file_exists($logFile))
            touch($logFile);

        $log = new Logger('app');
        $log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
        return $log;
    },

    // EntityManager
    EntityManager::class => function (ContainerInterface $container) :EntityManager {

        $config = Setup::createAnnotationMetadataConfiguration(
            $container->get('doctrine')['metadata_dirs'],
            $container->get('doctrine')['isDevMode']
        );

        $driverImpl = new AnnotationDriver(new AnnotationReader, $container->get('doctrine')['metadata_dirs']);
        $config->setMetadataDriverImpl($driverImpl);

        $cache = new FilesystemCache($container->get('doctrine')['cache_dir']);
        $config->setQueryCacheImpl($cache);

        return EntityManager::create($container->get('doctrine')['connection'], $config);
    }
];
