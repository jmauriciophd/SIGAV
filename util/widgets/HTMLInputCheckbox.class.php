<?php
/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 * TODO: testar este componente extensivamente
 */
class HTMLInputCheckbox extends HTMLInput {
	private $state;
	private static $innerCounter=0;
	public function HTMLInputCheckbox($name=null) {
		$this->name     =$name;
		$this->id       ="";
		$this->value    ="";
		$this->size     ="";
		$this->maxLength="";
		$this->events   =array();
		$this->isEnabled="";
		$this->class    ="";
		$this->style    ="";
		$this->inputType= "input type=\"checkbox\" ";
		$this->tabIndex ="";
		$this->title    ="" ;
		$this->state    ="";
		$this->label = (is_null($name) )? "CheckBox_" . self::$innerCounter."<br>" : $name ;
		self::$innerCounter++;
	}

	/**
	 * Configura o estado bistate do componente CheckBox de
	 * Formulário HTML;
	 *
	 * @param boolean $bool
	 */
	public function isChecked($bool=false) {
		if(is_bool($bool) && $bool==true){
			$this->state=" checked  ";
		}
	}
	/**
	 * Recupera o valor do atributo checked do elemento
	 * de Formulário HTML
	 *
	 * @return string
	 */
	private function getState() {
		if(strlen( $this->state) > 5){
			return $this->state;
		}
		return " ";
	}
	/**
	 * Redefinição do método herdado. Redesenha polimorficamente este
	 * elemento de Entrada do formulário
	 */
	public function printOut() {
		$this->out ="<" . $this->getInputType() ." ".
		$this->getName().
		$this->getId().
		$this->getCSSClass() .
		$this->getEvents() .
		$this->getEnabled() .
		$this->getMaxLength() .
		$this->getSize() .
		$this->getTabIndex() .
		$this->getCSSStyle() .
		$this->getValue() .
		$this->getState().
		$this->getTitle()  ." />" ;
		echo $this->out;
	}
	public function getOutput() {
		$this->out ="<" . $this->getInputType() ." ".
		$this->getName().
		$this->getId().
		$this->getCSSClass() .
		$this->getEvents() .
		$this->getEnabled() .
		$this->getMaxLength() .
		$this->getSize() .
		$this->getTabIndex() .
		$this->getCSSStyle() .
		$this->getValue() .
		$this->getState().
		$this->getTitle()  ." />" ;
		return $this->out;
	}



}

?>
