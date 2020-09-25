<?php


namespace App\Controller;


use App\Model\User;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class UserController extends BaseController
{
    public function index(RequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $name = 'Alex';
        $email = 'email@com';

        $user = new User();
        $user->setName('Alex');
        $user->setEmail('email');

        return $this->view->render($response, 'user/index.php', ['user' => $user]);

    }

}