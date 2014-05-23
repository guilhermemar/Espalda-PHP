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
 * Represents and manipulates a EspaldaReplace element
 * 
 * @author Mar, Guilherme <guilhermemar.dev@gmail.com>
 * @licence GNU General Public License, version 3
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