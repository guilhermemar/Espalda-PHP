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
 * All rules of library
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * 
 * TODO validar permissões e a possível possibilidade de ser extendível
 */
abstract class EspaldaRules
{
	/**
	 * REGEX for old tags of 'region' type
	 * @var string
	 * @static
	 */
	static $oldRegion    = "/\[#([A-Z]([A-Z1-9_-])*)#(([ \t\r\n\v\f]|.)*?)#]/";
	/**
	 * REGEX for old tags of 'replace' type
	 * @var string
	 * @static
	 */
	static $oldReplace   = "/#([A-Z]([A-Z1-9_-])*)#/";
	/**
	 * REGEX for 'regions' type tags
	 * @var string
	 * @static
	 * 
	 * TODO Remove this var
	 */
	static $region       = "/<(espalda|ESPALDA)(( |\n)*([ \t\r\v\f]|.)*type=\"?(region|REGION)\"?([ \t\r\v\f]|.)*)>(([ \t\r\n\v\f]|.)*?)<\/(espalda|ESPALDA)>/";
	/**
	 * REGEX for 'replace' type tags
	 * @var string
	 * @static
	 *
	 *TODO Remove this var
	 */
	static $replace      = "/<(espalda|ESPALDA)(( |\n)*([ \t\r\v\f]|.)*type=\"?(replace|REPLACE)\"?([ \t\r\v\f]|.)*?)\/>/";
	/**
	 * 
	 * @var unknown
	 */
	static $firstTag     = "/(<(espalda|ESPALDA)(( |\n)*([ \t\r\v\f]|.)*?)>)/";
	static $endTag       = "/(<( |\n)*\/( |\n)*(espalda|ESPALDA)( |\n)*>)/";
	static $lastEndTag   = "/(<( |\n)*\/( |\n)*(espalda|ESPALDA)( |\n)*>)$/";
	
	/**
	 * REGEX to get the property 'name' of tag
	 * @var string
	 * @static
	 */
	static $getName      = "/(name|NAME)=\"? ?([a-zA-z][a-zA-Z1-9_-]*)\"?/";
	/**
	 * REGEX to get the property 'value' of tag
	 * @var string
	 * @static
	 */
	static $getValue     = "/(value|VALUE)=\"([ a-zA-Z1-9_-]*)\"/";
	/**
	 * REGEX to get the property 'type' of tag
	 * @var string
	 * @static
	 */
	static $getType      = "/(type|TYPE)=\"? ?([a-zA-z][a-zA-Z1-9_-]*)\"?/";
	
	
}
?>