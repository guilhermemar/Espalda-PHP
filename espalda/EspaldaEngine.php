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
		/*
		 * Procura por marcações entigas e as converte para as novas marcações(em formato de tag HTML)
		 */
		$this->searchOldRegions();
		$this->searchOldReplaces();
		/*
		 * Percorre o template procurando as marcaçẽos espalda
		 */
		while(preg_match(EspaldaRules::$firstTag, $this->source, $found)){
			/*
			 * procura dentro da marcação encontrada o tipo de marcação
			 */
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
	/**
	 * Busca e registra o escopo da replace dentro do template
	 * @param string $replace A tag espalda do replace desejada
	 */
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
	/**
	 * Busca e registra o escopo da regiao dentro do template
	 * @param string $region A tag espalda inicial da regiao desejada
	 */
	public function addRegion($region)
	{
		preg_match(EspaldaRules::$getName, $region, $found);
		$name = count($found) >= 3 ? trim($found[2]) : "";
		
		if(empty($name)){
			return;
		}
		
		$scope = $this->setScope($region);
		
		$a = strlen($region);
		preg_match(EspaldaRules::$lastEndTag, $scope, $found);
		$b = -strlen($found[0]);
		
		$this->regions[$name] = new EspaldaRegion($name, substr($scope, $a, $b));
		$this->source = str_replace($scope, "region_".$name."_region", $this->source);	
	}
	/**
	 * Busca e registra o escopo da regiao dentro do template
	 * @param string $display A tag espalda inicial do display desejada
	 */
	public function addDisplay($display)
	{
		preg_match(EspaldaRules::$getName, $display, $found);
		$name = count($found) >= 3 ? trim($found[2]) : "";

		if(empty($name)){
			return;
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
	
	/**
	 * Busca por marcações de regiao espalda antigas e converte para a nova versão
	 */
	public function searchOldRegions()
	{
		while(preg_match(EspaldaRules::$oldRegion, $this->source, $found)){
			$tag = str_replace("[#{$found[1]}#", "<espalda type=\"region\" name=\"{$found[1]}\">", $found[0]);
			$tag = str_replace("#]", "</espalda>", $tag);
			
			$this->source = str_replace($found[0], $tag, $this->source);					
		}	
		
	}
	/**
	 * Busca por marcações de replaces espalda antigas e converte para a nova versão
	 */
	public function searchOldReplaces()
	{
		while(preg_match(EspaldaRules::$oldReplace, $this->source, $found)){
			$tag = str_replace("#{$found[1]}#", "<espalda type=\"replace\" name=\"{$found[1]}\" />", $found[0]);
			
			$this->source = str_replace($found[0], $tag, $this->source);					
		}	
	}
	/**
	 * Busca o escopo da marcação solicitada
	 * Também busca e prepara as marcações espalda existentes dentro deste escopo
	 * 
	 * @param string $init Tag espalda da marcação solicitada
	 * @return string Escopo completo
	 */
	private function setScope($init){
		/*
		 * Pega a posição inicial ddo escopo dentro do template
		 */
		$inicio = strpos($this->source, $init);
		$a = $inicio + strlen($init);
		
		$cA = Array();
		$cB = Array();
		/*
		 * separa o conteúdo pós marcação no template
		 */
		$source2 = $source = explode($init, $this->source);
		/*
		 * Looping para procura a marcação espalda final deste escopo.
		 */
		do{
			/*
			 * Looping para procurar uma marcação espalda inicial, que contenha escopo
			 */
			do{
				/*
				 * procurando próxima marcação espalda dentro do escopo
				 */
				preg_match(EspaldaRules::$firstTag, $source[1], $found);
				
				if(count($found) > 0){
					/*
					 * obtem o tipo da marcação encontrada
					 */
					preg_match(EspaldaRules::$getType, $found[0], $found1a);
					
					switch($found1a[2]){
					case "display" :
					case "region"  :
						/*
						 * se for alguma das duas, marca encerramento do while e segue para a próxima etapa que é tratar esta marcação encontrada
						 */
						//$vai = false;
						break 2;
					default :
						/*
						 * faz novo explode da fonte para poder procurar a próxima marcação espalda
						 */
						$source = explode($found[0], $source[1]);
						break;
					}
				}else{
					/*
					 * Nâo encontrada nenhuma marcação, encerra o while
					 */
					$found[0] = "";
					//$vai = false;
					break;
				}
			}while(1);
			/*
			 * pegando a proxima marcação de fechamento do espalda
			 */
			preg_match(EspaldaRules::$endTag, $source2[1], $found2);
			if(count($found2) == 0){
				$found2[0] = "";
			}
			/*
			 * obtendo a posição da tag inicial encontrada, dentro do trecho atual de procura no template
			 */
			if (empty($found[0])) {
				$pa = strlen($this->source);
			} else {
				$pa = strpos($this->source, $found[0],  $a);
			}
			/*
			 * obtendo a posição da tag final encontrada, dentro do trecho atual de procura no template
			 */
			if (empty($found2[0])) {
				$pb = strlen($this->source);
			} else {
				$pb = strpos($this->source, $found2[0], $a);
			}
			/*
			 * Incrementa a quantidade de marcações iniciais ($found) e finais ($found2) encontradas
			 */
			$cA[$pa] = $found[0];
			$cB[$pb] = $found2[0];
			
			if($pa > $pb){
				/*
				 * Valida a posição no texto das marcações espalda inicial e final que estão atualmente sendo manipuladas.
				 * se a posição da tag inicial for anterior a da final verifica a quantidade de cada marcação encontrada até agora
				 * Se a quantidade de marcações de fechamento de marcação for maior ou igual a de aberturas
				 * significa que encontrou a tag que encerra o escopo atual e então encerra o for.
				 */
				if(count($cB) >= count($cA)){
					//$prosegue = false;
					break;
				}
			}
			/*
			 * Pegando o novo trecho do template que se irá trabalhar procurando as marcações espalda
			 */
			if($pa > $pb){
				/*
				 * se a inicial vier antes no template, a busca partirá desta marcação
				 */
				$a      = $pb + strlen($found2[0]);
				$source2 = $source = explode($found2[0], $source2[1], 2);
			}else{
				/*
				 * caso contrário a busca partirá da marcação de fechamento encontrada
				 */
				$a      = $pa + strlen($found[0]);
				$source2 = $source = explode($found[0], $source[1], 2);
			}
									
		}while(1);
		/*
		 * TODO Remover a linha comentada a baixo 
		 */
		//$inicio = $ai;
		/*
		 * encontra a posição final do escopo no template
		 */
		$fim = ( $pb+strlen($found2[0]) ) - $inicio;
		/*
		 * Retorna o trecho do template referente ao escopo
		 * incluindo as marcações de inicio e fim
		 */
		return substr($this->source, $inicio, $fim);
	}
	/**
	 * Retorna o fonte original do template
	 * @return string Fonte do template
	 */
	public function getSource()
	{
		return $this->originalSource;
	}

}
?>