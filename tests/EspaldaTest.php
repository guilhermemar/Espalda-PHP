<?php
require_once "src/Espalda/Espalda.php";

use \Espalda;

class EspaldaTest extends PHPUnit_Framework_TestCase
{
	public function test_template ()
	{
		$espalda = new Espalda\Espalda();
		$espalda->loadSource("tests/templateTest.html");
		
		//file_put_contents("tests/templateResult1.html", $espalda->getOutput());
		$this->assertEquals(file_get_contents("tests/templateResult1.html"), $espalda->getOutput());
		
		$espalda->setReplaceValue("title", "Espalda Teste");
		
		$menu = $espalda->getLoop("itens_menu");
		$menu->setReplaceValue("item", "item teste");
		$menu->push();
		$menu->setReplaceValue("item", "item teste dois");
		$menu->push();
		$menu->setReplaceValue("item", "terceiro item de teste");
		
		//file_put_contents("tests/templateResult2.html", $espalda->getOutput());
		$this->assertEquals(file_get_contents("tests/templateResult2.html"), $espalda->getOutput());
		
		$espalda->setDisplayValue("conteudo", true);
		
		//file_put_contents("tests/templateResult3.html", $espalda->getOutput());
		$this->assertEquals(file_get_contents("tests/templateResult3.html"), $espalda->getOutput());

	}
}
?>