<?php

require_once "src/Espalda/EspaldaRules.php";
require_once "src/Espalda/EspaldaScope.php";
require_once "src/Espalda/EspaldaParser.php";
require_once "src/Espalda/EspaldaDisplay.php";

use \Espalda;

class EspaldaDisplayTest extends PHPUnit_Framework_TestCase
{
	
	
	private $simpleTemplate = 'content of display';
	private $complexTemplate = '... something here	<espalda type="display" name="principal" value="true"> content of display </espalda> more something here ...';
	private $complexTemplate2 = '... something here	<espalda type="display" name="principal" value="true"> content of display </espalda> more something here <espalda type="replace" name="aqui"> ...';
	
    public function test_SimpleDisplay_1 ()
    {
    	$display = new Espalda\EspaldaDisplay('simple', $this->simpleTemplate, false);
    	
    	$this->assertEquals('simple', $display->getName(), 'Não está retornando o name correto');
    	$this->assertEquals(false, $display->getValue(), 'não está retornando o value correto');
    	$this->assertEquals('', $display->getOutput(), 'não está retornando o corpo do display correto');
    	
    	$display->setValue(true);
    	$this->assertEquals('content of display', $display->getOutput(), 'não está retornando o corpo do display correto');
    }
    
    public function test_SimpleDisplay_2 ()
    {
    	$display = new Espalda\EspaldaDisplay('default name');
    	 
    	$display->setName('simple2');
    	$display->setSource($this->simpleTemplate);
    	$display->setValue(false);
    	
    	$this->assertEquals('simple2', $display->getName(), 'não está setando o nome corretamente');
    	$this->assertEquals(false, $display->getValue(), 'não está setando o value corretamente');
    }

    public function test_complexDisplay_1 ()
    {
    	$display = new Espalda\EspaldaDisplay("complex", $this->complexTemplate);
    	$this->assertEquals("... something here	 content of display  more something here ...", $display->getOutput(), "não retornou o conteúdo nos valores defaults");
    }
    
    public function test_complexDisplay_2 ()
    {
    	$display = new Espalda\EspaldaDisplay("complex", $this->complexTemplate);
    	
    	$internalDisplay = $display->getDisplay('principal');
    	$this->assertEquals(" content of display ", $internalDisplay->getOutput(), "não retornou o conteúdo esperado de uma display interna");
    }
    
    public function test_complexDisplay_3 ()
    {
    	$display = new Espalda\EspaldaDisplay("complex", $this->complexTemplate);
    	 
    	$internalDisplay = $display->getDisplay('principal');
    	$internalDisplay->setValue(false);
    	 
    	$this->assertEquals("... something here	 more something here ...", $display->getOutput(), "não retornou o conteúdo esperado da display");
    }
    
    public function test_complexDisplay_4 ()
    {
    	$display = new Espalda\EspaldaDisplay("complex", $this->complexTemplate);
    	
    	$internalDisplay = $display->getDisplay("principal", true);
    	$internalDisplay->setValue(false);
    	    	
    	$this->assertEquals("... something here	 content of display  more something here ...", $display->getOutput(), "um getDisplay clonado alterou o valor da classe da qual ela foi copiada");
    }
    
    public function test_complexDisplay_5 ()
    {
    	$display = new Espalda\EspaldaDisplay("complex", $this->complexTemplate);
    	$display->setDisplayValue('principal', false);
    
    	$this->assertEquals("... something here	 more something here ...", $display->getOutput(), "não retornou o conteúdo esperado da display");
    }
    
    public function test_complexDisplay_6 ()
    {
    	$display = new Espalda\EspaldaDisplay("complex", $this->complexTemplate2);
    	 
    	$this->assertEquals("... something here	 content of display  more something here  ...", $display->getOutput(), "Não retornou o valor default");
    }
    
    public function test_complexDisplay_7 ()
    {
    	$display = new Espalda\EspaldaDisplay("complex", $this->complexTemplate2);
    	
    	$display->setDisplayValue('principal', false);
    	$display->setReplaceValue("aqui", "!!!Aqui seu valor desejado!!!");
    
    	$this->assertEquals("... something here	 more something here !!!Aqui seu valor desejado!!! ...", $display->getOutput(), "não retornou o conteúdo esperado da display");
     }
    
    public function test_complexDisplay_8 ()
    {
    	$display = new Espalda\EspaldaDisplay("complex", $this->complexTemplate2);
    	
    	$replace = $display->getReplace("aqui");
    	$replace->setValue("alterado em separado");
    
    	$this->assertEquals("... something here	 content of display  more something here alterado em separado ...", $display->getOutput(), "Não alterou conforme alteração feita na classe externa");
    }
    
    public function test_complexDisplay_9 ()
    {
    	$display = new Espalda\EspaldaDisplay("complex", $this->complexTemplate2);
    	 
    	$replace = $display->getReplace("aqui", true);
    	$replace->setValue("alterado em separado");
    
    	$this->assertEquals("... something here	 content of display  more something here  ...", $display->getOutput(), "Classe replace retornada com a opção clone=true alterou o valor original");
    }
    
    public function test_clone ()
    {
    	$display = new Espalda\EspaldaDisplay("original", "a default scope", false);
    	$cloned = clone $display;
    	
    	$this->assertEquals("original", $cloned->getName(), "não clonou o nome");
    	$this->assertEquals("a default scope", $cloned->getSource(), "não clonou o source");
    	$this->assertEquals(false, $cloned->getValue(), "não clonou o value");	
    }
}
?>