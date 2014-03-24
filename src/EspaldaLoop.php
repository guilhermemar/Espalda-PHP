<?php 
/**
 * Represents and manipulate a EspaldaLoop element
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
class EspaldaLoop extends EspaldaEngine
{
	/**
	 * Storage intaerations of element EspaldaEngine
	 * @var EspaldaScope[]
	 */
	private $interactions;
	
	/**
	 * Actual scope of interactions list
	 */
	private $scope;
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
		$this->name = $name;
		
		if($source !== null){
			$this->setSource($source);
		}
		
		$this->scopes = Array();
	}
	
	/**
	 * return actual scope of interactions,
	 * if length of interactions is zero, it's will create a first interation
	 * 
	 * @return EspaldaScope Actual scope of interations
	 */
	private function getScope ()
	{
		if ($this->scope === null) {
			return $this->push();
		}
		
		return $this->scope;
	}
	
	/**
	 * Add another original scope in the end of scopes list
	 * 
	 * @return EspaldaScope actual of interations
	 */
	public function push ()
	{
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
		
		
		$this->scope = $scope;
		//$this->$interactions[] = $scope;
		
		return $this->scope;
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
	 * Get the EspaldaEngine name
	 * 
	 * @return string Name of element
	 */
	public function getName ()
	{
		return $this->name;
	}
	
	/**
	 * Set value of value property of EspaldaReplace in actual scope of interatctions
	 * 
	 * @param string $name Name of EspaldaReaplace
	 * @param string $value Value of EspaldaReplace
	 * @throws EspaldaException if the solicited EspaldaReplace not exists
	 * @return $this;
	 */
	public function setReplaceValue ($name, $value)
	{
		$scope = $this->getScope();
		$scope->setReplaceValue($name, $value);
		
		return $this;
	}
	
	/**
	 * Returns the EspaldaReplace requested
	 * 
	 * @param string $name Name ov EspaldaReplace
	 * @param [optional] boolean @clone, if true return a clone of element, false (default) return a pointer
	 * @throws if the solicited EspaldaReplace not exists
	 * @return EspaldaReplace
	 */
	public function getReplace($name, $clone=false)
	{
		$scope = $this->getScope();
		
		return $scope->getReplace($name, $clone);
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
		if (!$this->displayExists($name)) {
			throw new EspaldaException(EspaldaException::DISPLAY_NOT_EXISTS);
		}
	
		$this->displays[strtolower($name)]->setValue($value);
	
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
		if(count($this->linhas) == 0){
			$this->push();
		}
		$line = count($this->linhas)-1;
		
		return $this->linhas[$line]->getDisplay($name, $clone);
		
	}
	
	public function getDisplayOriginal($name, $clone=false)
	{
		return parent::getDisplay($name, $clone);
	
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
		if(count($this->linhas) == 0){
			$this->push();
		}
		
		$line = count($this->linhas)-1;
		
		return $this->linhas[$line]->getRegion($name, $clone);
	}
	/**
	 * Prepara o template com os valores informados
	 *
	 * @return string template parseado
	 */
	public function getOutput()
	{
		$nsf = "";
			
		for($j=0; $j < count($this->$interactions); $j++){	
			$ns = $this->source;
			
			$keys = array_keys($this->replaces);
			for($i=0; $i < count($keys); $i++){
				$ns = str_replace("replace_{$keys[$i]}_replace", $this->$interactions[$j]->getReplace($keys[$i])->getOutput(), $ns);
			}
			
			$keys = array_keys($this->displays);
			for($i=0; $i < count($keys); $i++){
				if($this->linhas[$i]->getDisplay($keys[$i])->getValue()){
					$display = $this->$interactions[$j]->getDisplay($keys[$i])->getOutput();
				}else{
					$display = "";
				}
				$ns = str_replace("display_{$keys[$i]}_display", $display, $ns);
			}
			
			$keys = array_keys($this->regions);
			for($i=0; $i < count($keys); $i++){
				$ns = str_replace("region_{$keys[$i]}_region", $this->$interactions[$j]->getRegion($keys[$i])->getOutput(), $ns);
			}
		
			$nsf .= $ns;
		}
		
		return $nsf;
	}
}
?>