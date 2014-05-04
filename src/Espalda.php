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
 * All imports requireds to library
 */
require_once "EspaldaException.php";
require_once "EspaldaRules.php";
require_once "EspaldaScope.php";
require_once "EspaldaParser.php";
require_once "EspaldaLoop.php";
require_once "EspaldaReplace.php";
require_once "EspaldaDisplay.php";

/**
 * Classe inicial do projeto.
 * Manipula o template
 * 
 * @author Mar, Guilherme
 * @version 2.0 very unstable, its not usable.
 * @licence GNU General Public License, version 3
 */
class Espalda extends EspaldaDisplay
{
	private $version = '2.0.0';
	/**
	 * Construct
	 * 
	 * @param [optional] string $source string $source Template to be parsed
	 */
	public function __construct($source=null)
	{
		parent::__construct("root", $source);

		if(!is_null($source)){
			$this->setSource($source);
		}
	}

	/**
	 * Load a template file
	 * 
	 * @param string $source Path of template file
	 * @throws EspaldaException
	 */
	public function loadSource($path)
	{
		if(!file_exists($path) || !is_readable($path)){
			throw new EspaldaException(EspaldaException::LOAD_FILE_ERROR);
		}

		if(!$source = file_get_contents($path)){
			throw new EspaldaException(EspaldaException::LOAD_FILE_ERROR);
		}
	
		$this->setSource($source);
	}

	/**
	 * Show the template parsed
	 */
	public function show()
	{
		echo $this->getOutput();
	}

	/**
	 * Version of this Espalda library
	 * 
	 * @return string
	 */
	public function getVersion ()
	{
		return $this->version;
	}
}
?>