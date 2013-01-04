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
 * Exceção personalizada para o projeto Espalda
*
* @author Guilherme Mar <guilhermemar.dev@gmail.com>
*/
class EspaldaException extends Exception
{
	/**
	 * Conjunto de constantes de erros
	 */
	const UNDEFINED_ESPALDA_EXCEPTION = 1;
	const NOT_ESPALDA_REPLACE = 2;
	const NOT_ESPALDA_DISPLAY = 3;
	const NOT_ESPALDA_REGION = 4;
	const REPLACE_NOT_EXISTS = 5;
	const DISPLAY_NOT_EXISTS = 6;
	const REGION_NOT_EXISTS = 7;
	/**
	 * Mensagens descritivas dos códigos de erro
	 * @var String[]
	 * @static
	 * 
	 * //TODO add descriptions
	 */
	private static $exceptions_description = Array(
		UNDEFINED_ESPALDA_EXCEPTION => 'Undefined espalda exception'
	);
	
	public function __construct($code)
	{
		parent::__construct(
			$this->getRespectiveDescription($code),
			$code
		);
	}
	
	private function getRespectiveDescription ($code)
	{
		if (array_key_exists($code, self::$exceptions_description)) {
			return self::$exceptions_description[$code];
		}  else {
			return self::$exceptions_description[self::UNDEFINED_ESPALDA_EXCEPTION];
		}
	}
	
}