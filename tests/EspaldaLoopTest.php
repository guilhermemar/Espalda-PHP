<?php

require_once "src/EspaldaRules.php";
require_once "src/EspaldaScope.php";
require_once "src/EspaldaEngine.php";
require_once "src/EspaldaLoop.php";

class EspaldaLoopTest extends PHPUnit_Framework_TestCase
{
	public function test_verySimpleTemplate ()
	{
		$loop = new EspaldaLoop('test1', "escopo ");
		$this->assertEquals("test1", $loop->getName(), "não retornou o valor esperado");
		
		$loop->push();
		
		$this->assertEquals("escopo ", $loop->getOutput(), "não retornou o valor esperado");
		
		$loop->push();
		
		$this->assertEquals("escopo escopo ", $loop->getOutput(), "não retornou o valor esperado");
	}
	
	public function test_verySimpleTemplate2 ()
	{
		$loop = new EspaldaLoop('test2');
		$this->assertEquals("test2", $loop->getName());
		$loop->setSource("escopo");
		
		$this->assertEquals("", $loop->getOutput(), "não retornou o valor esperado");
		
		$loop->push();
		
		$this->assertEquals("escopo", $loop->getOutput(), "não retornou o valor esperado");
	}
	
	public function test_replaces ()
	{
		$source = "valor adicionado é <espalda type='replace' name='troca'> !";
		
		$loop = new EspaldaLoop('test', $source);
		$loop->setReplaceValue('troca', 'joão');
		
		$this->assertEquals("valor adicionado é joão !", $loop->getOutput());
	}
	
}