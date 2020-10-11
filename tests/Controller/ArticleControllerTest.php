<?php


namespace Test\Controller;


use Test\WebTestCase;
use Test\WebTestTrait;


class ArticleControllerTest extends WebTestCase
{
    use WebTestTrait;

    public function testIndex()
    {

        list($body, $info) = $this->request('/articles');

        // test response
        $this->assertResponseIsOk($info);

        // test index page
        $this->assertStringContainsString('<h1 class="h2">Sample articles</h1>', $body);

    }

    public function testShow()
    {
        list($body, $info) = $this->request('/article/21');

        $this->assertResponseIsOk($info);
        $this->assertStringContainsString('<h1 class="h2">Article 1</h1>', $body);
    }

}