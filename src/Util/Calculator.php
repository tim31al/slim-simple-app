<?php


namespace App\Util;


class Calculator
{
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }

    public function div(int $a, int $b): int
    {
        if($b === 0)
            throw new \InvalidArgumentException('division by zero');

        return (int) $a / $b;
    }

}