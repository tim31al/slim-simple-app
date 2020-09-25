<?php


namespace Test\Controller;

use PHPUnit\Framework\TestCase;
use Test\WebTestTrait;


class HomeControllerTest extends TestCase
{
    use WebTestTrait;

    public function testIndex()
    {
        $this->printToConsole(__METHOD__);
        $response = $this->loadEndpoint('/');


        $this->assertNotEmpty($response, 'response empty');

        $this->assertStringContainsString('Home page', $response['body']);

    }

//    public function testHello()
//    {
//        $this->printToConsole(__METHOD__);
//        $response = $this->loadEndpoint('/hello');
//
////        $this->printToConsole(print_r($response['info']));
//
//        $this->assertNotFalse(strpos($response['body'], 'Hello'));
//    }

}