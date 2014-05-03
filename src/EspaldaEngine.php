<?php
/**
 * This class parse and extract Espalda's elements from the template
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 */

//TODO looping infinito quando não tem name, pensar na opção de colocar direto no source com o value informado

abstract class EspaldaEngine extends EspaldaRules
{
	/**
	 * Saves the original template with the Espalda's tag
	 * @var string
	 */
	protected $originalSource;

	/**
	 * Contains the template pre-parsed to receive the real content
	 * @var string
	 */
	protected $source;

	/**
	 * Scope with all elements obtained from the template
	 * @var EspaldaScope
	 */
	protected $scope;

	/**
	 * construct
	 * 
	 * @param [optional] string $source Template to be parsed
	 */
	public function __construct ($source)
	{
		$this->scope = new EspaldaScope();

		if (!is_null($source)){
			$this->setSource($source);
		}
	}

	/**
	 * Set the source and executes the pre-parse to load all Espalda's components
	 *
	 * @param string $source Template to be parsed
	 */
	public function setSource($source)
	{
		$this->originalSource = $this->source = $source;
		$this->prepareSource();
	}

	/**
	 * Execute a pre-parse in the templace source 
	 */

	protected function prepareSource()
	{
		//$this->parseInlineReplaces();
		//$this->searchOldLoops();
		
		
		while (preg_match($this->regex_espaldaTag, $this->source, $found, PREG_OFFSET_CAPTURE)) {
			
			$properties = Array();
			
			if (key_exists('type', $found)) {
				$properties['type'] = strtolower(trim($found['type'][0]));
			} else {
				throw new EspaldaException(EspaldaException::TYPE_NOT_FOUND);
			}
			
			if (key_exists('name', $found)) {
				$properties['name'] = strtolower(trim($found['name'][0]));
			} else {
				throw new EspaldaException(EspaldaException::NAME_NOT_FOUND);
			}
			
			if (key_exists('value', $found)) {
				$properties['value'] = $found['value'][0];
			}
			
			$properties['position'] = $found[0][1];
			
			switch($properties['type']) {
			case "replace" :
				$this->extractReplace($found[0][0], $properties);
				break;
			case "display" :
				$this->extractDisplay($found[0][0], $properties);
				break;
			case "loop" :
				$this->extractLoop($found[0][0], $properties);
				break;

			default :
				throw new EspaldaException(EspaldaException::INVALID_TYPE);
			}

		}
		
	}
	
	private function extractReplace ($tag, $properties)
	{	
		$replace = new EspaldaReplace($properties['name']);
	
		if (key_exists("value", $properties)) {
			
			$replace->setValue($properties['value']);
			
		}
	
		$this->scope->addReplace($replace);
		
		$this->source = preg_replace('/'.preg_quote($tag, '/').'/', "espalda:replace:{$properties['name']}", $this->source);
	}

	private function extractDisplay($tag, $properties)
	{
		$sources = $this->takeTagScope($tag, $properties['position']);

		$display = new EspaldaDisplay($properties['name']);
		$display->setSource($sources[1]);
		
		if (key_exists("value", $properties)) {

			$display->setValue($properties['value']);

		} else {

			$display->setValue(false);
			
		}

		$this->scope->addDisplay($display);

		$this->source = preg_replace('/'.preg_quote($sources[0], '/').'/', "espalda:display:{$properties['name']}", $this->source);

	}
	
	private function extractLoop($tag, $properties)
	{
		$sources = $this->takeTagScope($tag, $properties['position']);
	
		$loop = new EspaldaLoop($properties['name']);
		$loop->setSource($sources[1]);
	
		$this->scope->addLoop($loop);
	
		$this->source = preg_replace('/'.preg_quote($sources[0], '/').'/', "espalda:loop:{$properties['name']}", $this->source);
	
	}
	
	private function takeTagScope ($tag, $startPos=0)
	{
		$internalTags = 0;
		$startPosTag = null;
		$startPosScope = null;
		$endPosTag = null;
		$endPosScope = null;

		while (preg_match($this->regex_internalEstaldaTag, $this->source, $found, PREG_OFFSET_CAPTURE, $startPos)) {

			if ($found['begin'][1] !== -1) {

				if ($found['type'][0] != 'replace') {

					if ($internalTags === 0) {
						
						if ($found[0][0] != $tag) {
							
							throw new EspaldaException(EspaldaException::PARSER_ERROR);
							
						}

						$startPosTag = $found[0][1];
						$startPosScope = $found[0][1] + strlen($found[0][0]);

					}

					++$internalTags;
				}

			} elseif ($found['end'][1] !== -1) {

				--$internalTags;

				if ($internalTags === 0) {

					$endPosTag = $found[0][1] + strlen($found[0][0]);
					$endPosScope = $found[0][1];

				}

			} else {

				throw new EspaldaException(EspaldaException::SINTAXE_ERROR);

			}

			if ($internalTags === 0) {

				break;

			} else {

				$startPos = $found[0][1] + strlen($found[0][0]);

			}

		}

		$scope = Array();
		$scope[] = substr($this->source, $startPosTag, ($endPosTag - $startPosTag));
		$scope[] = substr($this->source, $startPosScope, ($endPosScope - $startPosScope));

		return $scope;
	}

	private function makeEspaldaTag ($properties)
	{
		$tag = '<espalda ';
		$tag .= key_exists('type', $properties) ? 'type="' . $properties['type'] . '" ' : '';
		$tag .= key_exists('name', $properties) ? 'name="' . $properties['name'] . '" ' : '';
		$tag .= key_exists('value', $properties) ? 'value="' . $properties['value'] . '" ' : '';
		$tag .= '>';
		
		return $tag;
	}
	
	/**
	 * Busca por marcações de replaces espalda antigas e converte para a nova versão
	 */
	private function parseInlineReplaces()
	{
		
		while(preg_match($this->regex_inlineReplace, $this->source, $found)){

			$found['type'] = 'replace';

			$this->source = str_replace($found[0], $this->makeEspaldaTag($found), $this->source);
		}

	}
	
	/**
	 * Busca por marcações de regiao espalda antigas e converte para a nova versão
	 */
	private function searchOldLoops()
	{
		while(preg_match(EspaldaRules::$oldLoop, $this->source, $found)){
			$tag = str_replace("[#{$found[1]}#", "<espalda type=\"loop\" name=\"{$found[1]}\">", $found[0]);
			$tag = str_replace("#]", "</espalda>", $tag);
				
			$this->source = str_replace($found[0], $tag, $this->source);
		}
	
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