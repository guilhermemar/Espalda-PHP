<?php
/**
 * Represents and manipulates a EspaldaDisplay element
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
class EspaldaDisplay extends EspaldaEngine
{
	/**
	 * Element name
	 * @var string
	 */
	private $name;
	
	/**
	 * Element value
	 * @var string
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
		$this->name = $name;
		
		if ($source !== null){
			$this->setSource($source);
		}
		
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
	 * Parse EspaldaDisplay scope with values of this class and return result
	 * 
	 * @return string parsed template
	 */
	public function getOutput ()
	{
		$ns = $this->source;
		
		$keys = array_keys($this->replaces);
		for ($i=0; $i < count($keys); $i++) {
			$ns = str_replace("replace_{$keys[$i]}_replace", $this->replaces[$keys[$i]]->getOutput(), $ns);
		}
		
		$keys = array_keys($this->displays);
		for ($i=0; $i < count($keys); $i++) {
			if($this->displays[$keys[$i]]->getValue()){
				$display = $this->displays[$keys[$i]]->getOutput();
			}else{
				$display = "";
			}
			$ns = str_replace("display_{$keys[$i]}_display", $display, $ns);
		}
		
		$keys = array_keys($this->loops);
		for ($i=0; $i < count($keys); $i++) {
			$ns = str_replace("loop_{$keys[$i]}_loop", $this->loops[$keys[$i]]->getOutput(), $ns);
		}
		
		return $ns;
	}
	
	//TODO implements __clone
}
?>