<?php 

include __DIR__ . "/../../espalda/Espalda.php";
		
echo time();

/*
 * definindo funcao para debug do projeto
 */
function v($c) {
	
	echo "<pre>";
	print_r($c);
	echo "</pre>";
	
}


$template = new Espalda();
$template->loadSource("template.html");

//$template->setReplace("TITLE", "Titulo inserido dinamicamente");

$regiao = $template->getRegion("TABLE_TR");
$regiao->getDisplay("ver_titulo")->setReplace("TITLE", "Nome:");
$regiao->setReplace("VALUE", "Nome para teste");
$regiao->moreLine();
$regiao->getDisplay("ver_titulo")->setReplace("TITLE", "Idade:");
$regiao->setReplace("VALUE", "Vinte e dois");

$template->setReplace("DIV_CONT1", "Conteúdo um");
$template->setReplace("DIV_CONT2", "Aqui o conteudo dois");

$template->getDisplay("ver")->setValue(true);

//$template->getRegion("TABLE2_TR")->setReplace("TITLE", "Nome:");
$template->getRegion("TABLE2_TR")->getRegion("values")->setReplace("VALUE", "Marinho");
$template->getRegion("TABLE2_TR")->moreLine();
$template->getRegion("TABLE2_TR")->setReplace("TITLE", "Idade:");

$r = $template->getRegion("TABLE2_TR")->getRegion("values");
$r->setReplace("VALUE", "22 ");
$r->moreLine();
$r->setReplace("VALUE", "23 ");
$r->moreLine();
$r->setReplace("VALUE", "24 ");
$r->moreLine();
$r->setReplace("VALUE", "25 ");

echo "<br><br><br><br>";

$template->display(); 

?>