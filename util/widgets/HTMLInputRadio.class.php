<?php
/**
 * TODO : verificar metodo e testar estado interno
 *
 */
class HTMLInputRadio extends HTMLInput {
	private $state;
	private static $innerCounter=0;
	public function HTMLInputRadio($name=null) {
		$this->name     =$name;
		$this->id       ="";
		$this->value    ="";
		$this->size     ="";
		$this->maxLength="";
		$this->events   =array();
		$this->isEnabled="";
		$this->class    ="";
		$this->style    ="";
		$this->inputType= "input type=\"radio\" ";
		$this->tabIndex ="";
		$this->title    ="" ;
		$this->state    ="";
		self::$innerCounter++;
	}

	/**
	 * Configura o estado bistate do componente CheckBox de
	 * Formul�rio HTML;
	 *
	 * @param boolean $bool
	 */
	public function isChecked($bool=false) {
		if($bool==true){
			$this->state=" checked  ";
		}else{
			throw new Exception("O par�metro passado � inv�lido.");
		}
	}
	/**
	 * Recupera o valor do atributo checked do elemento
	 * de Formul�rio HTML
	 *
	 * @return string
	 */
	private function getState() {
	
			return $this->state;
		
	}
	/**
	 * Redefini��o do m�todo herdado. Redesenha polimorficamente este
	 * elemento de Entrada do formul�rio
	 */
	public function printOut() {
		$this->out ="<".
		$this->getInputType() .
		$this->getName()      .
		$this->getId()        .
		$this->getCSSClass()  .
		$this->getEvents()    .
		$this->getEnabled()   .
		$this->getMaxLength() .
		$this->getSize()      .
		$this->getTabIndex()  .
		$this->getCSSStyle()  .
		$this->getValue()     .
		$this->getState()     .
		$this->getTitle()     ." />";
		echo $this->out;
	}
	public function getOutput() {
		$this->out ="<".
		$this->getInputType() .
		$this->getName()      .
		$this->getId()        .
		$this->getCSSClass()  .
		$this->getEvents()    .
		$this->getEnabled()   .
		$this->getMaxLength() .
		$this->getSize()      .
		$this->getTabIndex()  .
		$this->getCSSStyle()  .
		$this->getValue()     .
		$this->getState()     .
		$this->getTitle()     ." />";
		return $this->out;
	}
}

?>
