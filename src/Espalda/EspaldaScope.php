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
 * This object storage a link for all espalda elements included in the content of a espalda wrap element with scope
 *
 * @author Mar, Guilherme <guilhermemar.dev@gmail.com>
 * @licence GNU General Public License, version 3
 */
class EspaldaScope
{
	/**
	 * Replaces of scope
	 * 
	 * @var EspaldaReplace[]
	 */
	private $replaces = Array();
	
	/**
	 * Displays of escope
	 * 
	 * @var EspaldaDisplay[]
	 */
	private $displays = Array();
	
	/**
	 * Loops of escope
	 * 
	 * @var EspaldaLoop[]
	 */
	private $loops = Array();
	
	/**
	 * Check if EspaldaReplace exists
	 * 
	 * @param string $name Name of EspaldaReplace for check
	 * @return boolean
	 */
	public function replaceExists ($name)
	{
		return array_key_exists(strtolower($name), $this->replaces) ? true : false;
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
	
		$this->replaces[strtolower($name)]->setValue($value);
	
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
	 * Returns all EspaldaReplace
	 * 
	 * @return EspaldaReplace[]
	 */
	public function getAllReplaces () 
	{
		return $this->replaces;
	}
	
	/**
	 * Check if EspaldaDisplay exists
	 *
	 * @param string $name Name of EspaldaDisplay for check
	 * @return boolean
	 */
	public function displayExists ($name)
	{
		return array_key_exists(strtolower($name), $this->displays) ? true : false;
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
	 * Set value of value property of a EspaldaDisplay
	 *
	 * @param string $name Name of EspaldaDisplay
	 * @param boolean $value New value for value property
	 * @throws EspaldaException if solicited EspaldaLoop not to exist
	 * @return $this
	 */
	public function setDisplayValue ($name, $value)
	{
		if (!$this->displayExists($name)) {
			throw new EspaldaException(EspaldaException::DISPLAY_NOT_EXISTS);
		}
	
		$this->displays[strtolower($name)]->setValue($value);
	
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
	 * Returns all EspaldaDisplay
	 *
	 * @return EspaldaDisplay[]
	 */
	public function getAllDisplays () 
	{
		return $this->displays;
	}
	
	/**
	 * Check if EspaldaLoop exists
	 *
	 * @param string $name Name of EspaldaLoop to check
	 * @return boolean
	 */
	public function loopExists ($name)
	{
		return array_key_exists(strtolower($name), $this->loops) ? true : false;
	}
	
	/**
	 * Add a instance of EspaldaLoops
	 *
	 * @param EspaldaLoop $loop
	 * @throws EspaldaException if parameter is not a instance of EspaldaLoop
	 * @return $this 
	 */
	public function addLoop ($loop)
	{
		if (!$loop instanceof EspaldaLoop) {
			throw new EspaldaException(EspaldaException::NOT_ESPALDA_LOOP);
		}
		
		$this->loops[strtolower($loop->getName())] = $loop;
		
		return $this;
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
		$name = strtolower($name);
		
		if (!$this->loopExists($name)) {
			throw new EspaldaException(EspaldaException::LOOP_NOT_EXISTS);
		}
		
		if ($clone) {
			return clone $this->loops[$name];
		}else{
			return $this->loops[$name];
		}
	}
	
	/**
	 * Returns all EspaldaLoop
	 *
	 * @return EspaldaLoop[]
	 */
	public function getAllLoops () 
	{
		return $this->loops;
	}
	
	/**
	 * Clone this class a new object EspaldaScope
	 * 
	 * @return EspaldaScope
	 */
	public function getClone ()
	{	
		$cloneScope = new EspaldaScope();
	
		$k = array_keys($this->replaces);
		$c = count($k);
		for ($i=0; $i<$c; ++$i) {
			$cloneScope->addReplace($this->replaces[$k[$i]]->getClone());
		}
	
		$k = array_keys($this->displays);
		$c = count($k);
		for ($i=0; $i<$c; ++$i) {
			$cloneScope->addDisplay($this->displays[$k[$i]]->getClone());
		}
	
		$k = array_keys($this->loops);
		$c = count($k);
		for ($i=0; $i<$c; ++$i) {
			$cloneScope->addLoop($this->loops[$k[$i]]->getClone());
		}
	
		return $cloneScope;
	}
	
}
?>