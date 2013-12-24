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

/**
 * Manipula informações de um escopo
 * 
 * Um escopo consiste no conteúdo de uma marcação espalda que possua escopo, ou seja, o conteúdo que está entre uma tag de inicio ( <espalda> ) e fim ( </espalda> )
 * Nesta classe conterá os elementos encontrados dentro deste escopo, e seus métodos para manipulação, não contém controle do conteúdo original do template.
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * 
 * TODO Resolver problema do getDisplay()->setReplaceValue() que todos os replaces ficam com o valor do ultimo
 */
class EspaldaEscope
{
	/**
	 * All replaces of escope
	 * @var EspaldaReplace[]
	 */
	protected $replaces = Array();
	/**
	 * All displays of escope
	 * @var EspaldaDisplay[]
	 */
	protected $displays = Array();
	/**
	 * All regions of escope
	 * @var EspaldaRegion[]
	 */
	protected $regions = Array();
	/**
	 * Verifica se o replace solicitada existe no escopo
	 * @param string $name Name da replace solicitada
	 * @return boolean
	 * 
	 * TODO - add to documentation
	 */
	public function replaceExists ($name)
	{
		return array_key_exists($name, $this->replaces) ? true : false;
	}
	/**
	 * Verifica se o display solicitada existe no escopo
	 * @param string $name Name da display solicitada
	 * @return boolean
	 * 
	 * TODO - add to documentation
	 */
	public function displayExists ($name)
	{
		return array_key_exists($name, $this->replaces) ? true : false;
	}
	/**
	 * Verifica se a region solicitada existe no escopo
	 * @param string $name Name da region solicitada
	 * @return boolean
	 * 
	 * TODO - add to documentation
	 */
	public function regionExists ($name)
	{
		return array_key_exists($name, $this->regions) ? true : false;
	}
	/**
	 * Adiciona uma instância de replace na lista de replaces
	 *
	 * @param EspaldaReplace $replace
	 * @throws EspaldaException if parameter is not a instance of EspaldaReplace
	 * @return $this 
	 * 
	 * TODO - add to documentation
	 */
	public function addReplace($replace){
		if(!$replace instanceof EspaldaReplace){
			throw new EspaldaException(EspaldaException::NOT_ESPALDA_REPLACE);
		}	
		
		$this->replaces[$replace->getName()] = clone $replace;
		
		return $this;
	}
	/**
	 * Adiciona uma instância de display na lista de displays
	 *
	 * @param EspaldaDisplay $replace
	 * @throws EspaldaException if parameter is not a instance of EspaldaDisplay
	 * @return $this 
	 * 
	 * TODO - add to documentation
	 */
	public function addDisplay($display){
		if(!$display instanceof EspaldaDisplay){
			throw new EspaldaException(EspaldaException::NOT_ESPALDA_DISPLAY);
		}
		
		$this->displays[$display->getName()] = clone $display;
		
		return $this;
	}
	/**
	 * Adiciona uma instância de region na lista de regions
	 *
	 * @param EspaldaRegion $region
	 * @throws EspaldaException if parameter is not a instance of EspaldaRegion
	 * @return $this 
	 * 
	 * TODO - add to documentation
	 */
	public function addRegion($region){
		if(!$region instanceof EspaldaRegion){
			throw new EspaldaException(EspaldaException::NOT_ESPALDA_REGION);
		}
		
		$this->regions[$region->getName()] = $region;
		
		return $this;
	}
	/**
	 * Informa o valor para a propriedade "value" de uma marcação "replace"
	 * @param string $name Nome da marcação
	 * @param string $value Valor para a marcação
	 * @throws EspaldaException if solicited 'replace' not exists
	 * @return $this
	 * 
	 * TODO - add to documentation
	 */
	public function setReplaceValue($name, $value)
	{	
		if(!$this->replaceExists($name)){
			throw new EspaldaException(EspaldaException::REPLACE_NOT_EXISTS);
		}

		$this->replaces[$name]->setValue($value);
		
		return $this;
	}
	/**
	 * 
	 * @param string $name Nome da marcação
	 * @param string $value Valor para a marcação
	 * @throws EspaldaException if solicited 'region' not exists
	 * @return $this
	 * 
	 * TODO - add to documentation
	 */
	public function setDisplayValue($name, $value)
	{
		if(!$this->displayExists($name)){
			throw new EspaldaException(EspaldaException::DISPLAY_NOT_EXISTS);
		}
	
		$this->displays[$name]->setValue($value);
	
		return $this;
	}
	/**
	 * This method only will go generate a warning
	 */
	public function setRegionValue($name, $value)
	{
		trigger_error("Tag 'region' don't have property 'value'", E_USER_WARNING);
	}
	/**
	 * Retorna o conteúdo armazenado para uma tag do tipo replace
	 * @param string $name Nome da marcação
	 * @return string|boolean Conteúdo da marcação ou False em caso de nome inválido da marcação
	 * 
	 * TODO corrigir o erro do $value sendo passado por parâmetro
	 */
	public function getReplace($name, $clone = false)
	{
		if(!array_key_exists($name, $this->replaces)){
			throw new EspaldaException(EspaldaException::REPLACE_NOT_EXISTS);
		}
		
		if($clone){
			return clone $this->replaces[$name];
		}else{
			return $this->replaces[$name];
		}
	}
	/**
	 * Retorna uma instância de espaldaDisplay da marcação solicitada
	 * 
	 * @param string $name Noma da marcação display
	 * @param boolean $clone se deverá ser retornado um clone ou um ponteiro da instância
	 * @return Instância ou clone da instância espaldaDisplay da marcação display solicitada
	 */
	public function getDisplay($name, $clone = false)
	{
		if(!array_key_exists($name, $this->displays)){
			throw new EspaldaException(EspaldaException::DISPLAY_NOT_EXISTS);
		}
		
		if($clone){
			return clone $this->displays[$name];
		}else{
			return $this->displays[$name];
		}
	}
	/**
	 * Retorna uma instância de espaldaRegion da marcação solicitada
	 * 
	 * @param string $name Noma da marcação region
	 * @param boolean $clone se deverá ser retornado um clone ou um ponteiro da instância
	 * @return Instância ou clone da instância espaldaRegion da marcação region solicitada
	 */
	public function getRegion($name, $clone = false)
	{
		if(!$this->regionExists($name)){
			throw new EspaldaException(EspaldaException::REGION_NOT_EXISTS);
		}
		
		if($clone){
			return clone $this->regions[$name];
		}else{
			return $this->regions[$name];
		}
	}
}
?>