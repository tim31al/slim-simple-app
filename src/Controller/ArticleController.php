<?php


namespace App\Controller;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ArticleController extends BaseController
{
    public function index(Request $request, Response $response, array $args = [])
    {
        $sql = 'SELECT * FROM articles';
        $smtp = $this->getPdo()->prepare($sql);
        $smtp->execute();
        $articles = $smtp->fetchAll();

        return $this->view->render($response, 'article/index.php', [
            'title' => 'Articles',
            'articles' => $articles
            ]);
    }

    private function getPdo()
    {
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];

        return new \PDO("mysql:host=localhost;dbname=fast_route",
            'root', '', $options);
    }

}