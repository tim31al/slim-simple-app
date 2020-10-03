<?php

namespace Test\Model;

use App\App;
use App\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected \Slim\App $app;


    public function setUp(): void
    {
        $this->app = (new App(true))->get();
    }

    public function testCRUD()
    {
        $model = new User($this->app->getContainer());

        $username = 'user';
        $email = 'user@mail.com';
        $password = 'r477ed90';
        $fullName = 'Пользователь Пользовательский';
        $role = 'ROLE_USER';

        $rowsBeforeTest = $model->read();

        $model->setUsername($username);
        $model->setPassword($password);
        $model->setEmail($email);
        $model->setFullName($fullName);
        $model->setRole($role);

        // Test create
        $id = $model->create();
        $model->setId($id);

        $this->assertTrue($id > 0);

        // Test read
        $row = $model->read($id);
        $this->assertSame($username, $row['username']);

        // Test update
        $model->setEmail('newmail@mail.com');
        $stmt = $model->update();
        $this->assertTrue($stmt);


        // Test update role
        $model->setRole('ROLE_ADMIN');
        $this->assertTrue($model->validate(false));

        // Test error
//        $role = 'swin';
//        try {
//            $model->setRole($role);
//        } catch (\InvalidArgumentException $e) {
//            $statement = sprintf('setRole("%s"): %s', $role, $e->getMessage());
//            fwrite(STDOUT, $statement."\n");
//
//        }


        // test login
        $this->assertTrue($model->login());

        $this->assertTrue(User::isLogged());

        // test logout
        User::logout();

        $this->assertFalse(User::isLogged());


        // Test delete
        $this->assertTrue($model->delete());

        $rowsAfterTest = $model->read();
        $this->assertEquals($rowsBeforeTest, $rowsAfterTest);

    }

}
