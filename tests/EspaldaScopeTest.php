<?php
require_once "src/Espalda/EspaldaException.php";
require_once "src/Espalda/EspaldaScope.php";
require_once "src/Espalda/EspaldaReplace.php";
require_once "src/Espalda/EspaldaParser.php";
require_once "src/Espalda/EspaldaDisplay.php";
require_once "src/Espalda/EspaldaRules.php";
require_once "src/Espalda/EspaldaLoop.php";

use \Espalda;

class EspaldaScopeTest extends PHPUnit_Framework_TestCase
{
	private $scope;
	
	public function __construct ()
	{
		$this->scope = new Espalda\EspaldaScope();
	}
	
    public function test_replaces ()
    {
        $this->scope->addReplace(new Espalda\EspaldaReplace("TituloSite", "Espalda"));
        $this->scope
        	->addReplace(new Espalda\EspaldaReplace("MensagemAuxiliar"))
        	->addReplace(new Espalda\EspaldaReplace("Email", ""));
        
        $this->assertTrue($this->scope->replaceExists('TituloSite'), "Não encontrou um EspaldaReplace existente");
        $this->assertTrue($this->scope->replaceExists('titulosite'), "Não encontrou um EspaldaReplace existente com case de letras diferentes");
        $this->assertFalse($this->scope->replaceExists('MensagemPrincipal', "Encontrou um EspaldaReplace que não existe"));
        
        //fazendo get objeto sem clonar
        $tituloSite = $this->scope->getReplace("TituloSite");
        $this->assertTrue($tituloSite instanceof Espalda\EspaldaReplace, "Não retornou uma instância de EspaldaReplace");
        
        //fazendo get de objeto clonando
        $tituloSite2 = $this->scope->getReplace("TituloSite", true);
        $this->assertTrue($tituloSite2 instanceof Espalda\EspaldaReplace, "Não retornou uma instância de EspaldaReplace (get clonado)");
         
        $this->scope
        	->setReplaceValue("TituloSite", "Novo Espalda Replace")
        	->setReplaceValue("Email", "gfmarster@gmail.com");
        
        //testando se aterou value no não clonado e não alterou no clonado
        $this->assertEquals("Novo Espalda Replace", $tituloSite->getValue(), "Não alterou o value em um objeto EspaldaReplace não clonado");
        $this->assertNotEquals("Novo Espalda Replace", $tituloSite2->getValue(), "Alterou o value em um objeto EspaldaReplace clonado");
    }
    
    public function test_displays ()
    {
    	$this->scope->addDisplay(new Espalda\EspaldaDisplay("Banner", "<img src='http://src.to/banner'>", true));
    	$this->scope
    	->addDisplay(new Espalda\EspaldaDisplay("Parceiros", "<ul><li>parceiro um</li><li>parceiro dois</li></ul>"))
    	->addDisplay(new Espalda\EspaldaDisplay("Email", ""));
    
    	$this->assertTrue($this->scope->displayExists('Banner'), "Não encontrou um EspaldaDisplay existente");
    	$this->assertTrue($this->scope->displayExists('banner'), "Não encontrou um EspaldaDisplay existente com case de letras diferentes");
    	$this->assertFalse($this->scope->displayExists('Companheiros', "Encontrou um EspaldaDisplay que não existe"));
    
    	//fazendo get objeto sem clonar
    	$banner = $this->scope->getDisplay("Banner");
    	$this->assertTrue($banner instanceof Espalda\EspaldaDisplay, "Não retornou uma instância de EspaldaDisplay");
    
    	//fazendo get de objeto clonando
    	$banner2 = $this->scope->getDisplay("Banner", true);
    	$this->assertTrue($banner2 instanceof Espalda\EspaldaDisplay, "Não retornou uma instância de EspaldaDisplay (get clonado)");
    	 
    	$this->scope
    	->setDisplayValue("Banner", false)
    	->setDisplayValue("Email", true);
    
    	//echo $banner->getValue();
    	
    	//testando se aterou value no não clonado e não alterou no clonado
    	$this->assertEquals(false, $banner->getValue(), "Não alterou o value em um objeto EspaldaDisplay não clonado");
    	$this->assertNotEquals(false, $banner2->getValue(), "Alterou o value em um objeto EspaldaDisplay clonado");
    }
    
    public function test_loops ()
    {
    	$this->scope->addLoop(new Espalda\EspaldaLoop("TopoItens", "Item "));
    	$this->scope
    	->addLoop(new Espalda\EspaldaLoop("Menu"))
    	->addLoop(new Espalda\EspaldaLoop("Submenu", ""));
    
    	$this->assertTrue($this->scope->loopExists('TopoItens'), "Não encontrou um EspaldaLoop existente");
    	$this->assertTrue($this->scope->loopExists('topoitens'), "Não encontrou um EspaldaLoop existente com case de letras diferentes");
    	$this->assertFalse($this->scope->loopExists('Comentarios', "Encontrou um EspaldaLoop que não existe"));
    
    	//fazendo get objeto sem clonar
    	$topoItens = $this->scope->getLoop("TopoItens");
    	$this->assertTrue($topoItens instanceof Espalda\EspaldaLoop, "Não retornou uma instância de EspaldaLoop");
    
    	//fazendo get de objeto clonando
    	$topoItens2 = $this->scope->getLoop("TopoItens", true);
    	$this->assertTrue($topoItens2 instanceof Espalda\EspaldaLoop, "Não retornou uma instância de EspaldaLoop (get clonado)");
    
    	$topoItens->setSource('Item alterado');
    
    	$topoItens3 = $this->scope->getLoop('TopoItens', true);
    	
    	//testando se aterou value no não clonado e não alterou no clonado
    	$this->assertEquals('Item alterado', $topoItens3->getSource(), "Não alterou o source em um objeto EspaldaLoop não clonado");
    	$this->assertNotEquals('Item alterado', $topoItens2->getSource(), "Alterou o source em um objeto EspaldaLoop clonado");
    }
    
    public function test_getAll ()
    {
    	$scope = new Espalda\EspaldaScope();
    	
    	$scope->addReplace(new Espalda\EspaldaReplace("replace1"));
    	$scope->addReplace(new Espalda\EspaldaReplace("replace2"));
    	$scope->addReplace(new Espalda\EspaldaReplace("replace3"));
    	
    	$scope->addDisplay(new Espalda\EspaldaDisplay("display1"));
    	$scope->addDisplay(new Espalda\EspaldaDisplay("display2"));
    	
    	$scope->addLoop(new Espalda\EspaldaLoop("loop1"));
    	
    	$replaces = $scope->getAllReplaces();
    	$this->assertEquals(3, count($replaces), "Não retornou a quantidade certa de replaces");
    	
    	$displays = $scope->getAllDisplays();
    	$this->assertEquals(2, count($displays), "Não retornou a quantidade certa de displays");
    	
    	$loops = $scope->getAllLoops();
    	$this->assertEquals(1, count($loops), "Não retornou a quantidade certa de loops");
    }
    
    public function test_clone ()
    {
    	$scope = new Espalda\EspaldaScope();
    	 
    	$scope->addReplace(new Espalda\EspaldaReplace("replace1"));
    	$scope->addReplace(new Espalda\EspaldaReplace("replace2"));
    	$scope->addReplace(new Espalda\EspaldaReplace("replace3"));
    	 
    	$scope->addDisplay(new Espalda\EspaldaDisplay("display1"));
    	$scope->addDisplay(new Espalda\EspaldaDisplay("display2"));
    	 
    	$scope->addLoop(new Espalda\EspaldaLoop("loop1"));
    	
    	$scope2 = clone $scope;
    	
    	$this->assertEquals($scope2, $scope, "Não retornou um clone correto");
    }
}
?>