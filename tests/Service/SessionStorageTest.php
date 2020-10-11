<?php

namespace Test\Service;

use App\Service\SessionStorage;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;


class SessionStorageTest extends TestCase
{
    private SessionStorage $storage;
    private ContainerInterface $c;

    public function setUp(): void
    {
        $builder = new ContainerBuilder();

        $builder->addDefinitions(
            __DIR__.'/../../config/settings.php',
            __DIR__.'/../../config/settings.local.php',
        );
        $builder->addDefinitions(__DIR__ . '/../../config/services.php');
        $container = $builder->build();

        $this->c = $container;
        $this->storage = new SessionStorage($container);
    }

    public function testRunning()
    {
        $status = session_status();
        $this->assertSame(PHP_SESSION_ACTIVE, $status);
    }

    public function testEmpty()
    {
        $key = 'key_' . rand(1, 10);
        $this->assertTrue($this->storage->isEmpty($key));
    }

    public function testCrudSessionData()
    {
        $key = 'user';
        $username = 'alex';
        $id = 1;

        // write data
        $this->storage->write($key, array($username, $id));
        $this->assertTrue($this->storage->hasKey($key));

        // read data
        list($user, $user_id) = $this->storage->read($key);
        $this->assertSame($username, $user);
        $this->assertSame($id, $user_id);

        // clear data
        $this->storage->clear($key);
        $this->assertTrue($this->storage->isEmpty($key));
    }

    public function tearDown(): void
    {
        session_destroy();
    }

}
