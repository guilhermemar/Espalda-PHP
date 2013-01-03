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
 */
class EspaldaEscope
{
	/**
	 * All replaces of escope
	 * @var EspaldaReplace[]
	 */
	protected $replaces;
	/**
	 * All displays of escope
	 * @var EspaldaDisplay[]
	 */
	protected $displays;
	/**
	 * All regions of escope
	 * @var EspaldaRegion[]
	 */
	protected $regions;
	/**
	 * Construtora da classe
	 */
	public function __construct()
	{
		$this->replaces = Array();
		$this->displays = Array();
		$this->regions  = Array();
	}
	/**
	 * Verifica se o replace solicitada existe no escopo
	 * @param string $name Name da replace solicitada
	 * @return boolean
	 */
	public function replaceExists ($name)
	{
		return array_key_exists($name, $this->replaces) ? true : false;
	}
	/**
	 * Verifica se o display solicitada existe no escopo
	 * @param string $name Name da display solicitada
	 * @return boolean
	 */
	public function displayExists ($name)
	{
		return array_key_exists($name, $this->replaces) ? true : false;
	}
	/**
	 * Verifica se a region solicitada existe no escopo
	 * @param string $name Name da region solicitada
	 * @return boolean
	 */
	public function regionExists ($name)
	{
		return array_key_exists($name, $this->regions) ? true : false;
	}
	/**
	 * Adiciona uma instância de replace na lista de replaces
	 *
	 * @param EspaldaReplace $replace
	 * @return boolean
	 */
	public function addReplace($replace){
		if($replace instanceof EspaldaReplace){
			$this->replaces[$replace->getName()] = $replace;
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Adiciona uma instância de display na lista de displays
	 *
	 * @param EspaldaDisplay $replace
	 * @return boolean
	 */
	public function addDisplay($display){
		if($display instanceof EspaldaDisplay){
			$this->displays[$display->getName()] = $display;
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Adiciona uma instância de region na lista de regions
	 *
	 * @param EspaldaRegion $replace
	 * @return boolean
	 */
	public function addRegion($region){
		if($region instanceof EspaldaRegion){
			$this->regions[$region->getName()] = $region;
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Informa o valor para a propriedade "value" de uma marcação "replace"
	 * @param string $name Nome da marcação
	 * @param string $value Valor para a marcação
	 * @return boolean Retorna sempre true
	 * 
	 * TODO corrigir o retorno
	 * TODO Criar setDisplayValue
	 * TODO Criar setRegionValue com trigger_error("aviso de que não existe isso para region", E_USER_WARNING)
	 */
	public function setReplaceValue($name, $value)
	{
		if(!$this->replaceExists($name)){
			$this->addReplace(new EspaldaReplace($name, ""));
		}

		$this->replaces[$name]->setValue($value);
		return true;
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
			$this->displays[$name] = new EspaldaReplace($name, "");
		}
		
		if($clone){
			return clone $this->replaces[$name];
		}else{
			return $this->replaces[$name];
		}
	}
	/*
	 * TODO Estudar a viabilidade de criar um setDisplay para setar o seu value.
	 */
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
			$this->displays[$name] = new EspaldaDisplay($name, "");
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