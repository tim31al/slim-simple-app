<?php

namespace Test\Model;

use App\App;
use App\Model\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    protected \Slim\App $app;

    private Article $model;

    public function setUp(): void
    {
        $this->app = (new App(true))->get();

    }

    public function testCRUD()
    {
        $title = 'Article 1';
        $content = 'Content article 1';
        $date = new \DateTime();

        $model = new Article($this->app->getContainer());

        $rowsBeforeTest = $model->read();


        $model->setTitle($title);
        $model->setContent($content);
        $model->setDate($date);

        $id = $model->create();

        $this->assertTrue($id > 0);

        $row = $model->read($id);
        $this->assertSame($title, $row['title']);


        $model->setTitle($title. ' ' . $title);
        $model->setContent($content . ' ' . $content);
        $model->update();

        $row = $model->read($id);
        $this->assertSame($title . ' ' . $title, $row['title']);
        $this->assertSame($content . ' ' . $content, $row['content']);
        $this->assertSame($date->format('Y-m-d H:i:s'), $row['date']);

        $this->assertTrue($model->delete());

        $rowsAfterTest = $model->read();
        $this->assertEquals($rowsBeforeTest, $rowsAfterTest);

    }


}
