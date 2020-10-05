<?php

use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;


$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__.'/settings.php');
$builder->addDefinitions(__DIR__ . '/services.php');
$container = $builder->build();


return ConsoleRunner::createHelperSet($container->get(EntityManager::class));
