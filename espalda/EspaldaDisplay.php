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

require_once "EspaldaEngine.php";

class EspaldaDisplay extends EspaldaEngine
{
	private $name;
	private $value;
	
	public function __construct($name, $source = false)
	{
		
		parent::__construct();
		$this->name = $name;
		
		if($source){
			$this->setSource($source);
		}
		
	}
	
	public function setName($name){
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}
	
	public function setValue($value)
	{
		$this->value = $value;
	}
	
	public function getValue()
	{
		return $this->value;
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
			return $this->replaces[$name]->getValue($value);
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
	
	public function getSource()
	{

		$ns = $this->source;
		
		$keys = array_keys($this->replaces);
		for($i=0; $i < count($keys); $i++){
			$ns = str_replace("replace_{$keys[$i]}_replace", $this->replaces[$keys[$i]]->getValue(), $ns);
		}
		
		$keys = array_keys($this->displays);
		for($i=0; $i < count($keys); $i++){
			if($this->displays[$keys[$i]]->getValue()){
				$display = $this->displays[$keys[$i]]->getSource();
			}else{
				$display = "";
			}
			$ns = str_replace("display_{$keys[$i]}_display", $display, $ns);
		}
		
		$keys = array_keys($this->regions);
		for($i=0; $i < count($keys); $i++){
			$ns = str_replace("region_{$keys[$i]}_region", $this->regions[$keys[$i]]->getSource(), $ns);
		}
		
		return $ns;

	}
}
?>