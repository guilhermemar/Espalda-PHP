<?php

/*
 * This file is part of Espalda.
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
 * Copyright 2010 Guilherme Mar
 */

/* 
 * Author : Guilherme Mar
 */
class EspaldaLine
{
	private $replaces;
	private $displays;
	private $regions;
	
	public function __construct()
	{
		$this->replaces = Array();
		$this->displays = Array();
		$this->regions  = Array();
	}
	
	public function addReplace($replace){
		if($replace instanceof EspaldaReplace){
			$this->replaces[$replace->getName()] = clone $replace;
			return true;
		}else{
			return false;
		}
	}
	
	public function addDisplay($display){
		if($display instanceof EspaldaDisplay){
			$this->displays[$display->getName()] = clone $display;
			return true;
		}else{
			return false;
		}
	}
	
	public function addRegion($region){
		if($region instanceof EspaldaRegion){
			$this->regions[$region->getName()] = clone $region;
			return true;
		}else{
			return false;
		}
	}
	
	public function setReplace($name, $value)
	{
		if(!array_key_exists($name, $this->replaces)){
			$this->replaces[$name] = new EspaldaReplace($name, "");
		}

		$this->replaces[$name]->setValue($value);
		return true;
	}

	public function getReplace($name)
	{
		if(array_key_exists($name, $this->replaces)){
			return $this->replaces[$name]->getValue();
		}else{
			return false;
		}
	}
	
	public function getDisplay($name, $clone = false)
	{
		if(!array_key_exists($name, $this->displays)){
			$this->displays[$name] = new EspaldaDisplay($name, "");
		}
		
		if($clone){
			return clone $this->displays[$name];
		}else{
			return $this->displays[$name];
		}
	}
	
	public function getRegion($name, $clone = false)
	{
		if(!array_key_exists($name, $this->regions)){
			$this->regions[$name] = new EspaldaRegion($name, "");
		}
		
		if($clone){
			return clone $this->regions[$name];
		}else{
			return $this->regions[$name];
		}
	}
		
}
?>