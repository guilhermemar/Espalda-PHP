<?php

require_once "src/Espalda/EspaldaRules.php";
require_once "src/Espalda/EspaldaScope.php";
require_once "src/Espalda/EspaldaParser.php";
require_once "src/Espalda/EspaldaReplace.php";
require_once "src/Espalda/EspaldaLoop.php";
require_once "src/Espalda/EspaldaException.php";
require_once "src/Espalda/EspaldaDisplay.php";

use \Espalda;

//classe criada facilitar os testes
class AuxEspaldaParser extends Espalda\EspaldaParser
{
	public function getScope () {
		return $this->scope;
	}
	
	public function getSource2 () {
		return $this->source;
	}
}

class EspaldaParserTest extends PHPUnit_Framework_TestCase
{	
	
	public function test_inlineReplace ()
	{
		$source = "bla [ESPALDA:replace(cumprimento:oi)] bla";
		
		$parser = new AuxEspaldaParser($source);
		
		$replace = $parser->getScope()->getReplace('cumprimento');
		$this->assertEquals('oi', $replace->getOutput());
		
		$replace->setValue('tchau');
		$this->assertEquals('tchau', $replace->getOutput());
	}
	
	public function test_inlineReplace1 ()
	{
		$source = "bla [espalda:replace(cumprimento)] bla";
	
		$parser = new AuxEspaldaParser($source);
	
		$replace = $parser->getScope()->getReplace('cumprimento');
		$this->assertNotEquals('oi', $replace->getOutput());
	
		$replace->setValue('tchau');
		$this->assertEquals('tchau', $replace->getOutput());
	}
	
	public function test_inlineReplace2 ()
	{
		$source = "bla [espalda(cumprimento:oi)] bla";
	
		$parser = new AuxEspaldaParser($source);
	
		$replace = $parser->getScope()->getReplace('cumprimento');
		$this->assertEquals('oi', $replace->getOutput());
	
		$replace->setValue('tchau');
		$this->assertEquals('tchau', $replace->getOutput());
	}
	
	public function test_inlineReplace3 ()
	{
		$source = "bla [espalda(cumprimento)] bla";
	
		$parser = new AuxEspaldaParser($source);
	
		$replace = $parser->getScope()->getReplace('cumprimento');
		$this->assertNotEquals('oi', $replace->getOutput());
	
		$replace->setValue('tchau');
		$this->assertEquals('tchau', $replace->getOutput());
	}
	
	
	public function test_replace ()
	{
		$source = "
			um texto qualquer que tem um <espalda type=\"replace\" name=\"nome\" value=\"replace\"> no meio	
		";
		
		$parser = new AuxEspaldaParser($source);
		
		$replace = $parser->getScope()->getReplace('nome');
		$this->assertEquals('replace', $replace->getOutput());
	
		$replace->setValue('display');
		$this->assertEquals('display', $replace->getOutput());
	}
	
	public function test_replace1 ()
	{
		$source = "
			um texto qualquer que tem um <espalda type=\"replace\" name=\"nome\" > no meio
		";
	
		$parser = new AuxEspaldaParser($source);
	
		$replace = $parser->getScope()->getReplace('nome');
		$this->assertEquals('', $replace->getOutput());
	
		$replace->setValue('replace');
		$this->assertEquals('replace', $replace->getOutput());
	}
	
	public function test_display ()
	{
		$source = "
			um texto qualquer <espalda type=\"display\" name=\"teste\" value=\"true\">que tem um display no meio</espalda>
		";
	
		$parser = new AuxEspaldaParser($source);
	
		$display = $parser->getScope()->getDisplay('teste');
		$this->assertEquals('que tem um display no meio', $display->getOutput());
	
		$display->setValue(false);
		$this->assertEquals('', $display->getOutput());
	}
	
	public function test_display1 ()
	{
		$source = "
			um texto qualquer <espalda type=\"display\" name=\"teste\" >que tem um display no meio</espalda>
		";
	
		$parser = new AuxEspaldaParser($source);
	
		$display = $parser->getScope()->getDisplay('teste');
		$this->assertEquals('', $display->getOutput());
	
		$display->setValue(true);
		$this->assertEquals('que tem um display no meio', $display->getOutput());
	}
	
	public function test_loop ()
	{
		$source = "
			um texto qualquer <espalda type=\"loop\" name=\"teste\">item </espalda>
		";
	
		$parser = new AuxEspaldaParser($source);
	
		$loop = $parser->getScope()->getLoop('teste');
		$loop->push();
		$this->assertEquals('item ', $loop->getOutput());
	
		$loop->push();
		$this->assertEquals('item item ', $loop->getOutput());
	}
	
	/*
	public function test_making ()
	{
		$source = "
			bla bla bla
			<espalda type=\"display\" name=\"construcao\" value=\"true\">
				em construção
				
				<espalda type=\"replace\" name=\"ignorar\">
				
				<espalda type=\"display\" name=\"display_interno\">
				
					<espalda type=\"loop\" name=\"looping_interno_display\">
						lopping interno display
					</espalda>
				
				</espalda>
					
				<espalda type=\"loop\" name=\"looping_interno\">
					lopping interno
				</espalda>
				
			</espalda>
		";
		
		$parser = new AuxEspaldaParser($source);
	}
	*/
}

?>