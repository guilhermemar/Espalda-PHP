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

namespace Espalda;

/**
 * All rules of library
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @licence GNU General Public License, version 3
 */
abstract class EspaldaRules
{
	/**
	 * Search for espalda replace inline tags
	 * @var regex
	 */
	protected $regex_inlineReplace = '/\[(?<tag>espalda)(:(?<type>replace))?( |\n)*\(( |\n)*(?<name>[a-zA-Z][a-zA-Z1-9_-]*)(:(?<value>.*?))?( |\n)*\)\]/i';

	/**
	 * Search for espalda's tags
	 * @var regex
	 */
	protected $regex_espaldaTag = '/<(espalda)((type[[:space:]]*=[[:space:]]*"(?<type>display|replace|loop)")|(name[[:space:]]*=[[:space:]]*"(?<name>[a-z][a-z0-9_-]*)")|(value[[:space:]]*=[[:space:]]*"(?<value>[a-z0-9_-]*)")|[ \t\r\n\v\f])*>/i';

	/**
	 * Search for espalda's tags (begin and end)
	 * @var regex
	 */
	protected $regex_internalEstaldaTag = '/<(?<begin>espalda)([ \t\r\n\v\f]|.)*?type[[:space:]]*=[[:space:]]*"(?<type>([ a-z0-9_-])+)"([ \t\r\n\v\f]|.)*?>|<(?<end>\/espalda)[ \t\r\n\v\f]*>/i';
}
?>
