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
require_once "EspaldaLine.php";

class EspaldaRegion extends EspaldaEngine
{
	private $linhas;
	private $name;
		
	public function __construct($name, $source = false)
	{
		parent::__construct();
		
		$this->name = $name;
		
		if($source){
			$this->setSource($source);
		}
		
		$this->linhas = Array();
		
	}
	
	public function moreLine()
	{
		$this->linhas[] = new EspaldaLine();
		
		$line = count($this->linhas)-1;
		
		$keys = array_keys($this->replaces);
		for($i=0; $i < count($keys); $i++){
			$this->linhas[$line]->addReplace(clone $this->replaces[$keys[$i]]);
		}
		
		$keys = array_keys($this->displays);
		for($i=0; $i < count($keys); $i++){
			$this->linhas[$line]->addDisplay(clone $this->displays[$keys[$i]]);
		}
		
		$keys = array_keys($this->regions);
		for($i=0; $i < count($keys); $i++){
			$this->linhas[$line]->addRegion(clone $this->regions[$keys[$i]]);
		}
	}
	
	public function setName($name){
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}
	
	public function setReplace($name, $value)
	{
		if(count($this->linhas) == 0){
			$this->moreLine();
		}
		
		$line = count($this->linhas)-1;
		
		$this->linhas[$line]->setReplace($name, $value);
	}

	public function getReplace($name)
	{
		if(count($this->linhas) == 0){
			$this->moreLine();
		}
		
		$line = count($this->linhas)-1;
		
		return $this->linhas[$line]->getReplace($name);
	}
	
	public function getDisplay($name, $clone=false)
	{
		if(count($this->linhas) == 0){
			$this->moreLine();
		}
		
		$line = count($this->linhas)-1;
		
		return $this->linhas[$line]->getDisplay($name, $clone);
	}
	
	public function getRegion($name, $clone=false)
	{
		if(count($this->linhas) == 0){
			$this->moreLine();
		}
		
		$line = count($this->linhas)-1;
		
		return $this->linhas[$line]->getRegion($name, $clone);
	}
	
	public function getSource()
	{
		$nsf = "";
			
		for($j=0; $j < count($this->linhas); $j++){	
			$ns = $this->source;
			
			$keys = array_keys($this->replaces);
			for($i=0; $i < count($keys); $i++){
				$ns = str_replace("replace_{$keys[$i]}_replace", $this->linhas[$j]->getReplace($keys[$i]), $ns);
			}
			
			$keys = array_keys($this->displays);
			for($i=0; $i < count($keys); $i++){
				if($this->linhas[$i]->getDisplay($keys[$i])->getValue()){
					$display = $this->linhas[$j]->getDisplay($keys[$i])->getSource();
				}else{
					$display = "";
				}
				$ns = str_replace("display_{$keys[$i]}_display", $display, $ns);
			}
			
			$keys = array_keys($this->regions);
			for($i=0; $i < count($keys); $i++){
				$ns = str_replace("region_{$keys[$i]}_region", $this->linhas[$j]->getRegion($keys[$i])->getSource(), $ns);
			}
		
			$nsf .= $ns;
		}
		
		return $nsf;
	}
}
?>