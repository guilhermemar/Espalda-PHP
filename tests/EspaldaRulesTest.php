<?php

require_once "src/Espalda/EspaldaRules.php";

use \Espalda;

class EspaldaRulesTest extends PHPUnit_Framework_TestCase
{
	public function test_TagWithTabsAsSeparator()
	{
		$template = '<espalda type	="display" name="identifier" value="true">content</espalda>';
		$display  = new Espalda\EspaldaDisplay('complex', $template);
		$this->assertEquals('content', $display->getOutput());
	}
}
