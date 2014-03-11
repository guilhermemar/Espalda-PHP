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
require_once "EspaldaEscope.php";
require_once "EspaldaEngine.php";
require_once "EspaldaRegion.php";
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
	/**
	 * Construtora da classe
	 * 
	 * @param [optional] string $source String com o template a ser manipulado
	 * @since 0.7
	 */
	public function __construct($source=FALSE)
	{
		parent::__construct("root", $source);
		
		if(!$source){
			$this->setSource($source);
		}
	}
	/**
	 * Carrega um arquivo de template
	 *
	 * @param string $source Caminho do arquivo de template
	 * @since 0.7
	 */
	public function loadSource($path)
	{
		if(!file_exists($path)){
			return false;
		}
		if(!is_readable($path)){
			return false;
		}
		if(!$source = file_get_contents($path)){
			return false;
		}
	
		$this->setSource($source);
			
		return true;
	}	
	/**
	 * Prepara e exibe o template na tela.
	 * 
	 * @since 0.7
	 */
	public function display()
	{
		echo $this->getOutput();
	}
}
?>