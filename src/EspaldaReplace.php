<?php
/**
 * DONE
 * Represents and manipulates a EspaldaReplace element
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
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
	 * @param [optional] string $name EspaldaReplace Name
	 * @param [optional] string $value EspaldaReplace Value
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
	public function __clone ()
	{
		return new EspaldaReplace($this->name, $this->value);
	}
}
?>