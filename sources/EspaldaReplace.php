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
 * Manipula marcações do tipo replace
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
class EspaldaReplace
{
	/**
	 * Nome da marcação
	 * @var string
	 */
	private $name  = "";
	/**
	 * Valor da marcação
	 * @var string
	 */
	private $value = "";
	/**
	 * Construtora da classe
	 * 
	 * @param string $name Nome da marcação
	 * @param string $value Conteúdo da marcação
	 */
	public function __construct($name = false, $value = false)
	{
		if($name){
			$this->setName($name);
		}	
		if($value){
			$this->setValue($value);
		}
	}
	/**
	 * Define o nome da marcação
	 * @param string $name Nome da marcação
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	/**
	 * Retorna o nome da marcação
	 * @return string Nome da marcação
	 */
	public function getName()
	{
		return $this->name;
	}
	/**
	 * Define o valor da marcação
	 * @param string $value O valor da marcação
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}
	/**
	 * Retorna o valor da marcação
	 * @return string
	 */
	public function getValue ()
	{
		return $this->value;
	}
	/**
	 * Prepara o template com os valores informados
	 *
	 * @return string template parseado
	 */
	public function getOutput ()
	{
		return $this->getValue();
	}
	
	public function __clone ()
	{
		return new EspaldaReplace($this->name, $this->value);
	}
}
?>