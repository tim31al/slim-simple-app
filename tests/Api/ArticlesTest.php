<?php


namespace Test\Api;

use Test\WebTestCase;
use Test\WebTestTrait;

class ArticlesTest extends WebTestCase
{
    use WebTestTrait;

    public function testArticles()
    {
        list($body, $info) = $this->request('/api/articles');
        $this->assertResponseIsOk($info);
        $this->assertEquals('application/json', $info['content_type']);
    }

    public function testArticle()
    {
        $id = 21;
        $title = 'Article 1';

        list($body, $info) = $this->request("/api/article/$id");
        $this->assertEquals('application/json', $info['content_type']);
        $this->assertStringContainsString($title, $body);
    }

    public function testCrud()
    {
        $header = 'Content-Type: application/json';
        $data = ['title' => 'Test Art', 'content' => 'Test Art content'];


        // create article
        list($response, $info) = $this->request(
            '/api/article',
            'POST',
            json_encode($data),
            array($header)
        );
        $this->assertResponseIsOk($info);

        // stdClasss Object (Result, id)
        $response = json_decode($response);
        $this->assertSame('OK', $response->Result);
        $this->assertIsInt($response->id);
        // save article id
        $articleId = $response->id;

        // update article
        list($response, $info) = $this->request(
            '/api/article/'.$articleId, 'PUT',
            json_encode(['title' => 'New title']),
            array($header)
        );
        $response = json_decode($response);
        $this->assertResponseIsOk($info);
        $this->assertSame('OK', $response->Result);

        // delete article
        list($response, $info) = $this->request(
            '/api/article/'.$articleId, 'DELETE'
        );
        $this->assertResponseIsOk($info);

    }

    /*
     curl -X GET http://slim/api/articles
     curl -X GET http://slim/api/articles/1
     curl -X POST http://slim/api/article -H "Content-type: application/json" -d '{"title":"Новая статья", "content":"Содержимое новой статьи"}'
     curl -X PUT http://slim/api/article/33 -H "Content-type: application/json" -d '{"title":"Обновленная", "content":"Обновленная статья"}'
     curl -X DELETE http://slim/api/article/33
    */

}