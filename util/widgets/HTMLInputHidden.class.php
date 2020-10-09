<?php

class HTMLInputHidden extends HTMLInput {
	private static $innerCounter=0;
	public function HTMLInputHidden($name=null) {
		$this->name = (is_null($name) )? "Hidden" . self::$innerCounter : $name ;
		$this->id       ="";
		$this->value    ="HIDDEN";
		$this->inputType= 'input type="Hidden" ';
		self::$innerCounter++;
	}
	/**
	 * @return string
	 */
	public function printOut() {
		$out ="<" .
		$this->getInputType() ." ".
		$this->getName().
		$this->getId().
		$this->getValue()." />\n";

		echo $out;
	}
	public function getOutput() {
		$out ="<" .
		$this->getInputType() ." ".
		$this->getName().
		$this->getId().
		$this->getValue()." />\n";
		return $out;
	}

}

?>