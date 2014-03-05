<?php

require_once "sources/EspaldaEscope.php";
require_once "sources/EspaldaReplace.php";
require_once "sources/EspaldaDisplay.php";

class EspaldaEscopeTest extends PHPUnit_Framework_TestCase
{
	
	private $escope;
	
	public function __construct ()
	{
		$this->escope = new EspaldaEscope();
	}
	
    public function test_replaces ()
    {
        for ($i=1; $i<3; ++$i) {
        	$this->escope->addReplace(new EspaldaReplace('name'.$i, 'valor'.$i));
        }
        
        $this->assertTrue($this->escope->replaceExists('nome1'));
        $this->assertFalse($this->escope->replaceExists('nome11'));
        
        $this->escope->setReplaceValue('nome2', 'valor20');
        
        $this->assertEquals('valor20', $this->escope->getReplace('nome2')->getValue());
        $this->assertNotEquals('valor2', $this->escope->getReplace('nome2')->getValue());
    }
    
    public function test_displays ()
    {
    	for ($i=1; $i<3; ++$i) {
    		$escope->addDisplay(new EspaldaDisplay('name'.$i, 'source of display number '.$i));
    	}
    	
    }
    
    
}
?>