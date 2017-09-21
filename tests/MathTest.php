<?php

class MathTest extends \PHPUnit\Framework\TestCase
{
    public function testDouble()
    {
        $this->assertEquals(4, \App\Service\Math::double(2));
    }
}