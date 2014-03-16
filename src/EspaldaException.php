<?php
/**
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
	const NOT_ESPALDA_REGION  = 4;
	const REPLACE_NOT_EXISTS  = 5;
	const DISPLAY_NOT_EXISTS  = 6;
	const REGION_NOT_EXISTS   = 7;

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
		self::NOT_ESPALDA_REGION  => 'It\'s not a estapalda region',
		self::REPLACE_NOT_EXISTS  => 'Replace not exists',
		self::DISPLAY_NOT_EXISTS  => 'Display not exists',
		self::REGION_NOT_EXISTS   => 'Region not exists'
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