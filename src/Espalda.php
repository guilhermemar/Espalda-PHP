<?php
/**
 * This file is part of Espalda project.
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
 * Copyright 2014 Mar, Guilherme
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
 * The main class of project.
 * It's the class for make the manipulations in the template
 * 
 * @author Mar, Guilherme
 */
class Espalda extends EspaldaDisplay
{
	/**
	 * Version
	 * @var string
	 */
	private $version = '2.0.0';
	/**
	 * Construct
	 * 
	 * @param string $source [optional] Template to be parsed
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
	 * @param string $path Path of template file
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