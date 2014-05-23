<?php
require_once "src/Espalda/EspaldaReplace.php";

use \Espalda;

class EspaldaReplaceTest extends PHPUnit_Framework_TestCase
{
	public function test_setDefaultValues ()
	{
		$replace = new Espalda\EspaldaReplace('name', 'value');

		$this->assertEquals('name', $replace->getName());
		$this->assertEquals('value', $replace->getValue());
	}

	public function test_setValues ()
	{
    	$replace = new Espalda\EspaldaReplace('undefined');
    	
    	$replace->setName('name');
    	$replace->setValue('value');
    
    	$this->assertEquals('name', $replace->getName());
    	$this->assertEquals('value', $replace->getValue());
    }
    
    public function test_output ()
    {
    	$replace = new Espalda\EspaldaReplace('name', 'a value added on create object');
    	
    	$this->assertEquals('a value added on create object', $replace->getOutput());
    }
    
    public function test_clone ()
    {
    	$replace = new Espalda\EspaldaReplace('name', 'default value');
    	
    	$this->assertEquals($replace, clone $replace);
    }
}
?>