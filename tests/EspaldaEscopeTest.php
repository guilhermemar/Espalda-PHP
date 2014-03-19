<?php
require_once "src/EspaldaException.php";
require_once "src/EspaldaEscope.php";
require_once "src/EspaldaReplace.php";
require_once "src/EspaldaEngine.php";
require_once "src/EspaldaDisplay.php";
require_once "src/EspaldaRules.php";
require_once "src/EspaldaLoop.php";

//TODO Parece que se o teste dá erro ele não   mostra que deu erro no. Quando executa phing test

class EspaldaEscopeTest extends PHPUnit_Framework_TestCase
{
	public function test_ () {}
	
	private $escope;
	
	public function __construct ()
	{
		$this->escope = new EspaldaEscope();
	}
	
    public function test_replaces ()
    {
        $this->escope->addReplace(new EspaldaReplace("TituloSite", "Espalda"));
        $this->escope
        	->addReplace(new EspaldaReplace("MensagemAuxiliar"))
        	->addReplace(new EspaldaReplace("Email", ""));
        
        $this->assertTrue($this->escope->replaceExists('TituloSite'), "Não encontrou um EspaldaReplace existente");
        $this->assertTrue($this->escope->replaceExists('titulosite'), "Não encontrou um EspaldaReplace existente com case de letras diferentes");
        $this->assertFalse($this->escope->replaceExists('MensagemPrincipal', "Encontrou um EspaldaReplace que não existe"));
        
        //fazendo get objeto sem clonar
        $tituloSite = $this->escope->getReplace("TituloSite");
        $this->assertTrue($tituloSite instanceof EspaldaReplace, "Não retornou uma instância de EspaldaReplace");
        
        //fazendo get de objeto clonando
        $tituloSite2 = $this->escope->getReplace("TituloSite", true);
        $this->assertTrue($tituloSite2 instanceof EspaldaReplace, "Não retornou uma instância de EspaldaReplace (get clonado)");
         
        $this->escope
        	->setReplaceValue("TituloSite", "Novo Espalda Replace")
        	->setReplaceValue("Email", "gfmarster@gmail.com");
        
        //testando se aterou value no não clonado e não alterou no clonado
        $this->assertEquals("Novo Espalda Replace", $tituloSite->getValue(), "Não alterou o value em um objeto EspaldaReplace não clonado");
        $this->assertNotEquals("Novo Espalda Replace", $tituloSite2->getValue(), "Alterou o value em um objeto EspaldaReplace clonado");
    }
    
    public function test_displays ()
    {
    	$this->escope->addDisplay(new EspaldaDisplay("Banner", "<img src='http://src.to/banner'>", true));
    	$this->escope
    	->addDisplay(new EspaldaDisplay("Parceiros", "<ul><li>parceiro um</li><li>parceiro dois</li></ul>"))
    	->addDisplay(new EspaldaDisplay("Email", ""));
    
    	$this->assertTrue($this->escope->displayExists('Banner'), "Não encontrou um EspaldaDisplay existente");
    	$this->assertTrue($this->escope->displayExists('banner'), "Não encontrou um EspaldaDisplay existente com case de letras diferentes");
    	$this->assertFalse($this->escope->displayExists('Companheiros', "Encontrou um EspaldaDisplay que não existe"));
    
    	//fazendo get objeto sem clonar
    	$banner = $this->escope->getDisplay("Banner");
    	$this->assertTrue($banner instanceof EspaldaDisplay, "Não retornou uma instância de EspaldaDisplay");
    
    	//fazendo get de objeto clonando
    	$banner2 = $this->escope->getDisplay("Banner", true);
    	$this->assertTrue($banner2 instanceof EspaldaDisplay, "Não retornou uma instância de EspaldaDisplay (get clonado)");
    	 
    	$this->escope
    	->setDisplayValue("Banner", false)
    	->setDisplayValue("Email", true);
    
    	//echo $banner->getValue();
    	
    	//testando se aterou value no não clonado e não alterou no clonado
    	$this->assertEquals(false, $banner->getValue(), "Não alterou o value em um objeto EspaldaDisplay não clonado");
    	$this->assertNotEquals(false, $banner2->getValue(), "Alterou o value em um objeto EspaldaDisplay clonado");
    }
    
    public function test_loops ()
    {
    	$this->escope->addLoop(new EspaldaLoop("TopoItens", "Item "));
    	$this->escope
    	->addLoop(new EspaldaLoop("Menu"))
    	->addLoop(new EspaldaLoop("Submenu", ""));
    
    	$this->assertTrue($this->escope->loopExists('TopoItens'), "Não encontrou um EspaldaLoop existente");
    	$this->assertTrue($this->escope->loopExists('topoitens'), "Não encontrou um EspaldaLoop existente com case de letras diferentes");
    	$this->assertFalse($this->escope->loopExists('Comentarios', "Encontrou um EspaldaLoop que não existe"));
    
    	//fazendo get objeto sem clonar
    	$topoItens = $this->escope->getLoop("TopoItens");
    	$this->assertTrue($topoItens instanceof EspaldaLoop, "Não retornou uma instância de EspaldaLoop");
    
    	//fazendo get de objeto clonando
    	$topoItens2 = $this->escope->getLoop("TopoItens", true);
    	$this->assertTrue($topoItens2 instanceof EspaldaLoop, "Não retornou uma instância de EspaldaLoop (get clonado)");
    
    	$topoItens->setSource('Item alterado');
    
    	$topoItens3 = $this->escope->getLoop('TopoItens', true);
    	
    	//testando se aterou value no não clonado e não alterou no clonado
    	$this->assertEquals('Item alterado', $topoItens3->getSource(), "Não alterou o source em um objeto EspaldaLoop não clonado");
    	$this->assertNotEquals('Item alterado', $topoItens2->getSource(), "Alterou o source em um objeto EspaldaLoop clonado");
    }
    
    
}
?>