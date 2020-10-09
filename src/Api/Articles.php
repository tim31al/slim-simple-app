<?php

namespace App\Api;

use App\Entity\Article;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

class Articles
{
    private const MESSAGE = 'Result';
    private const STATUS_ERROR = 'ERROR';
    private const STATUS_OK = 'OK';
    private EntityManager $em;
    private string $status;

    /**
     * Articles constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->em = $container->get(EntityManager::class);
        $this->status = self::STATUS_OK;
    }

    // curl -X GET http://slim/api/articles
    // curl -X GET http://slim/api/articles/1
    /**
     * Show one|all article(s)
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function read(Request $request, Response $response)
    {
        $id = (int)$request->getAttribute('id');

        $repo = $this->em->getRepository(Article::class);
        $data = $id ?
            ($repo->find($id))->toArray() :
            array_map(function ($item) {
                return $item->toArray();
            }, $repo->findAll());


        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // curl -X POST http://slim/api/article -H "Content-type: application/json" -d '{"title":"Новая статья", "content":"Содержимое новой статьи"}'

    /**
     * Create article
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response)
    {
        $data = $request->getParsedBody();


        $article = new Article();
        $article->setTitle($data['title']);
        $article->setContent($data['content']);
        $article->setDate(new DateTime());

        try {
            $this->em->persist($article);
            $this->em->flush();
        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
            $this->status = self::STATUS_ERROR;
        }

        $response->getBody()->write(json_encode([self::MESSAGE => $this->status]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    //curl -X PUT http://slim/api/article/33 -H "Content-type: application/json" -d '{"title":"Обновленная", "content":"Обновленная статья"}'
    /**
     * Update article
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function update(Request $request, Response $response)
    {
        $id = (int)$request->getAttribute('id');
        $data = $request->getParsedBody();

        $article = ($this->em->getRepository(Article::class))
            ->find($id);

        $article->setTitle($data['title']);
        $article->setContent($data['content']);

        try {
            $this->em->persist($article);
            $this->em->flush();
        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
            $this->status = self::STATUS_ERROR;
        }

        $response->getBody()->write(json_encode([self::MESSAGE => $this->status]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // curl -X DELETE http://slim/api/article/26
    /**
     * Delete articles
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function delete(Request $request, Response $response)
    {
        $id = (int)$request->getAttribute('id');

        $article = $this->em->getRepository(Article::class)->find($id);
        try {
            $this->em->remove($article);
        } catch (ORMException $e) {
            $this->status = self::STATUS_ERROR;
        }
        try {
            $this->em->flush();
        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
            $this->status = self::STATUS_ERROR;
        }

        $response->getBody()->write(json_encode([self::MESSAGE => $this->status]));
        return $response->withHeader('Content-Type', 'application/json');
    }

}