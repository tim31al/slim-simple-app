<?php

namespace App\Api;

use App\Model\Article;
//use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

class Articles
{
    private Article $model;
//    private Logger $log;

    /**
     * Articles constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
//        $this->log = $container->get('log');
        $this->model = new Article($container);
    }

    // curl -X GET http://slim/api/articles
    // curl -X GET http://slim/api/articles/1
    public function read(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');

        $data = $this->model->read($id);

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // curl -X POST http://slim/api/article -H "Content-type: application/json" -d '{"title":"Новая статья", "content":"Содержимое новой статьи"}'
    public function create(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $this->model->setTitle($data['title']);
        $this->model->setContent($data['content']);

        $id = $this->model->create();

        $response->getBody()->write(json_encode(['id' => $id]));
//        $response->getBody()->write(json_encode([$this->model->read($id)]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    //curl -X PUT http://slim/api/article/33 -H "Content-type: application/json" -d '{"title":"Обновленная", "content":"Обновленная статья"}'
    public function update(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $this->model->setId($id);
        $this->model->setTitle($data['title']);
        $this->model->setContent($data['content']);

        $status = $this->model->update() ? 'OK' : 'NOT';

        $response->getBody()->write(json_encode(['article updated' => $status]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // curl -X DELETE http://slim/api/articles/33
    public function delete(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $this->model->setId($id);

        $status = $this->model->delete() ? 'OK' : 'NOT';

        $response->getBody()->write(json_encode(['deleted' => $status]));
        return $response->withHeader('Content-Type', 'application/json');
    }

}