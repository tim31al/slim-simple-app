<?php

namespace Test\Unit;

use App\Service\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testResult()
    {
        $result = new Result(Result::SUCCESS, 'user', array('message 1', 'message 2'));

        $this->assertTrue($result->isValid());
        $this->assertStringContainsString('user', $result->getIdentity());
        $this->assertIsArray($result->getMessages());

    }

}
