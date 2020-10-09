<?php
class Response {
	private $URI=null;
	private $lineBreak="\n";
	public function __construct($uri=null) {
		$this->URI = $uri;
	}
	/**
	 * Envia a pagina de volta para outro lugar
	 * causando um fluxo indireto
	 *
	 * @return void
	 * @param string $uri
	 *
	 */
	public function sendRedirect($uri=null) {
		if(is_string($uri)){
			$this->URI = ($uri != null) ? $uri : $this->URI;
			header("Location: " . $this->URI);
		}else{
			throw new Exception("Parâmetro inválido no método sendRedirect() de Response. ");
		}
	}
	/**
	 * Configura o tipo de quebra de linha, dada a necessidade de
	 * usar este mesmo codigo com ajax, a quebra de linha
	 * HTML Ã© <BR> enquanto para javascrpt Ã© "\n"
	 *
	 * @param string $break
	 */
	public function setLineBrake($break="<br/>"){
		if(is_string($break)){
			$this->lineBrake = $break;
		}else{
			throw new Exception("ParÃ¡metro invalido no metodo setLineBrake() de Response. ");
		}
	}
	/**
	 * escreve na saida a mensagem serialmente,
	 * sem quebra de linhas
	 *
	 * @param string $msg
	 */
	public function write($msg=null){
		echo $msg;
	}
	/**
	 * Escreve na saida acrescentando  a quebra de linha
	 * definida pelo usuario
	 *
	 * @param string $msg
	 */
	public function writeln($msg=null){
		echo $msg . $this->lineBreak ;
	}


}
?>