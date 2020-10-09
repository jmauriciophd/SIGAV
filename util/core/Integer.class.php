<?php


class Integer extends Object implements Number  {
	private $value;
	public function Integer($value) {
		if(!is_numeric($value)){
			throw new Exception("Passado caracter:" .$value.".  Tipo ilegal, deveria ser numérico... ");
		}
		$this->value = (int)$value;
	}
	/**
	 *
	 */
	public function equals(Object $obj) {
		if (!$obj instanceof Integer) {
			return false;
		}
		if (intval($this->value) === $obj->valueOf()) {
			return true;
		}
		return false;
	}
	/**
	 *
	 */
	public function valueOf() {
		return intval($this->value);
	}
	/**
	 *
	 */
	public function __toString() {
		return (string)$this->value;
	}
}
?>

