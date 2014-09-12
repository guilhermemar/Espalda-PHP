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
 * Represents and manipulates a EspaldaDisplay element
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @licence GNU General Public License, version 3
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
	 * @param string $source [optional]  EspaldaDisplay scope
	 * @param bool $value [optional] EspaldaDisplay value
	 */
	public function __construct ($name, $source = null, $value = null)
	{
		parent::__construct($source);
		
		$this->setName($name);
		
		if (!is_null($value)) {
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
	 * Check if EspaldaReplace exists
	 * 
	 * @param string $name Name of EspaldaReplace for check
	 * @return boolean
	 */
	public function replaceExists ($name)
	{
		return $this->scope->replaceExists($name);
	}
	
	/**
	 * Check if EspaldaDisplay exists
	 *
	 * @param string $name Name of EspaldaDisplay for check
	 * @return boolean
	 */
	public function displayExists ($name)
	{
		return $this->scope->displayExists($name);
	}
	
	/**
	 * Check if EspaldaLoop exists
	 *
	 * @param string $name Name of EspaldaLoop to check
	 * @return boolean
	 */
	public function loopExists ($name)
	{
		return $this->scope->loopExists($name);
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
		$this->scope->setReplaceValue($name, $value);
	
		return $this;
	}
	
	/**
	 * Returns the EspaldaReplace requested
	 *
	 * @param string $name Name of EspaldaReplace
	 * @param boolean $clone [optional] 'true' return a clone of element, 'false' return a pointer. Default false
	 * @throws EspaldaException If the solicited EspaldaReplace not exist
	 * @return EspaldaReplace
	 */
	public function getReplace ($name, $clone = false)
	{
		return $this->scope->getReplace($name, $clone);
	}
	
	/**
	 * Set value of value property of a EspaldaDisplay
	 *
	 * @param string $name Name of EspaldaDisplay
	 * @param boolean $value New value for value property
	 * @throws EspaldaException if solicited EspaldaLoop not to exist
	 * @return $this
	 */
	public function setDisplayValue ($name, $value)
	{
		$this->scope->setDisplayValue($name, $value);
	
		return $this;
	}
	
	/**
	 * Return the EspaldaDisplay requested
	 *
	 * @param string $name Name of EspaldaReplace
	 * @param  boolean $clone [optional] 'true' return a clone of element, 'false' return a pointer. Default false
	 * @throws EspaldaException If the solicited EspaldaReplace not to exist
	 * @return EspaldaDisplay
	 */
	public function getDisplay ($name, $clone = false)
	{
		return $this->scope->getDisplay($name, $clone);
	}
	
	/**
	 * Return the EspaldaLoop requested
	 * 
	 * @param string $name Name of EspaldaLoop
	 * @param boolean $clone [optional] 'true' return a clone of element, 'false' return a pointer. Default false
	 * @throws EspaldaException If the solicited EspaldaLoop not to exist
	 * @return EspaldaLoop
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