<?php
class Cpf extends RegisterChecker{
	/**
	 * Inicializa um usuario com um NIP que pode ser verificado;
	 *
	 * @param string $value
	 */
	public function __construct($value=null){
		$this->notMask="/[0]{11}|[1]{11}|[2]{11}|[3]{11}|[4]{11}|";
		$this->notMask.="[5]{11}|[6]{11}|[7]{11}|[8]{11}|[9]{11}/";
		$this->mask = "/^[0-9]{11}$/";
		if($value){
			$this->checkEntrance($value);
		}
	}
	/**
	 * Enter description here...
	 *@return string
	 */
	public function getFormat(){
		$fstDigits = substr($this->value,0,3);
		$scdDigits = substr($this->value,3,3);
		$trdDigits = substr($this->value,6,3);
		$vrfDigits = substr($this->value,9);
		if($vrfDigits){
			return "$fstDigits.$scdDigits.$trdDigits-$vrfDigits";
		}else{
			return "";
		}

	}
    /**
     * Valida um CPF adequadamente
     *
     * @return boolean
     */
	protected function validate(){
		$a = array();
		$b = 0;
		$c = 11;
		for ($i=0; $i<11; $i++){
			$a[$i] = substr($this->value,$i,1);
			if ($i < 9) $b += ($a[$i] * --$c);
		}
		if (($x = $b % 11) < 2) {
			$a[9] = 0;
		} else {
			$a[9] = 11-$x;
		}
		$b = 0;
		$c = 11;
		for ($y=0; $y<10; $y++) $b += ($a[$y] * $c--);
		if (($x = $b % 11) < 2) { $a[10] = 0;
		} else {
			$a[10] = 11-$x;
		}
		if ((substr($this->value,9,1) != $a[9]) || (substr($this->value,10,1) != $a[10])){
			return false;
		}
		return true;
	}
}
?>