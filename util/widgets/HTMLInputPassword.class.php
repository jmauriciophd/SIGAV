<?php
/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 *
 */
class HTMLInputPassword extends HTMLInput {
	private static $innerCounter=0;
	public function HTMLInputPassword($name=null) {
		$this->name     =(is_null($name) )? "PasswordField_" . self::$innerCounter : $name ;
		$this->id       ="";
		$this->value    ="";
		$this->size     ="";
		$this->maxLength="";
		$this->events   =array();
		$this->isEnabled="";
		$this->class    ="";
		$this->styles   =array();
		$this->inputType= 'input type="password" ';
		$this->tabIndex ="";
		$this->title    ="" ;
		$this->state    ="";
		$this->label = (is_null($name) )? "<br>PasswordField_" . self::$innerCounter."<br>" : $name ;
		self::$innerCounter++;
	}
	

}

?>