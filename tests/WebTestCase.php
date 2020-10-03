<?php


namespace Test;


class WebTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param array $response curl CURLOPT_URL
     */
    public function assertResponseIsOk(array $response) : void
    {
        static::assertSame(200, $response['http_code']);
//        static::assertStringContainsString('200 OK', $response);
    }

}