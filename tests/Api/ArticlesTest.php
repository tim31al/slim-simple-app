<?php


namespace Test\Api;

use Test\WebTestTrait;

class ArticlesTest extends \PHPUnit\Framework\TestCase
{
    use WebTestTrait;

    public function testIndex()
    {
        $this->printToConsole(__METHOD__);

        $response = $this->loadEndpoint('/api/articles');
        $this->assertEquals('application/json', $response['info']['content_type']);
    }

    public function testShow()
    {
        $id = 1;
        $title = 'art1';

        $this->printToConsole(__METHOD__);

        $response = $this->loadEndpoint('/api/article/'.$id);
        $this->assertEquals('application/json', $response['info']['content_type']);
        $this->assertNotFalse(strpos($response['body'], $title));
    }

}