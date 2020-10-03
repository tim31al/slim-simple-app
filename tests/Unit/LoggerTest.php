<?php

namespace Test;

use Monolog\Handler\StreamHandler;
use PHPUnit\Framework\TestCase;
use Monolog\Logger;

class LoggerTest extends TestCase
{
    public function testLogger()
    {
        $rootPath = realpath(__DIR__ . '/../..');

        $logFile = $rootPath . '/var/log/test.log';
        if (!file_exists($logFile))
            touch($logFile);


        $this->assertFileExists($logFile);

        $log = new Logger('test');
        $log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
        $msg_info = 'info test';
        $log->info($msg_info);

        $content = file_get_contents($logFile);
        $this->assertStringContainsString($msg_info, $content);

        unlink($logFile);

        $this->assertFileDoesNotExist($logFile);

    }


}
