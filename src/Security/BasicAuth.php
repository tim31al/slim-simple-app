<?php


namespace App\Security;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class BasicAuth extends AuthorisationService
{

    private const HEADER = 'Authorization';

    /**
     * BasicAuth constructor.
     * @param ContainerInterface $container
     * @param Request $request
     */
    public function __construct(ContainerInterface $container, Request $request = null)
    {
        parent::__construct($container);

        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $this->setDataFromServer();
            return;
        }

        if ($request && $request->hasHeader(self::HEADER)) {
            $this->setDataFromHeader($request->getHeader(self::HEADER));
        }

    }

    private function setDataFromHeader($headerData)
    {
        $data = explode(' ', $headerData[0])[1];
        list($un, $pw) = explode(':', base64_decode($data));

        $this->username = $un;
        $this->password = $pw;
    }

    private function setDataFromServer()
    {
        $this->setUsername($_SERVER['PHP_AUTH_USER']);
        $this->setPassword($_SERVER['PHP_AUTH_PW']);

    }
}