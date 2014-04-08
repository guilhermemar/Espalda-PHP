<?php

//TODO add annotations
//TODO to create Unit tests

/**
 * Represents and manipulate a EspaldaLoop element
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
class EspaldaLoop extends EspaldaEngine
{
	/**
	 * Storage interations of element EspaldaEngine
	 * @var EspaldaScope[]
	 */
	private $interactions;
	
	/**
	 * Element Name
	 * @var string
	 */
	private $name;
	
	/**
	 * Construct
	 *
	 * @param string $name EspaldaLoop name
	 * @param string $source EspaldaLoop scope
	 */
	public function __construct ($name, $source = null)
	{
		parent::_construct($source);
		
		$this->name = $name;
		
		$this->interactions = Array();
	}
	
	/**
	 * return actual scope of interactions,
	 * if length of interactions is zero, it's will create a first interation
	 * 
	 * @return EspaldaScope current scope of interations
	 */
	private function current ()
	{
		if ($this->actual === null) {
			return $this->push();
		}
		
		return current($this->interactions);
	}
	
	/**
	 * Add another original scope in the end of interations list
	 * 
	 * @return EspaldaScope current of interations
	 */
	public function push ()
	{
		$this->interactions[] = clone $this->scope;
		
		return end($this->interactions);
		   
		/*
		//TODO testar usando clone em EspaldaScope, no caso precisa saber se rola casting de classes
		$scope = new EspaldaScope();
		
		$keys = array_keys($this->replaces);
		for($i=0; $i < count($keys); $i++){
			$a = clone $this->replaces[$keys[$i]];
			$scope->addReplace($a);
		}
		
		$keys = array_keys($this->displays);
		for($i=0; $i < count($keys); $i++){
			$a = clone $this->displays[$keys[$i]];
			$scope->addDisplay($a);
		}
		
		$keys = array_keys($this->loops);
		for($i=0; $i < count($keys); $i++){
			$a = clone $this->loops[$keys[$i]];
			$scope->addLoop($a);
		}
		
		
		$this->actual = $scope;
		//$this->$interactions[] = $scope;
		*/
	}
	
	/**
	 * Set the EspaldaLoop element name
	 *
	 * @param string $name element name
	 */
	public function setName ($name)
	{
		$this->name = $name;
	}
	
	/**
	 * Get the EspaldaLoop name
	 * 
	 * @return string Name of element
	 */
	public function getName ()
	{
		return $this->name;
	}
	
	/**
	 * Set the EspaldaDisplay value for current interation
	 * 
	 * @param string $name Name of EspaldaReaplace
	 * @param string $value Value of EspaldaReplace
	 * @throws EspaldaException if the solicited EspaldaReplace not exists
	 * @return $this;
	 */
	public function setReplaceValue ($name, $value)
	{
		$this->current()->setReplaceValue($name, $value);
		
		return $this;
	}
	
	/**
	 * Returns the EspaldaReplace requested from current interation
	 * 
	 * @param string $name Name of EspaldaReplace
	 * @param [optional] boolean @clone, if true return a clone of element, false (default) return a pointer
	 * @throws if the solicited EspaldaReplace not exists
	 * @return EspaldaReplace
	 */
	public function getReplace($name, $clone=false)
	{
		return $this->current()->getReplace($name, $clone);
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
		$this->current()->setDisplayValue($name, $value);
	
		return $this;
	}
	
	/**
	 * Retorna uma instância de espaldaDisplay da marcação solicitada
	 * 
	 * @param string $name Noma da marcação display
	 * @param boolean $clone se deverá ser retornado um clone ou um ponteiro da instância
	 * @return Instância ou clone da instância espaldaDisplay da marcação display solicitada
	 */
	public function getDisplay($name, $clone=false)
	{
		return $this->current()->getDisplay($name, $clone);
	}
	
	/**
	 * Retorna uma instância de espaldaRegion da marcação solicitada
	 *
	 * @param string $name Noma da marcação region
	 * @param boolean $clone se deverá ser retornado um clone ou um ponteiro da instância
	 * @return Instância ou clone da instância espaldaRegion da marcação region solicitada
	 */
	public function getRegion($name, $clone=false)
	{
		return $this->current()->getRegion($name, $clone);
	}
	
	/**
	 * Prepara o template com os valores informados
	 *
	 * @return string template parseado
	 */
	public function getOutput()
	{
		$output = "";
			
		for($i=0; $i < count($this->$interactions); $i++){
			$current = $this->interactions[$i];
			$currentSource = $this->source;
			
			$replaces = $current->getAllReplaces();
			$keys = array_keys($replaces);
			for ($j=0; $j < count($keys); ++$j) {
				$currentSource = str_replace("replace_{keys[$j]}_replace", $current->getReplace($keys[$j])->getOutput(), $currentSource);
			}
			
			$displays = $current->getAllDisplays();
			$keys = array_keys($displays);
			for ($j=0; $j < count($keys); ++$j) {
				$currentSource = str_replace("display_{$key[$j]}_display", $current->getDisplay($key[$j])->getOutput(), $currentSource);
			}
			
			$loops = $current->getAllLoops();
			$keys = array_keys($loops);
			for($j=0; $j < count($keys); ++$j){
				$currentSource = str_replace("region_{$keys[$j]}_region", $current->getRegion($keys[$j])->getOutput(), $ns);
			}
			
			$output .= $currentSource;
			
			/*
			$replaces = array_keys($this->scope->getAllReplaces());
			for($j=0; $j < count($keys); $j++){
				$ns = str_replace("replace_{$keys[$j]}_replace", $this->$interactions[$i]->getReplace($keys[$j])->getOutput(), $ns);
			}
			
			$keys = array_keys($this->displays);
			for($j=0; $j < count($keys); $j++){
				if($this->linhas[$j]->getDisplay($keys[$i])->getValue()){
					$display = $this->$interactions[$i]->getDisplay($keys[$j])->getOutput();
				}else{
					$display = "";
				}
				$ns = str_replace("display_{$keys[$j]}_display", $display, $ns);
			}
			
			$keys = array_keys($this->regions);
			for($j=0; $j < count($keys); $j++){
				$ns = str_replace("region_{$keys[$j]}_region", $this->$interactions[$i]->getRegion($keys[$j])->getOutput(), $ns);
			}
		
			$output .= $ns;
			*/
		}
		
		return $output;
	}
	
	public function __clone ()
	{
		$cloned = new EspaldaLoop($this->name);
		$cloned->originalSource = $this->originalSource;
		$cloned->source = $this->source;
		$cloned->scope = clone $this->scope;
		
		$cloned->interactions = array_map(function ($o) {
			return clone $o;
		}, $this->interactions);
		
		end($cloned->interactions);
		
		return $cloned;
	}
}
?>