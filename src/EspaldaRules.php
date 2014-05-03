<?php
/**
 * All rules of library
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
abstract class EspaldaRules
{
	/**
	 * busca replace inline
	 * @var regex
	 */
	protected $regex_inlineReplace   = '/\[(?<tag>espalda)(:(?<type>replace))?( |\n)*\(( |\n)*(?<name>[a-zA-Z][a-zA-Z1-9_-]*)(:(?<value>.*?))?( |\n)*\)\]/i';
	
	
	/**
	 * busca uma tag espalda
	 */
	protected $regex_espaldaTag = '/<(espalda)((type[ ]*=[ ]*"(?<type>display|replace|loop)")|(name[ ]*=[ ]*"(?<name>[a-z][a-z0-9_-]*)")|(value[ ]*=[ ]*"(?<value>[a-z0-9_-]*)")|[ \t\r\n\v\f])*>/i';
	
	
	
	protected $regex_internalEstaldaTag = '/<(?<begin>espalda)([ \t\r\n\v\f]|.)*?type[ ]*=[ ]*"(?<type>([ a-z0-9_-])+)"([ \t\r\n\v\f]|.)*?>|<(?<end>\/espalda)[ \t\r\n\v\f]*>/i';
	
	
	
	/**
	 * REGEX for old tags of 'region' type
	 * @var string
	 * @static
	 */
	static $oldLoop    = "/\[#([A-Z]([A-Z1-9_-])*)#(([ \t\r\n\v\f]|.)*?)#]/";
	
	/**
	 * REGEX for old tags of 'replace' type
	 * @var string
	 * @static
	 */
	//protected $regex_inlineReplace   = "/#([A-Z]([A-Z1-9_-])*)#/";
	/**
	 * REGEX for 'regions' type tags
	 * @var string
	 * @static
	 * 
	 * TODO Remove this var
	 */
	//static $region       = "/<(espalda|ESPALDA)(( |\n)*([ \t\r\v\f]|.)*type=\"?(region|REGION)\"?([ \t\r\v\f]|.)*)>(([ \t\r\n\v\f]|.)*?)<\/(espalda|ESPALDA)>/";
	
	/**
	 * REGEX for 'replace' type tags
	 * @var string
	 * @static
	 *
	 *TODO Remove this var
	 */
	//static $replace      = "/<(espalda|ESPALDA)(( |\n)*([ \t\r\v\f]|.)*type=\"?(replace|REPLACE)\"?([ \t\r\v\f]|.)*?)\/>/";
	
	/**
	 * REGEX to search the start of espalda tag
	 * @var string
	 * @static
	 */
	static $firstTag     = "/(<(espalda|ESPALDA)(( |\n)*([ \t\r\v\f]|.)*?)>)/";
	
	/**
	 * REGEX to search the end of espalda tag
	 * @var string
	 * @static
	 */
	static $endTag       = "/(<( |\n)*\/( |\n)*(espalda|ESPALDA)( |\n)*>)/";
	
	/**
	 * REGEX to search the end of espalda tag for tags with scope
	 * @var string
	 * @static
	 */
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