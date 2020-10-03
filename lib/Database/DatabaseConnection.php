<?php

namespace Lib\Database;

use PhpParser\Node\Expr\Array_;
use Psr\Container\ContainerInterface;
use \PDO;

class DatabaseConnection
{

    private PDO $dbh;

    /**
     * DatabaseConnection constructor.
     * @param array $db settings
     */
    public function __construct(array $db)
    {
        $dsn = sprintf(
            '%s:host=%s;dbname=%s',
            $db['driver'],
            $db['host'],
            $db['name']
        );

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => true,
        ];

        $this->dbh = new PDO($dsn, $db['user'], $db['password'], $options);
    }

    public function getConnection()
    {
        return $this->dbh;
    }


}