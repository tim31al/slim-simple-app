<?php


namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ArticleController extends AbstractController
{

    public function index(Request $request, Response $response, array $args = [])
    {
        $er = $this->container->get(EntityManager::class)->getRepository(Article::class);
        $articles = $er->findAll();

        return $this->render($response, 'article/index.php', [
            'title' => 'Articles',
            'articles' => $articles,
            //'scripts' => ['articles']
            ]);
    }

    public function view(Request $request, Response $response)
    {
        $id = (int) $request->getAttribute('id');

        $er = $this->container->get(EntityManager::class)->getRepository(Article::class);
        $article = $er->find($id);

        return $this->render($response, 'article/view.php', [
            'title' => $article->getTitle(),
            'article' => $article
        ]);
    }


}