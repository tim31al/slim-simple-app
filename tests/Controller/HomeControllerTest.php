<?php


namespace Test\Controller;

use PHPUnit\Framework\TestCase;
use Test\WebTestCase;
use Test\WebTestTrait;


class HomeControllerTest extends WebTestCase
{
    use WebTestTrait;

    public function testIndex()
    {
        $this->printToConsole(__METHOD__);
        $response = $this->loadEndpoint('/');

        $this->assertNotEmpty($response, 'response empty');

        $this->assertStringContainsString('Home page', $response['body']);

    }

//    public function testServer()
//    {
//        $this->printToConsole(__METHOD__);
//        $response = $this->loadEndpoint('/server');
//
//        $this->assertResponseIsOk($response['info']);
//
//    }

    public function testNoRoute()
    {
        $response = $this->loadEndpoint('/no-route');

        $this->assertFalse($response['info']['http_code'] == 200);
    }

}