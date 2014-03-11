<?php
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
	private $value = true;
	/**
	 * Construtora da classe
	 * 
	 * @param string $name Nome da marcação (propriedade "name" da tag)
	 * @param string $source O escopo da marcação
	 */
	public function __construct($name, $source = false)
	{
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
	public function setName($name){
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
		$this->value = $value ? true : false;
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