<?php
/**
 * DONE
 * Represents and manipulates a EspaldaDisplay element
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
class EspaldaDisplay extends EspaldaParser
{
	/**
	 * Element name
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * Element value
	 * 
	 * @var boolean
	 */
	private $value = true;
	
	/**
	 * Construct
	 * 
	 * @param string $name EspaldaDisplay name
	 * @param [optional] string $source EspaldaDisplay scope
	 * @param [optional] bool $value EspaldaDisplay value
	 */
	public function __construct ($name, $source = null, $value = null)
	{
		parent::__construct($source);
		
		$this->name = $name;
		
		if ($value !== null) {
			$this->setValue($value);
		}
	}
	
	/**
	 * Set the EspaldaDisplay element name
	 * 
	 * @param string $name element name
	 */
	public function setName ($name)
	{
		$this->name = $name;
	}
	
	/**
	 * Get the EspaldaDisplay name
	 * 
	 * @return string Name of element
	 */
	public function getName ()
	{
		return $this->name;
	}
	
	/**
	 * Set the EspaldaDisplay value
	 * 
	 * @param boolean $value element value
	 */
	public function setValue ($value)
	{
		$this->value = $value ? true : false;

	}
	
	/**
	 * Get the EspalaDisplay value
	 * 
	 * @return boolean value of element
	 */
	public function getValue ()
	{
		return $this->value;
	}
	
	/**
	 * @see EspaldaScope::replaceExists($name)
	 */
	public function replaceExists ($name)
	{
		return $this->scope->replaceExists($name);
	}
	
	/**
	 * @see EspaldaScope::displayExists
	 */
	public function displayExists ($name)
	{
		return $this->scope->displayExists($name);
	}
	
	/**
	 * @see EspaldaScope::loopExists
	 */
	public function loopExists ($name)
	{
		return $this->scope->loopExists($name);
	}
	
	/**
	 * @see EspaldaScope::setReplaceValue($name, $value)
	 */
	public function setReplaceValue ($name, $value)
	{
		$this->scope->setReplaceValue($name, $value);
	
		return $this;
	}
	
	/**
	 * @see EspaldaScope::getReplace($name, $clone)
	 */
	public function getReplace ($name, $clone = false)
	{
		return $this->scope->getReplace($name, $clone);
	}
	
	/**
	 * @see EspaldaScope::setDisplayValue($name, $value)
	 */
	public function setDisplayValue ($name, $value)
	{
		$this->scope->setDisplayValue($name, $value);
	
		return $this;
	}
	
	/**
	 * @see EspaldaScope::getDisplay($name, $clone)
	 */
	public function getDisplay ($name, $clone = false)
	{
		return $this->scope->getDisplay($name, $clone);
	}
	
	/**
	 * @see EspaldaScope::getLoop($name,, $clone);
	 */
	public function getLoop ($name, $clone = false)
	{
		return $this->scope->getLoop($name, $clone);
	}
	
	/**
	 * Parse EspaldaDisplay scope with values of this class and return result
	 * 
	 * @return string parsed template
	 */
	public function getOutput ()
	{
		if ($this->value) {
			
			$output = $this->source;
			
			$replaces = $this->scope->getAllReplaces();
			$keys = array_keys($replaces);
			for ($i=0; $i < count($keys); $i++) {
				$output = str_replace("espalda:replace:{$keys[$i]}", $replaces[$keys[$i]]->getOutput(), $output);
			}
			
			$displays = $this->scope->getAllDisplays();
			$keys = array_keys($displays);
			for ($i=0; $i < count($keys); $i++) {
				$output = str_replace("espalda:display:{$keys[$i]}", $displays[$keys[$i]]->getOutput(), $output);
			}
	
			$loops = $this->scope->getAllLoops();
			$keys = array_keys($loops);
			for ($i=0; $i < count($keys); $i++) {
				$output = str_replace("espalda:loop:{$keys[$i]}", $loops[$keys[$i]]->getOutput(), $output);
			}
			
			return $output;
			
		} else {
			
			return "";
			
		}
	}
	
	/**
	 * Create a EspaldaDisplay with values equals the this class
	 * 
	 * @return EspaldaDisplay
	 */
	public function getClone ()
	{
		$cloned = new EspaldaDisplay($this->name);
		$cloned->value = $this->value;
		$cloned->originalSource = $this->originalSource;
		$cloned->source = $this->source;
		$cloned->scope = clone $this->scope;
		
		return $cloned;
	}
}
?>