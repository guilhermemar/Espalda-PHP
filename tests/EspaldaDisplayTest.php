<?php
require_once "sources/EspaldaRules.php";
require_once "sources/EspaldaEscope.php";
require_once "sources/EspaldaEngine.php";
require_once "sources/EspaldaDisplay.php";

class EspaldaDisplayTest extends PHPUnit_Framework_TestCase
{
	
	private $simpleTemplate = 'content of display';
	private $complex1Template = '... something here	<espalda type="display" name="principal" value="true"> content of display </espalda> more domething here ...'; 
	
    public function test_SimpleDisplay_1 ()
    {
    	
    	$display = new EspaldaDisplay('simple', $this->simpleTemplate);
    	
    	$this->assertEquals('simple', $display->getName(), 'Não está retornando o name correto');
    	$this->assertEquals(true, $display->getValue(), 'não está retornando o value correto');
    	$this->assertEquals('content of display', $display->getOutput(), 'não está retornando o corpo do display correto');
    	
    }
    
    public function test_SimpleDisplay_2 ()
    {
    	
    	$display = new EspaldaDisplay('default name');
    	 
    	$display->setName('simple2');
    	$display->setSource($this->simpleTemplate);
    	$display->setValue(false);
    	
    	$this->assertEquals('simple2', $display->getName(), 'não está setando o nome corretamente');
    	$this->assertEquals(false, $display->getValue(), 'não está setando o value corretamente');
    	$this->assertEquals('content of display', $display->getOutput(), 'não está retando o source corretamente');
    	
    }    
}

?>
