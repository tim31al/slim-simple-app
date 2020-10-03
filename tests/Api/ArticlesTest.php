<?php


namespace Test\Api;

use Test\WebTestCase;
use Test\WebTestTrait;

class ArticlesTest extends WebTestCase
{
    use WebTestTrait;

    public function testArticles()
    {
        $this->printToConsole(__METHOD__);

        $response = $this->loadEndpoint('/api/articles');
        $this->assertResponseIsOk($response['info']);
        $this->assertEquals('application/json', $response['info']['content_type']);
    }

    public function testArticle()
    {
        $id = 1;
        $title = 'art1';

        $this->printToConsole(__METHOD__);

        $response = $this->loadEndpoint("/api/article/$id");
        $this->assertEquals('application/json', $response['info']['content_type']);
        $this->assertStringContainsString($title, $response['body']);
    }

    /*
     curl -X GET http://slim/api/articles
     curl -X GET http://slim/api/articles/1
     curl -X POST http://slim/api/article -H "Content-type: application/json" -d '{"title":"Новая статья", "content":"Содержимое новой статьи"}'
     curl -X PUT http://slim/api/article/33 -H "Content-type: application/json" -d '{"title":"Обновленная", "content":"Обновленная статья"}'
     curl -X DELETE http://slim/api/articles/33
    */

}