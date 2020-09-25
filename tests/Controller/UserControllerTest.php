<?php

namespace Test\Controller;


use Test\WebTestTrait;

class UserControllerTest extends \PHPUnit\Framework\TestCase
{
    use WebTestTrait;

    public function testIndex()
    {
        $this->printToConsole(__METHOD__);
        $response = $this->loadEndpoint('/user');

//        $this->printToConsole(print_r($response['info']));


        $this->assertStringContainsString('Alex', $response['body']);
    }

}