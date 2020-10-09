<?php
class Object {
	/**
	 * 
	 */
	 private $value;
	public function Object($valor) {
	  $this->value = $valor;
	}
	public function valueOf(){
		
	} 
	/**
	 * @return string
	 */
	
	public function __toString() {
		return $this->value;
	}
	/**
	 * @return boolean
	 */
	public function equals() {
		return null;
	}
	/**
	 * 
	 */	
	public function className() {
		return null;
	}
}