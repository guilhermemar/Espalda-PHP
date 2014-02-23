<?php
/**
 * Manipula marcações do tipo replace
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
class EspaldaReplace
{
	/**
	 * Nome da marcação
	 * 
	 * @var string
	 */
	private $name  = "";
	
	/**
	 * Valor da marcação
	 * 
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
	 * 
	 * @param string $name Nome da marcação
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * Retorna o nome da marcação
	 * 
	 * @return string Nome da marcação
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Define o valor da marcação
	 * 
	 * @param string $value O valor da marcação
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}
	
	/**
	 * Retorna o valor da marcação
	 * 
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