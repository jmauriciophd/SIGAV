<?php
/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 *
 */
class HTMLInputSubmit extends HTMLInput {
	private static $innerCounter=0;
	public function HTMLInputSubmit($name=null) {
		$this->name = (is_null($name) )? "SubmitButton_" . self::$innerCounter : $name ;
		$this->id       ="";
		$this->value    ="";
		$this->size     ="";
		$this->class    =" ";
		$this->styles   =array();
		$this->events   =array();
		$this->title    ="";
		$this->tabIndex ="";
		$this->inputType= "input type=\"submit\" ";
		$this->title    ="" ;
		self::$innerCounter++;
	}

	/**
	 * Um Elemento Submit devidamente configurado.
	 * @return string
	 *
	 */
	public function printOut() {
		$out = "<" .
		$this->getInputType() .
		$this->getName()      .
		$this->getId()        .
		$this->getValue()     .
		$this->getTitle()     .
		$this->getTabIndex()  .
		$this->getCSSClass()  .
		$this->getCSSStyle()  .
		$this->getEvents()    .
		$this->getEnabled()   .
        " /> \n";
		echo $out;
	}
	public function getOutput() {
		$out = "<" .
		$this->getInputType() .
		$this->getName()      .
		$this->getId()        .
		$this->getValue()     .
		$this->getTitle()     .
		$this->getTabIndex()  .
		$this->getCSSClass()  .
		$this->getCSSStyle()  .
		$this->getEvents()    .
		$this->getEnabled()   .
        " /> \n";
		echo $out;
	}

}

?>