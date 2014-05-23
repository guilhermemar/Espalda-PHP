<?php

require_once "src/Espalda/EspaldaRules.php";
require_once "src/Espalda/EspaldaScope.php";
require_once "src/Espalda/EspaldaParser.php";
require_once "src/Espalda/EspaldaReplace.php";
require_once "src/Espalda/EspaldaLoop.php";
require_once "src/Espalda/EspaldaException.php";
require_once "src/Espalda/EspaldaDisplay.php";

use \Espalda;

class EspaldaLoopTest extends PHPUnit_Framework_TestCase
{
	public function test_verySimpleTemplate ()
	{
		$loop = new Espalda\EspaldaLoop('test1', "escopo ");
		$this->assertEquals("test1", $loop->getName(), "não retornou o valor esperado");
		
		$loop->push();
		
		$this->assertEquals("escopo ", $loop->getOutput(), "não retornou o valor esperado");
		
		$loop->push();
		
		$this->assertEquals("escopo escopo ", $loop->getOutput(), "não retornou o valor esperado");
	}
	
	public function test_verySimpleTemplate2 ()
	{
		$loop = new Espalda\EspaldaLoop('test2');
		$this->assertEquals("test2", $loop->getName());
		$loop->setSource("escopo");
		
		$this->assertEquals("", $loop->getOutput(), "não retornou o valor esperado");
		
		$loop->push();
		
		$this->assertEquals("escopo", $loop->getOutput(), "não retornou o valor esperado");
	}
	
	public function test_replaces ()
	{
		$source = 'valor adicionado é <espalda type="replace" name="troca"> !';
		
		$loop = new Espalda\EspaldaLoop('test', $source);
		$loop->setReplaceValue('troca', 'joão');
		
		$this->assertEquals("valor adicionado é joão !", $loop->getOutput());
		
		$replace = $loop->getReplace("troca");
		$replace->setValue("Alberto");
		$this->assertEquals("valor adicionado é Alberto !", $loop->getOutput());
		
		$loop->push();
		$loop->setReplaceValue('troca', "giovana");
		$this->assertEquals("valor adicionado é Alberto !valor adicionado é giovana !", $loop->getOutput());	
	}
	
	public function test_replaces2 ()
	{
		$source = '<espalda type="replace" name="um"> -> <espalda type="replace" name="dois" value="none"> ';

		$loop = new Espalda\EspaldaLoop('test', $source);
		
		$loop->setReplaceValue('um', 'aluno1');
		$loop->setReplaceValue('dois', 'fulano');
		
		$loop->push();
		$loop->setReplaceValue('um', 'aluno2');
		
		$this->assertEquals('aluno1 -> fulano aluno2 -> none ', $loop->getOutput());
	}
	
	public function test_display ()
	{
		$source = 'um texto qualquer <espalda type="display" name="nome" value="true">com uma tag espalda display</espalda>';
		
		$loop = new Espalda\EspaldaLoop('test', $source);
		$loop->push();
		
		$this->assertEquals('um texto qualquer com uma tag espalda display', $loop->getOutput());
		
		$loop->setDisplayValue("nome", false);
		$this->assertEquals('um texto qualquer ', $loop->getOutput());
		
		$loop->push();
		$this->assertEquals('um texto qualquer um texto qualquer com uma tag espalda display', $loop->getOutput());
	}
	
	public function test_display2 ()
	{
		$source = '<espalda type="display" name="um">multiplos</espalda> <espalda type="display" name="dois" value="true">displays</espalda>';
		
		$loop = new Espalda\EspaldaLoop('test', $source);
		$this->assertEquals('', $loop->getOutput());
		
		$loop->setDisplayValue("um", true);
		$this->assertEquals('multiplos displays', $loop->getOutput());
		
		$loop->push();
		$this->assertEquals('multiplos displays displays', $loop->getOutput());
	}
	
	public function test_loop ()
	{
		$source = 'source <espalda type="loop" name="um"> looping</espalda>';
		
		$loop = new Espalda\EspaldaLoop('test', $source);
		$this->assertEquals('', $loop->getOutput());
		
		$loop->push();
		$this->assertEquals('source ', $loop->getOutput());
		
		$interno = $loop->getLoop('um');
		$interno->push();
		$this->assertEquals('source  looping', $loop->getOutput());
		
		$interno->push();
		$this->assertEquals('source  looping looping', $loop->getOutput());
	}
	
	public function test_loop2 ()
	{
		$source = '<espalda type="loop" name="um">um </espalda><espalda type="loop" name="dois">dois </espalda>';
		
		$loop = new Espalda\EspaldaLoop('test', $source);
		
		$um = $loop->getLoop('um');
		$um->push();
		$um->push();
		
		$dois = $loop->getLoop('dois');
		$dois->push();
		$dois->push();
		$dois->push();
		
		$this->assertEquals('um um dois dois dois ', $loop->getOutput());
		
		$loop->push();
		
		$um = $loop->getLoop('um');
		$um->push();
		
		$dois = $loop->getLoop('dois');
		$dois->push();
		$dois->push();
		$dois->push();
		$dois->push();
		
		$this->assertEquals('um um dois dois dois um dois dois dois dois ', $loop->getOutput());
	}
	
	public function test_final ()
	{
		$source = '!
			<espalda type="replace" name="titulo" value="seuSite">
			
			<espalda type="display" name="slogan" value="false">aqui o slogan do site</espalda>
			
			<espalda type="loop" name="menu">
				<espalda type="replace" name="item">
			</espalda>
		!';
		
		$loop = new Espalda\EspaldaLoop('test', $source);
		$this->assertEquals('', $loop->getOutput());
		
		$assert = '!
			seuSite
			
			
			
			
		!';
				
		$loop->push();
		$this->assertEquals($assert, $loop->getOutput());
		
		$assert = '!
			seuSite
			
			aqui o slogan do site
			
			
		!';
		
		$loop->setDisplayValue("slogan", true);
		$this->assertEquals($assert, $loop->getOutput());
		
		$assert = '!
			seuSite
			
			aqui o slogan do site
			
			
				valor1
			
				valor2
			
		!';
		
		$loopInterno = $loop->getLoop("menu");
		$loopInterno->setReplaceValue("item", "valor1");
		$loopInterno->push();
		$loopInterno->setReplaceValue("item", "valor2");
		
		$this->assertEquals($assert, $loop->getOutput());
	}
}
