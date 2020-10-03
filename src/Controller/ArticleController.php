<?php


namespace App\Controller;


use App\Model\Article;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ArticleController extends BaseController
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->model = new Article($container);
    }

    public function index(Request $request, Response $response, array $args = [])
    {
        $articles = $this->model->read();

        return $this->view->render($response, 'article/index.php', [
            'title' => 'Articles',
            'articles' => $articles,
            //'scripts' => ['articles']
            ]);
    }

    public function view(Request $request, Response $response)
    {
        $id = (int) $request->getAttribute('id');
        $article = $this->model->read($id);

        return $this->view->render($response, 'article/view.php', [
            'title' => $article['title'],
            'article' => $article
        ]);
    }


}