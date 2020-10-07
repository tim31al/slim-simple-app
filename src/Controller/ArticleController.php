<?php


namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ArticleController extends BaseController
{
    private EntityRepository $er;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->er = $container->get(EntityManager::class)->getRepository(Article::class);
    }

    public function index(Request $request, Response $response, array $args = [])
    {
        $articles = $this->er->findAll();

        return $this->view->render($response, 'article/index.php', [
            'title' => 'Articles',
            'articles' => $articles,
            //'scripts' => ['articles']
            ]);
    }

    public function view(Request $request, Response $response)
    {
        $id = (int) $request->getAttribute('id');
        $article = $this->er->find($id);

        return $this->view->render($response, 'article/view.php', [
            'title' => $article->getTitle(),
            'article' => $article
        ]);
    }


}