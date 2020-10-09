<?php
abstract class RegisterChecker{
	protected $value;
	protected $mask;
	protected $notMask;
	protected $idIsInvalid=false;
	/**
	 * Verificada se o nip passado tem alguma validade de acordo com os padroes.
	 *
	 * @return  boolean
	 */
	public function isValid(){
		return $this->validate();
	}
	/**
	 * Retorna uma string representando  o identificador.
	 *
	 * @return string
	 */
	public function get(){
		if($this->value){
			return $this->value;
		}
	}
	/**
	 * Evita entrada de dados que nao sejam no padrao de NIP convencional
	 *@throw Exception
	 * @param string $value
	 *
	 */
	protected function checkEntrance($value){
		$value = trim($value);
		$value = str_replace(".","",$value);
		$value = str_replace("/","",$value);
		$value = str_replace("-","",$value);
		$this->value = $value;
		//if(!preg_match($this->mask,$this->value) || preg_match($this->notMask,$this->value)){
		if( preg_match($this->notMask,$this->value)){
									
			//throw new Exception("O valor passado como ".strtoupper(get_class($this)). " ({$this->value}) não é válido.");
			
		}else if(!$this->validate()){
			$this->idIsInvalid = true;
			return false;
			//throw new Exception("O valor passado como ".strtoupper(get_class($this)). "({$this->value}) não é válido.");
		}
	}
	/**
	 * Alterar o valor interno do NIP afim de poder usar o mesmo objeto para
	 * para diferentes usuários
	 *
	 * @param string $value
	 */
	public function change($value=null){
		if($value){
			$this->checkEntrance($value);
		}
	}
	abstract protected function validate();
	abstract public function getFormat();

}
?>