<?php
/**
 * This file is part of Espalda project.
 *
 * @author Mar, Guilherme <guilhermemar.dev@gmail.com>
 * @licence GNU General Public License, version 3
 */

/**
 * Represents and manipulates a EspaldaReplace element
 * 
 * @author Mar, Guilherme <guilhermemar.dev@gmail.com>
 */
class EspaldaReplace
{
	/**
	 * Element Name
	 * 
	 * @var string
	 */
	private $name  = "";
	
	/**
	 * Element Value
	 * 
	 * @var string
	 */
	private $value = "";
	
	/**
	 * Construct
	 * 
	 * @param string $name [optional]  EspaldaReplace Name
	 * @param string $value [optional]  EspaldaReplace Value
	 */
	public function __construct ($name, $value = null)
	{
		$this->setName($name);
		
		if(!is_null($value)){
			$this->setValue($value);
		}
	}
	
	/**
	 * Set the EspaldarReplace element name
	 * 
	 * @param string $name Element name
	 */
	public function setName ($name)
	{
		$this->name = $name;
	}
	
	/**
	 * Get the EspaldaReplace element name
	 * 
	 * @return string name of element
	 */
	public function getName ()
	{
		return $this->name;
	}
	
	/**
	 * Set the EspaldaReplace element value
	 * 
	 * @param string $value Element value
	 */
	public function setValue ($value)
	{
		$this->value = $value;
	}
	
	/**
	 * Get the EspaldaReplace element value
	 * 
	 * @return string value of element
	 */
	public function getValue ()
	{
		return $this->value;
	}
	
	/**
	 * Parse template with element values, this case, value of element
	 *
	 * @return string parsed template
	 */
	public function getOutput ()
	{
		return $this->getValue();
	}
	
	/**
	 * Create a new EspalaReplace with values this element
	 * 
	 * @return cloned EspaldaReplace
	 */
	public function getClone ()
	{
		return new EspaldaReplace($this->name, $this->value);
	}
}
?>