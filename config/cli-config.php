<?php

// cli-config.php
/* @var ContainerInterface $container */

use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;


require_once __DIR__ . '/bootstrap.php';


return ConsoleRunner::createHelperSet($container->get(EntityManager::class));
