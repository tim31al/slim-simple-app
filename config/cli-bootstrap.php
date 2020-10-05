<?php

use DI\ContainerBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__.'/settings.php');
$builder->addDefinitions(__DIR__ . '/services.php');
$container = $builder->build();
