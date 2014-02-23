<?php
require "sources/EspaldaReplace.php";

class EspaldaReplaceTest extends PHPUnit_Framework_TestCase
{
    public function test_setDefaultValues ()
    {
        $replace = new EspaldaReplace('name', 'value');

        $this->assertEquals('name', $replace->getName());
        $this->assertEquals('value', $replace->getValue());
    }
    
    public function test_setValues ()
    {
    	$replace = new EspaldaReplace();
    	
    	$replace->setName('name');
    	$replace->setValue('value');
    
    	$this->assertEquals('name', $replace->getName());
    	$this->assertEquals('value', $replace->getValue());
    }
    
    public function test_output ()
    {
    	$replace = new EspaldaReplace('name', 'a value added on create object');
    	
    	$this->assertEquals('a value added on create object', $replace->getOutput());
    }
    
    public function test_clone ()
    {
    	$replace = new EspaldaReplace('name', 'default value');
    	
    	$this->assertEquals($replace, clone $replace);
    }
}
?>