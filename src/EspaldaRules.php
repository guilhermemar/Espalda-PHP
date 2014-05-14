<?php
/**
 * This file is part of Espalda project.
 *
 * @author Mar, Guilherme
 * @licence GNU General Public License, version 3
 */

/**
 * All rules of library
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
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
	protected $regex_espaldaTag = '/<(espalda)((type[ ]*=[ ]*"(?<type>display|replace|loop)")|(name[ ]*=[ ]*"(?<name>[a-z][a-z0-9_-]*)")|(value[ ]*=[ ]*"(?<value>[a-z0-9_-]*)")|[ \t\r\n\v\f])*>/i';

	/**
	 * Search for espalda's tags (begin and end)
	 * @var regex
	 */
	protected $regex_internalEstaldaTag = '/<(?<begin>espalda)([ \t\r\n\v\f]|.)*?type[ ]*=[ ]*"(?<type>([ a-z0-9_-])+)"([ \t\r\n\v\f]|.)*?>|<(?<end>\/espalda)[ \t\r\n\v\f]*>/i';
}
?>