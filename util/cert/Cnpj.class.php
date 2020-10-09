<?php
class Cnpj extends RegisterChecker{
	/**
	 * Inicializa um usuario com um NIP que pode ser verificado;
	 * @param string $value
	 */
	public function __construct($value=null){
		$this->notMask="/[0]{14}|[1]{14}|[2]{14}|[3]{14}|[4]{14}|";
		$this->notMask.="[5]{14}|[6]{14}|[7]{14}|[8]{14}|[9]{14}/";
		$this->mask = "/^[0-9]{14}$/";
		if($value){
			$this->checkEntrance($value);
		}
	}
	/**
	 * retorna um cnpj formatado de acordo com o padrao;
	 *@return string
	 */
	public function getFormat(){
		$fstDigits = substr($this->value,0,2);
		$scdDigits = substr($this->value,2,3);
		$trdDigits = substr($this->value,5,3);
		$frtDigits = substr($this->value,8,4);
		$fthDigits = substr($this->value,12);
		if($fthDigits){
			return "$fstDigits.$scdDigits.$trdDigits/$frtDigits-$fthDigits";
		}else{
			return "";
		}
	}
	/**
	 * Valida o atributo de CNPJ
	 * @return boolean
	 */
	protected  function validate(){
	 $a = array();
	 $b =0;
	 $c = array(6,5,4,3,2,9,8,7,6,5,4,3,2);
	 for ($i=0; $i<12; $i++){
	 	$a[$i] = substr($this->value,$i,1);
	 	$b += $a[$i] * $c[$i+1];
	 }
	 if (($x = $b % 11) < 2) {
	 	$a[12] = 0;
	 }else {
	 	$a[12] = 11-$x;
	 }
	 $b = 0;
	 for ($y=0; $y<13; $y++) {
	 	$b += ($a[$y] * $c[$y]);
	 }
	 if (($x = $b % 11) < 2) {
	 	$a[13] = 0;
	 } else {
	 	$a[13] = 11-$x;
	 }
	 if ((substr($this->value,12,1) != $a[12]) || (substr($this->value,13,1) != $a[13])){
	 	return false;
	 }
	 return true;
	}
}
?>