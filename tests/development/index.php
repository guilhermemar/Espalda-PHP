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



$template->setReplaceValue("DIV_CONT1", "Conteúdo um");

$regiao = $template->getRegion("TABLE_TR");
$regiao->getDisplay("ver_titulo")->setReplaceValue("TITLE", "Nome:");

v("1- " . $regiao->getDisplay("ver_titulo")->getReplace("TITLE")->getValue());
v("a- " . $regiao->getDisplayOriginal("ver_titulo")->getReplace("TITLE")->getValue());

$regiao->setReplaceValue("VALUE", "Nome para teste");

$regiao->moreLine();
v("2- " . $regiao->getDisplay("ver_titulo")->getReplace("TITLE")->getValue());
v("b- " . $regiao->getDisplayOriginal("ver_titulo")->getReplace("TITLE")->getValue());
$regiao->getDisplay("ver_titulo")->setReplaceValue("TITLE", "Nome adicionade depois:");
v("3- " . $regiao->getDisplay("ver_titulo")->getReplace("TITLE")->getValue());
v("c- " . $regiao->getDisplayOriginal("ver_titulo")->getReplace("TITLE")->getValue());
$regiao->setReplaceValue("VALUE", "Nome para teste 2");

/*

$regiao->getDisplay("ver_titulo")->setReplaceValue("TITLE", "Idade:");
$regiao->setReplaceValue("VALUE", "Vinte e dois");
*/

$template->setReplaceValue("DIV_CONT2", "<br><br>Aqui o conteudo dois<br><br>");
$template->getDisplay("ver")->setValue(true);

$template->getRegion("TABLE2_TR")->setReplaceValue("TITLE", "Nome:");
$template->getRegion("TABLE2_TR")->getRegion("values")->setReplaceValue("VALUE", "Marinho");
$template->getRegion("TABLE2_TR")->moreLine();
$template->getRegion("TABLE2_TR")->setReplaceValue("TITLE", "Idade:");

$r = $template->getRegion("TABLE2_TR")->getRegion("values");
$r->setReplaceValue("VALUE", "22 ");
$r->moreLine();
$r->setReplaceValue("VALUE", "23 ");
$r->moreLine();
$r->setReplaceValue("VALUE", "24 ");
$r->moreLine();
$r->setReplaceValue("VALUE", "25 ");
$r->moreLine();
$r->setReplaceValue("VALUE", "26 ");

echo "<br><br><br><br>";

$template->display(); 

?>