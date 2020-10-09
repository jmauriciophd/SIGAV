<?php
class Request{
	private $collection;
	protected  $requestSize;
	public function __construct() {
		/**
		 * Inicializacao das variaveis de objetos com informacoes
		 * de cabecalhos
		 */
		$this->requestSize  = 0;
		$this->collection   =  array ();

		if ($_SERVER["REQUEST_METHOD"] == 'POST') {
			foreach ($_POST as $key => $value) {
				$this->collection[$key] = $value;
				$this->requestSize++;
			}
			//$_POST=null;
		} else if ($_SERVER["REQUEST_METHOD"] == 'GET') {
			foreach ($_GET as $key => $value) {
				$this->collection[$key] = $value;
				$this->requestSize++;
			}
			//$_GET = null;
		}
	}
	/**
	 * Monta um requisicao internamente no servidor ou incrementa
	 * os dados no servidor
	 *
	 * @param string $paramName
	 * @param string $paramValue
	 */
	public function addParam($paramName , $paramValue){
		if(is_string($paramName)){
			$this->collection[$paramName] = $paramValue ;
		}
	}
	/**
	 * Reinicializa o objeto Request
	 */
	public function reset(){
		$_POST    = null;
		$_GET     = null;
		$_REQUEST = null;
		$_FILES   = null;
		$this->requestSize  = 0;
		$this->collection   =  array ();
	}
	/**
	 * Recupera e retona o dado armazenado em Request
	 *
	 * @param sring $param
	 * @return string
	 */
	public function getParameter($param) {
		if(is_string($param)){
			//verifica se o indice solicitado esta armazenado no objeto Request
			if(array_key_exists($param,$this->collection)){
				return $this->collection[$param];
			}else{
				return null;
			}
		}else{
			throw new Exception("Parametro inv�lido no m�todo getParameter() de Request().\n");
		}
	}
	/**
	 * Retorna um array com todos os campos de formul�rios
	 * armazenados em um Objeto Request()
	 *
	 * @return array
	 */
	public function getParameters() {
		return $this->collection;
	}
	/**
	 * @deprecated
	 * @param string $compareTo
	 * @param string $comparable
	 * @return boolean
	 */
	private function checkEquality($compareTo, $comparable) {
		if ($this->collection[$compareTo] == $this->collection[$comparable]) {
			return true;
		}
		return false;
	}
	/**
	 * Recupera a quantidade de campos recebidos
	 * de um formulario HTML, exceto os elementos File.
	 *
	 * @return integer
	 */
	public function getRequestSize() {
		return $this->requestSize;
	}
	public function getRawData(){
		$GLOBALS['$HTTP_RAW_POST_DATA'];
	}
	public function __destruct(){
			
	}
}
?>