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
 * Métodos comuns as principais classes da biblioteca
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
abstract class EspaldaEngine
{	
	/**
	 * Save the original template string
	 * @var string
	 */
	protected $originalSource;
	/**
	 * Contém o template pré parseado
	 * @var string
	 */
	protected $source;
	/**
	 * All regions of template
	 * @var EspaldaRegion[]
	 */
	protected $regions;
	/**
	 * All replaces of template
	 * @var EspaldaReplace[]
	 */
	protected $replaces;
	/**
	 * All displays of template
	 * @var EspaldaDisplay[]
	 */
	protected $displays;
	/**
	 * Construtora da classe
	 */
	public function __construct()
	{
		$this->regions  = Array();
		$this->replaces = Array();
		$this->displays = Array();
	}
	/**
	 * Armazena um template com as marcações
	 *
	 * @param string $source Fonte do template com as marcações espalda
	 * @since 0.7
	 */
	public function setSource($source)
	{
		$this->originalSource = $this->source = $source;
		$this->prepareSource();
	}
	/**
	 * Carrega um arquivo de template
	 *
	 * @param string $source Caminho do arquivo de template
	 * @since 0.7
	 */
	public function loadSource($path)
	{

		if(!file_exists($path)){
			return false;
		}
		if(!is_readable($path)){
			return false;
		}
		if(!$source = file_get_contents($path)){
			return false;
		}

		$this->setSource($source);
			
		return true;
	}
	/**
	 * Executa o pré parse do template
	 * 
	 * @since 0.7
	 */
	public function prepareSource()
	{
		$this->searchOldRegions();
		$this->searchOldReplaces();
		
		while(preg_match(EspaldaRules::$firstTag, $this->source, $found)){
			preg_match(EspaldaRules::$getType, $found[0], $found2);

			$type = strtolower(trim($found2[2]));
			switch($type){
			case "region" :
				$this->addRegion($found[0]);
				break;
				
			case "display" :
				$this->addDisplay($found[0]);
				break;
					
			case "replace" :
			default :
				$this->addReplace($found[0]);
				break;	
			}
		}
	}
	
	public function addReplace($replace)
	{
		preg_match(EspaldaRules::$getName, $replace, $found);
		$name = count($found) >= 3 ? trim($found[2]) : "";
		
		preg_match(EspaldaRules::$getValue, $replace, $found);
		$value = count($found) >= 3 ? $found[2] : "";
		
		$toSource = "";
		
		if($name != ""){
		
			$this->replaces[$name] = new EspaldaReplace();
			$this->replaces[$name]->setName($name);
			$this->replaces[$name]->setValue($value);
			
			$toSource = "replace_{$name}_replace";
			
		}
		
		$this->source = str_replace($replace, $toSource, $this->source);

	}
	
	public function addRegion($region)
	{
		preg_match(EspaldaRules::$getName, $region, $found);
		$name = count($found) >= 3 ? trim($found[2]) : "";
		
		if(empty($name)){
			return false;
		}
		
		$scope = $this->setScope($region);
		
		$a = strlen($region);
		preg_match(EspaldaRules::$lastEndTag, $scope, $found);
		$b = -strlen($found[0]);
		
		$this->regions[$name] = new EspaldaRegion($name, substr($scope, $a, $b));
		$this->source = str_replace($scope, "region_".$name."_region", $this->source);	
	}
	
	public function addDisplay($display)
	{
		preg_match(EspaldaRules::$getName, $display, $found);
		$name = count($found) >= 3 ? trim($found[2]) : "";

		if(empty($name)){
			return false;
		}
		
		$scope = $this->setScope($display);
		
		$a = strlen($display);
		preg_match(EspaldaRules::$lastEndTag, $scope, $found);
		$b = -strlen($found[0]);
		
		$this->displays[$name] = new EspaldaDisplay($name, substr($scope, $a, $b));
		preg_match(EspaldaRules::$getValue, $display, $found);
		$value = count($found) >= 3 ? trim($found[2]) : "";
		$value = strtolower($value) == "false" ? false : $value;
		$this->displays[$name]->setValue($value);
		
		$this->source = str_replace($scope, "display_".$name."_display", $this->source);	
	}
	
	
	public function searchOldRegions()
	{
		while(preg_match(EspaldaRules::$oldRegion, $this->source, $found)){
			$tag = str_replace("[#{$found[1]}#", "<espalda type=\"region\" name=\"{$found[1]}\">", $found[0]);
			$tag = str_replace("#]", "</espalda>", $tag);
			
			$this->source = str_replace($found[0], $tag, $this->source);					
		}	
		
	}
	
	public function searchOldReplaces()
	{
		while(preg_match(EspaldaRules::$oldReplace, $this->source, $found)){
			$tag = str_replace("#{$found[1]}#", "<espalda type=\"replace\" name=\"{$found[1]}\" />", $found[0]);
			
			$this->source = str_replace($found[0], $tag, $this->source);					
		}	
	}
	
	private function setScope($init){
		$ai = strpos($this->source, $init);
		$a = $ai + strlen($init);
		
		$cA = Array();
		$cB = Array();
		
		$source2 = $source = explode($init, $this->source);
		
		$prosegue = true;
		do{
			$vai = true;
			do{
				preg_match(EspaldaRules::$firstTag, $source[1], $found);
				
				if(count($found) > 0){
					preg_match(EspaldaRules::$getType, $found[0], $found1a);
					
					switch($found1a[2]){
					case "display" :
					case "region"  :
						$vai = false;
						break;
					default :
						$source = explode($found[0], $source[1]);
						break;
					}
				}else{
					$found[0] = "";
					$vai = false;
				}
			}while($vai);
			
			preg_match(EspaldaRules::$endTag, $source2[1], $found2);
			if(count($found2) == 0){
				$found2[0] = "";
			}
			
			@$pa = strpos($this->source, $found[0],  $a);
			@$pb = strpos($this->source, $found2[0], $a);
			
			if($pa == null){
				$pa = strlen($this->source);
			}
			if($pb == null){
				$pb = strlen($this->source);
			}
		
			$cA[$pa] = $found[0];
			$cB[$pb] = $found2[0];
			
			if($pa > $pb){
				if(count($cB) >= count($cA)){
					$prosegue = false;
				}
			}
		
			if($pa > $pb){
				$a      = $pb + strlen($found2[0]);
				$source2 = $source = explode($found2[0], $source2[1], 2);
			}else{
				$a      = $pa + strlen($found[0]);
				$source2 = $source = explode($found[0], $source[1], 2);
			}
									
		}while($prosegue);
		
		$inicio = $ai;
		$fim    = ( $pb+strlen($found2[0]) ) - $inicio;

		return substr($this->source, $inicio, $fim);
	}
	
	public function getSources()
	{
		echo $this->source;
	}

}
?>