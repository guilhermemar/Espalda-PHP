<?php
/**
 * This object storage a link for all espalda elements included in the content of a espalda wrap element with scope
 * 
 * @author Mar, Guilherme
 * 
 */
class EspaldaEscope
{
	/**
	 * Replaces of scope
	 * @var EspaldaReplace[]
	 */
	protected $replaces = Array();
	
	/**
	 * Displays of escope
	 * @var EspaldaDisplay[]
	 */
	protected $displays = Array();
	
	/**
	 * Regions of escope
	 * @var EspaldaRegion[]
	 */
	protected $regions = Array();
	
	/**
	 * Check if EspaldaReplace exists
	 * @param string $name Name of EspaldaReplace for check
	 * @return boolean
	 */
	public function replaceExists ($name)
	{
		return array_key_exists(strtolower($name), $this->replaces) ? true : false;
	}
	
	/**
	 * Check if EspaldaDisplay exists 
	 * @param string $name Name of EspaldaDisplay for check
	 * @return boolean
	 */
	public function displayExists ($name)
	{
		return array_key_exists(strtolower($name), $this->replaces) ? true : false;
	}
	
	/**
	 * Check if EspaldaRegion exists
	 * @param string $name Name of EspaldaRegion to check
	 * @return boolean
	 */
	public function regionExists ($name)
	{
		return array_key_exists(strtolower($name), $this->regions) ? true : false;
	}
	
	/**
	 * Add a instance of EspaldaReplace
	 *
	 * @param EspaldaReplace $replace
	 * @throws EspaldaException if parameter is not a instance of EspaldaReplace
	 * @return $this 
	 */
	public function addReplace ($replace)
	{
		if (!$replace instanceof EspaldaReplace) {
			throw new EspaldaException(EspaldaException::NOT_ESPALDA_REPLACE);
		}	
		
		$this->replaces[strtolower($replace->getName())] = clone $replace;
		
		return $this;
	}
	
	/**
	 * Add a instance of EspaldaDisplay
	 *
	 * @param EspaldaDisplay $display
	 * @throws EspaldaException if parameter is not a instance of EspaldaDisplay
	 * @return $this 
	 */
	public function addDisplay ($display)
	{
		if (!$display instanceof EspaldaDisplay) {
			throw new EspaldaException(EspaldaException::NOT_ESPALDA_DISPLAY);
		}
		
		$this->displays[strtolower($display->getName())] = clone $display;
		
		return $this;
	}
	
	/**
	 * Add a instance of EspaldaRegions
	 *
	 * @param EspaldaRegion $region
	 * @throws EspaldaException if parameter is not a instance of EspaldaRegion
	 * @return $this 
	 */
	public function addRegion ($region)
	{
		if (!$region instanceof EspaldaRegion) {
			throw new EspaldaException(EspaldaException::NOT_ESPALDA_REGION);
		}
		
		$this->regions[strtolower($region->getName())] = $region;
		
		return $this;
	}
	
	/**
	 * Set value of value property of a EspaldaReplace
	 * 
	 * @param string $name Name of EspaldaReplace
	 * @param string $value New value for value property
	 * @throws EspaldaException if the solicited EspaldaReplace not to exist
	 * @return $this
	 */
	public function setReplaceValue ($name, $value)
	{	
		if (!$this->replaceExists($name)) {
			throw new EspaldaException(EspaldaException::REPLACE_NOT_EXISTS);
		}

		$this->replaces[$name]->setValue($value);
		
		return $this;
	}
	
	/**
	 * Set value of value property of a EspaldaDisplay
	 * 
	 * @param string $name Name of EspaldaDisplay
	 * @param boolean $value New value for value property
	 * @throws EspaldaException if solicited EspaldaRegion not to exist
	 * @return $this
	 */
	public function setDisplayValue ($name, $value)
	{
		if (!$this->displayExists($name)) {
			throw new EspaldaException(EspaldaException::DISPLAY_NOT_EXISTS);
		}
	
		$this->displays[$name]->setValue($value);
	
		return $this;
	}
	
	/**
	 * Returns the EspaldaReplace requested
	 * 
	 * @param string $name Name of EspaldaReplace
	 * @param [optional] boolean $clone 'true' return a clone of element, 'false' return a pointer. Default false
	 * @throws If the solicited EspaldaReplace not to exist
	 * @return EspaldaReplace
	 */
	public function getReplace ($name, $clone = false)
	{
		$name = strtolower($name);
		
		if (!$this->replaceExists($name)) {
			throw new EspaldaException(EspaldaException::REPLACE_NOT_EXISTS);
		}
		
		if ($clone) {
			return clone $this->replaces[$name];
		}else{
			return $this->replaces[$name];
		}
	}
	
	/**
	 * Return the EspaldaDisplay requested
	 * 
	 * @param string $name Name of EspaldaReplace
	 * @param [optional] boolean $clone 'true' return a clone of element, 'false' return a pointer. Default false
	 * @throws If the solicited EspaldaReplace not to exist
	 * @return EspaldaDisplay
	 */
	public function getDisplay ($name, $clone = false)
	{
		$name = strtolower($name);
		
		if (!$this->displayExists($name)) {
			throw new EspaldaException(EspaldaException::DISPLAY_NOT_EXISTS);
		}
		
		if ($clone) {
			return clone $this->displays[$name];
		}else{
			return $this->displays[$name];
		}
	}
	
	/**
	 * Return the EspaldaRegion requested
	 * 
	 * @param string $name Name of EspaldaRegion
	 * @param [optional] boolean $clone 'true' return a clone of element, 'false' return a pointer. Default false
	 * @return EspaldaRegion
	 */
	public function getRegion ($name, $clone = false)
	{
		$name = strtolower($name);
		
		if (!$this->regionExists($name)) {
			throw new EspaldaException(EspaldaException::REGION_NOT_EXISTS);
		}
		
		if ($clone) {
			return clone $this->regions[$name];
		}else{
			return $this->regions[$name];
		}
	}
}
?>