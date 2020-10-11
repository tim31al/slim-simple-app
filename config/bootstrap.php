<?php

use DI\ContainerBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

return function(): DI\Container {
    $builder = new ContainerBuilder();
    $builder->addDefinitions(__DIR__ . '/settings.php', __DIR__ . '/settings.local.php');
    $builder->addDefinitions(__DIR__ . '/services.php');
    return $builder->build();
};
