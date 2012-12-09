<?php

/*
 * This file is part of Espalda.
 *
 * Espalda is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Espalda is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Espalda.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright 2010 Guilherme Mar
 */

/**
 * Author : Guilherme Mar
 */

require_once "EspaldaDisplay.php";
require_once "EspaldaEngine.php";
require_once "EspaldaLine.php";
require_once "EspaldaRegion.php";
require_once "EspaldaReplace.php";
require_once "EspaldaRules.php";

class Espalda extends EspaldaDisplay
{
	public function __construct($source=FALSE)
	{
		parent::__construct("root", $source);
		
		if(!$source){
			$this->setSource($source);
		}
	}
	
	public function show()
	{
		echo $this->getSource();
	}
}
?>