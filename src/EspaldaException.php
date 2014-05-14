<?php
/**
 * This file is part of Espalda project.
 *
 * @author Mar, Guilherme
 * @licence GNU General Public License, version 3
 */

/**
 * Exceptions for Espalda project
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
class EspaldaException extends Exception
{
	/**
	 * Error Code for "Undefined espalda exception"
	 */
	const UNDEFINED_ESPALDA_EXCEPTION = 1;
	/**
	 * Error Code for "It's not a estapalda replace
	 */
	const NOT_ESPALDA_REPLACE = 2;
	/**
	 * Error Code for "It's not a estapalda display"
	 */
	const NOT_ESPALDA_DISPLAY = 3;
	/**
	 * Error Code for "It's not a estapalda loop"
	 */
	const NOT_ESPALDA_LOOP  = 4;
	/**
	 * Error Code for "Replace not exists"
	 */
	const REPLACE_NOT_EXISTS  = 5;
	/**
	 * Error Code for "Display not exists"
	 */
	const DISPLAY_NOT_EXISTS  = 6;
	/**
	 * Error Code for "Loop not exist"
	 */
	const LOOP_NOT_EXISTS   = 7;
	/**
	 * Error Code for "Propertie type not found"
	 */
	const TYPE_NOT_FOUND = 8;
	/**
	 * Error Code for "Propertie name not found"
	 */
	const NAME_NOT_FOUND = 9;
	/**
	 * Error Code for "Invalid value of propertie typ"
	 */
	const INVALID_TYPE = 10;
	/**
	 * Error Code for "Source has a espalda sintaxe erro"
	 */
	const SINTAXE_ERROR = 11;
	/**
	 * Error Code for "'Parser error"
	 */
	const PARSER_ERROR = 12;
	/**
	 * Error Code for "Could not load file"
	 */
	const LOAD_FILE_ERROR = 13;

	/**
	 * Descriptions for errors codes
	 * 
	 * @var String[]
	 * @static
	 */
	private static $exceptions_description = Array(
		self::UNDEFINED_ESPALDA_EXCEPTION => 'Undefined espalda exception',
		self::NOT_ESPALDA_REPLACE => 'It\'s not a estapalda replace',
		self::NOT_ESPALDA_DISPLAY => 'It\'s not a estapalda display',
		self::NOT_ESPALDA_LOOP => 'It\'s not a estapalda loop',
		self::REPLACE_NOT_EXISTS => 'Replace not exists',
		self::DISPLAY_NOT_EXISTS => 'Display not exists',
		self::LOOP_NOT_EXISTS => 'Loop not exists',
		self::TYPE_NOT_FOUND => 'Propertie type not found',
		self::NAME_NOT_FOUND => 'Propertie name not found',
		self::INVALID_TYPE => 'Invalid value of propertie type',
		self::SINTAXE_ERROR => 'Source has a espalda sintaxe error',
		self::PARSER_ERROR => 'Parser error =/. please oppen issue on github : github.com/guilhermemar/Espalda-PHP',
		self::LOAD_FILE_ERROR => 'Could not load file'
	);

	/**
	 * Construction
	 * 
	 * @param Integer $code Error code
	 */
	public function __construct ($code)
	{
		parent::__construct($this->getRespectiveDescription($code), $code);
	}

	/**
	 * Get a Error code description
	 * 
	 * @param Integer $code Error code
	 * @return string
	 */
	private function getRespectiveDescription ($code)
	{
		if (array_key_exists($code, self::$exceptions_description)) {
			return self::$exceptions_description[$code];
		}  else {
			return self::$exceptions_description[self::UNDEFINED_ESPALDA_EXCEPTION];
		}
	}
}