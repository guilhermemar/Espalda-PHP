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

	/*
	 * busca tag espalda de inicio e fim
	 */
	protected $regex_internalEstaldaTag = '/<(?<begin>espalda)([ \t\r\n\v\f]|.)*?type[ ]*=[ ]*"(?<type>([ a-z0-9_-])+)"([ \t\r\n\v\f]|.)*?>|<(?<end>\/espalda)[ \t\r\n\v\f]*>/i';
}
?>