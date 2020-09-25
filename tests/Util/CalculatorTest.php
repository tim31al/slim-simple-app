<?php


namespace Test\Util;

use App\Util\Calculator;
use PHPUnit\Framework\TestCase;


class CalculatorTest extends TestCase
{
    private Calculator $c;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->c = new Calculator();
    }

    public function testAdd()
    {
        $result = $this->c->add(20, 10);

        $this->assertEquals(30, $result);
    }

//    public function testDiv()
//    {
//        $result = $this->c->div(4, 2);
//        $this->assertEquals(2, $result);
//
//        try {
//            $result = $this->c->div(2, 0);
//        } catch (\Exception $exc) {
//            $this->assertInstanceOf(\InvalidArgumentException::class, $exc);
//            $this->assertSame($exc->getMessage(), 'division by zero');
//        }
//    }

}