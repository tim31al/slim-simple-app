<?php


namespace Test\Controller;


use Test\WebTestCase;
use Test\WebTestTrait;


class ArticleControllerTest extends WebTestCase
{
    use WebTestTrait;

    public function testIndex()
    {

        list($body, $info) = $this->loadEndpoint('/articles');

        // test response
        $this->assertResponseIsOk($info);

        // test index page
        $this->assertStringContainsString('<h1 class="h2">Sample articles</h1>', $body);

    }

    public function testView()
    {
        list($body, $info) = $this->loadEndpoint('/article/21');

        // test response
        $this->assertResponseIsOk($info);

        // test index page
        $this->assertStringContainsString('<h1 class="h2">Article 1</h1>', $body);

    }

}