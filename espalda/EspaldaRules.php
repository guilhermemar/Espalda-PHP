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

/* 
 * Author : Guilherme Mar
 */

class EspaldaRules
{
	static $oldRegion    = "/\[#([A-Z]([A-Z1-9_-])*)#(([ \t\r\n\v\f]|.)*?)#]/";
	static $oldReplace   = "/#([A-Z]([A-Z1-9_-])*)#/";
	
	static $region       = "/<(espalda|ESPALDA)(( |\n)*([ \t\r\v\f]|.)*type=\"?(region|REGION)\"?([ \t\r\v\f]|.)*)>(([ \t\r\n\v\f]|.)*?)<\/(espalda|ESPALDA)>/";
	static $replace      = "/<(espalda|ESPALDA)(( |\n)*([ \t\r\v\f]|.)*type=\"?(replace|REPLACE)\"?([ \t\r\v\f]|.)*?)\/>/";
	
	static $firstTag     = "/(<(espalda|ESPALDA)(( |\n)*([ \t\r\v\f]|.)*?)>)/";
	static $endTag       = "/(<( |\n)*\/( |\n)*(espalda|ESPALDA)( |\n)*>)/";
	static $lastEndTag   = "/(<( |\n)*\/( |\n)*(espalda|ESPALDA)( |\n)*>)$/";
	
	static $getName      = "/(name|NAME)=\"? ?([a-zA-z][a-zA-Z1-9_-]*)\"?/";
	static $getValue     = "/(value|VALUE)=\"([ a-zA-Z1-9_-]*)\"/";
	static $getType      = "/(type|TYPE)=\"? ?([a-zA-z][a-zA-Z1-9_-]*)\"?/";
	
	private function __construct(){}
}
?>