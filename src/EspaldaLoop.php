<?php
/**
 * DONE
 * Represents and manipulate a EspaldaLoop element
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
class EspaldaLoop extends EspaldaEngine
{
	/**
	 * Element Name
	 * @var string
	 */
	private $name;
	
	/**
	 * Storage interations of element EspaldaEngine
	 * @var EspaldaScope[]
	 */
	private $interactions;
	
	/**
	 * Construct
	 *
	 * @param string $name EspaldaLoop name
	 * @param string $source EspaldaLoop scope
	 */
	public function __construct ($name, $source = null)
	{
		parent::__construct($source);
		
		$this->name = $name;
		
		$this->interactions = Array();
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
	 * return actual scope of interactions,
	 * if length of interactions is zero, it's will create a first interation
	 * 
	 * @return EspaldaScope current scope of interations
	 */
	private function current ()
	{
		if (!count($this->interactions)) {
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
		$this->interactions[] = $this->scope->getClone();
		return end($this->interactions);
	}
	
	/**
	 * Check if EspaldaReplace exists
	 * 
	 * @param string $name Name of EspaldaReplace for check
	 * @return boolean
	 */
	public function replaceExists ($name)
	{
		return $this->scope->replaceExists($name);
	}
	
	/**
	 * Set the EspaldaDisplay value for current interation
	 * 
	 * @param string $name Name of EspaldaReplace
	 * @param string $value New value for value property
	 * @throws EspaldaException if the solicited EspaldaReplace not to exist
	 * @return $this
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
	 * @param [optional] boolean $clone 'true' return a clone of element, 'false' return a pointer. Default false
	 * @throws If the solicited EspaldaReplace not exist
	 * @return EspaldaReplace
	 */
	public function getReplace($name, $clone=false)
	{
		return $this->current()->getReplace($name, $clone);
	}
	
	/**
	 * Check if EspaldaDisplay exists
	 *
	 * @param string $name Name of EspaldaDisplay for check
	 * @return boolean
	 */
	public function displayExists ($name)
	{
		return $this->scope->displayExists($name);
	}
	
	/**
	 * Set value of value property of a EspaldaDisplay for current interation
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
	 * Return the EspaldaDisplay requested from current interation
	 *
	 * @param string $name Name of EspaldaReplace
	 * @param [optional] boolean $clone 'true' return a clone of element, 'false' return a pointer. Default false
	 * @throws If the solicited EspaldaReplace not to exist
	 * @return EspaldaDisplay
	 */
	public function getDisplay($name, $clone=false)
	{
		return $this->current()->getDisplay($name, $clone);
	}
	
	/**
	 * Check if EspaldaLoop exists
	 * 
	 * @param string $name Name of EspaldaLoop to check
	 * @return boolean
	 */
	public function loopExists ($name)
	{
		return $this->scope->loopExists($name);
	}
	
	/**
	 * Retorna uma instância de espaldaRegion da marcação solicitada
	 *
	 * @param string $name Noma da marcação region
	 * @param boolean $clone se deverá ser retornado um clone ou um ponteiro da instância
	 * @throws If the solicited EspaldaLoop not to exist
	 * @return Instância ou clone da instância espaldaRegion da marcação region solicitada
	 */
	public function getLoop($name, $clone=false)
	{
		return $this->current()->getLoop($name, $clone);
	}
	
	/**
	 * Parse EspaldaLoop scope with values of this class and return result
	 *
	 * @return string parsed template
	 */
	public function getOutput()
	{
		$output = "";


		for($i=0; $i < count($this->interactions); $i++){
			$current = $this->interactions[$i];
			$currentSource = $this->source;

			$replaces = $current->getAllReplaces();
			$keys = array_keys($replaces);
			for ($j=0; $j < count($keys); ++$j) {
				$currentSource = str_replace("espalda:replace:{$keys[$j]}", $current->getReplace($keys[$j])->getOutput(), $currentSource);
			}

			$displays = $current->getAllDisplays();
			$keys = array_keys($displays);
			for ($j=0; $j < count($keys); ++$j) {
				$currentSource = str_replace("espalda:display:{$keys[$j]}", $current->getDisplay($keys[$j])->getOutput(), $currentSource);
			}

			$loops = $current->getAllLoops();
			$keys = array_keys($loops);
			for($j=0; $j < count($keys); ++$j){
				$currentSource = str_replace("espalda:loop:{$keys[$j]}", $current->getLoop($keys[$j])->getOutput(), $currentSource);
			}

			$output .= $currentSource;
		}
		
		return $output;
	}
	
	/**
	 * Create a EspaldaLoop with values equals the this class
	 *
	 * @return EspaldaLoop
	 */
	public function getClone ()
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