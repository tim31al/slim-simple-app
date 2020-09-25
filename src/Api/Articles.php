<?php


namespace App\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

use \PDO;

class Articles
{
    protected PDO $pdo;

    private const TABLE = 'articles';

    /**
     * Articles constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => true,
        ];

        $db = $container->get('database');

        $dsn = sprintf(
            "%s:host=%s;dbname=%s",
            $db['driver'],
            $db['host'],
            $db['name']
        );

        $this->pdo = new PDO($dsn, $db['user'], $db['password'], $options);
    }


    public function index(Request $request, Response $response, $args = [])
    {
        $sql = 'SELECT * FROM articles';
        $smtp = $this->pdo->prepare($sql);
        $smtp->execute();
        $data = $smtp->fetchAll();
//        $data = ['title' => 'Title 1', 'content' => 'Content from Title 1'];

        $payload = json_encode($data);

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, $args)
    {
        $id = $request->getAttribute('id');

        $sql = 'SELECT * FROM ' . self::TABLE . ' WHERE id=:id LIMIT 1';
        $smtp = $this->pdo->prepare($sql);
        $smtp->bindParam(':id', $id, PDO::PARAM_INT);
        $smtp->execute();

        $data = $smtp->fetch();


        $payload = json_encode($data);

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

}