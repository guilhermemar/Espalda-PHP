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
 * Manipula marcações do tipo Display
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
class EspaldaDisplay extends EspaldaEngine
{
	/**
	 * Nome da marcação
	 * @var string
	 */
	private $name;
	/**
	 * Conteúdo da marcação
	 * @var string
	 */
	private $value;
	/**
	 * Construtora da classe
	 * 
	 * @param string $name Nome da marcação (propriedade "name" da tag)
	 * @param string $source O escopo da marcação
	 */
	public function __construct($name, $source = false)
	{
		parent::__construct();
		$this->name = $name;
		
		if($source){
			$this->setSource($source);
		}
		
	}
	/**
	 * Seta o name da marcação
	 * 
	 * @param string $name Nome da marcação
	 */
	protected function setName($name){
		$this->name = $name;
	}
	/**
	 * Pega o nome da marcação
	 * @return string Nome da marcação
	 */
	public function getName()
	{
		return $this->name;
	}
	/**
	 * Informa se o conteúdo da marcação "display" deve ser exibida ou não, True para sim, False para não
	 * 
	 * @param boolean $value
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}
	/**
	 * Retorna o valor atual da marcação
	 * @return boolean
	 */
	public function getValue()
	{
		return $this->value;
	}
	/**
	 * Informa o valor para uma marcação "replace"
	 * @param string $name Nome da marcação
	 * @param string $value Valor para a marcação
	 * @return boolean Retorna sempre true
	 * 
	 * TODO corrigir o retorno
	 */
	public function setReplace($name, $value)
	{
		if(!array_key_exists($name, $this->replaces)){
			$this->replaces[$name] = new EspaldaReplace($name, "");
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
	public function getReplace($name)
	{
		if(array_key_exists($name, $this->replaces)){
			return $this->replaces[$name]->getValue($value);
		}else{
			return false;
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
	/**
	 * Prepara o template com os valores informados
	 * 
	 * @return string template parseado
	 */
	public function getOutput()
	{
		$ns = $this->source;
		
		$keys = array_keys($this->replaces);
		for($i=0; $i < count($keys); $i++){
			$ns = str_replace("replace_{$keys[$i]}_replace", $this->replaces[$keys[$i]]->getOutput(), $ns);
		}
		
		$keys = array_keys($this->displays);
		for($i=0; $i < count($keys); $i++){
			if($this->displays[$keys[$i]]->getValue()){
				$display = $this->displays[$keys[$i]]->getOutput();
			}else{
				$display = "";
			}
			$ns = str_replace("display_{$keys[$i]}_display", $display, $ns);
		}
		
		$keys = array_keys($this->regions);
		for($i=0; $i < count($keys); $i++){
			$ns = str_replace("region_{$keys[$i]}_region", $this->regions[$keys[$i]]->getOutput(), $ns);
		}
		
		return $ns;

	}
}
?>