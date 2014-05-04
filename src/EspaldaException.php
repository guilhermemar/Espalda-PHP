<?php
/**
 * DONE
 * Exceptions for Espalda project
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
class EspaldaException extends Exception
{
	/**
	 * Errors codes
	 */
	const UNDEFINED_ESPALDA_EXCEPTION = 1;
	const NOT_ESPALDA_REPLACE = 2;
	const NOT_ESPALDA_DISPLAY = 3;
	const NOT_ESPALDA_LOOP  = 4;
	const REPLACE_NOT_EXISTS  = 5;
	const DISPLAY_NOT_EXISTS  = 6;
	const LOOP_NOT_EXISTS   = 7;
	const TYPE_NOT_FOUND = 8;
	const NAME_NOT_FOUND = 9;
	const INVALID_TYPE = 10;
	const SINTAXE_ERROR = 11;
	const PARSER_ERROR = 12;
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
		self::NOT_ESPALDA_LOOP => 'It\'s not a estapalda region',
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