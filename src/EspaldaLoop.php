<?php 
/**
 * Represents and manipulate a EspaldaLoop element
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */
class EspaldaLoop extends EspaldaEngine
{
	/**
	 * Armazena as linhas (repetições no escopo da marcação) da região
	 * @var EspaldaLina[]
	 */
	private $scopes;
	/**
	 * Nome da marcação
	 * @var string
	 */
	private $name;
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
		
		$this->linhas = Array();
	}
	/**
	 * Adiciona mais uma linha, uma cópia do escopo original da região
	 */
	public function moreLine()
	{
		//$this->linhas[] = new EspaldaLine();
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
		
		$this->scopes[] = $scope;
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
	 * Cria e informa o valor para uma marcação "replace"
	 * 
	 * @param string $name Nome da marcação
	 * @param string $value Valor para a marcação
	 * 
	 * TODO Criar método que retorne a chave da linha atual
	 */
	public function setReplaceValue($name, $value)
	{
		if(count($this->linhas) == 0){
			$this->moreLine();
		}
		
		$line = count($this->linhas)-1;
		
		$this->linhas[$line]->setReplaceValue($name, $value);
	}
	/**
	 * Retorna o conteúdo armazenado para uma tag do tipo replace
	 * 
	 * @param string $name Nome da marcação
	 * @return string|boolean Conteúdo da marcação ou False em caso de nome inválido da marcação
	 */
	public function getReplace($name)
	{
		if(count($this->linhas) == 0){
			$this->moreLine();
		}
		
		$line = count($this->linhas)-1;
		
		return $this->linhas[$line]->getReplace($name);
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
			$this->moreLine();
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
			$this->moreLine();
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
			
		for($j=0; $j < count($this->linhas); $j++){	
			$ns = $this->source;
			
			$keys = array_keys($this->replaces);
			for($i=0; $i < count($keys); $i++){
				$ns = str_replace("replace_{$keys[$i]}_replace", $this->linhas[$j]->getReplace($keys[$i])->getOutput(), $ns);
			}
			
			$keys = array_keys($this->displays);
			for($i=0; $i < count($keys); $i++){
				if($this->linhas[$i]->getDisplay($keys[$i])->getValue()){
					$display = $this->linhas[$j]->getDisplay($keys[$i])->getOutput();
				}else{
					$display = "";
				}
				$ns = str_replace("display_{$keys[$i]}_display", $display, $ns);
			}
			
			$keys = array_keys($this->regions);
			for($i=0; $i < count($keys); $i++){
				$ns = str_replace("region_{$keys[$i]}_region", $this->linhas[$j]->getRegion($keys[$i])->getOutput(), $ns);
			}
		
			$nsf .= $ns;
		}
		
		return $nsf;
	}
}
?>