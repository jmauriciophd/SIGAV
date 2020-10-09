<?php

class HTMLInputFile extends HTMLInput {
	private static $innerCounter=0;
	private  $MAX_FILE_SIZE;
	public function HTMLInputFile($name=null) {
		$this->name = (is_null($name) )? "File" . self::$innerCounter : $name ;
		$this->id       ="";
		$this->value    ="HIDDEN";
		$this->inputType= 'input type="file" ';
		self::$innerCounter++;
	}
	/**
	 * TODO
	 * @param integer $maxFilesize
	 */
	public function setMaxLength($maxFilesize=1024){

	}
	/**
	 * TODO
	 * @return string
	 */
	protected function getMaxLength(){

	}

	public function printOut() {
		$out ="<" .
		$this->getInputType() .
		$this->getName()      .
		$this->getId()        .
		$this->getValue()     .
		$this->getTitle()     .
		$this->getTabIndex()  .
		$this->getMaxLength() .
        "/>\n";
		echo $out;
	}
	public function getOutput() {
		$out ="<" .
		$this->getInputType() .
		$this->getName()      .
		$this->getId()        .
		$this->getValue()     .
		$this->getTitle()     .
		$this->getTabIndex()  .
		$this->getMaxLength() .
        "/>\n";
		return $out;
	}

}

?>