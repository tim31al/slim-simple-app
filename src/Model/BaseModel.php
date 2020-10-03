<?php

namespace App\Model;

use Psr\Container\ContainerInterface;
use \PDO;

abstract class BaseModel implements ModelInterface
{
    protected PDO $pdo;

    protected string $tableName;

    /**
     * BaseModel constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->pdo = $container->get('db')->getConnection();
    }

}