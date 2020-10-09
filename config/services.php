<?php

use App\Service\AuthenticationService;
use App\Service\SessionStorage;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

return [
    // monolog logger
    Logger::class => function (ContainerInterface $container) {
        $logFile = $container->get('log_path') . '/app.log';
        if (!file_exists($logFile))
            touch($logFile);

        $log = new Logger('app');
        $log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
        return $log;
    },

    // EntityManager
    EntityManager::class => function (ContainerInterface $container): EntityManager {

        $config = Setup::createAnnotationMetadataConfiguration(
            $container->get('doctrine')['metadata_dirs'],
            $container->get('doctrine')['isDevMode']
        );

        $driverImpl = new AnnotationDriver(new AnnotationReader, $container->get('doctrine')['metadata_dirs']);
        $config->setMetadataDriverImpl($driverImpl);

        $cache = new FilesystemCache($container->get('doctrine')['cache_dir']);
        $config->setQueryCacheImpl($cache);

        return EntityManager::create($container->get('doctrine')['connection'], $config);
    },

    // Session Storage
    SessionStorage::class => function (ContainerInterface $container) {
        return new SessionStorage($container);
    },

    // Authentication
    AuthenticationService::class => function (ContainerInterface $container) {
        return new AuthenticationService($container);
    }
];
