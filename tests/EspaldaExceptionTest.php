<?php
require "sources/EspaldaException.php";

class EspaldaExceptionTest extends PHPUnit_Framework_TestCase
{
    public function test_undefinedException ()
    {
        $e = new EspaldaException(1);

        $this->assertEquals(1, $e->getCode());
        $this->assertEquals('Undefined espalda exception', $e->getMessage());
    }

    public function test_undefinedException2 ()
    {
        $e = new EspaldaException(0);

        $this->assertEquals(0, $e->getCode());
        $this->assertEquals('Undefined espalda exception', $e->getMessage());
    }

    public function test_definedException ()
    {
        $e = new EspaldaException(2);

        $this->assertEquals(2, $e->getCode());
        $this->assertEquals("It's not a estapalda replace", $e->getMessage());
    }
}
?>