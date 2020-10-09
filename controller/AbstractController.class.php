<?php
require_once dirname(__FILE__) . "/../libloader.php";

/**
* Classe abstrata controladora de açoes.
* @author Rafael Dias
*/
abstract class AbstractController 
{
	private $operacao;
	private $request = null;
	private $aplicacao;
	public $nomeArquivo;
	public $tabela;
	public $chavePrimaria;
	public $url;
	
	/** Construtor da classe */
	function AbstractController($operacao = "", $tabela = "")
	{
		header("Content-Type: text/html; charset=iso-8859-1", true);
		LoginController::verficaAutenticidadeUsuario();
		if($tabela != ""){
			$this->request = new Request();
			$this->operacao = ($operacao != "") ? $operacao : $this->request->getParameter("operacao");
			$this->url = $this->getValueForm("url");
			$this->tabela = $tabela;
			$this->nomeArquivo = $this->getValueForm("nome_arquivo");
			$this->recuperarAplicacaoPorNomeArquivo();
		} else {
			$msg = "Informe o nome da tabela no construtor da classe controladora na chamada do construtor. Ex: parent::AbstractController(\$operacao, \"tb_perfil\");";
			Util::alert($msg);
			exit;
		}
	}
	
	/**
	* Retorna o valor da propriedade $request.
	* @access public
	* @return String
	*/
	public function getRequest()
	{
		return $this->request;
	}
	
	public function getValueForm($nomeCampo)
	{
		return utf8_decode($this->request->getParameter($nomeCampo));	
	}
	
	/**
	* Retorna o valor da propriedade $operacao.
	* @access public
	* @return String
	*/
	public function getOperacao()
	{
		return $this->operacao;
	}
	
	public function setOperacao($operacao)
	{
		$this->operacao = $operacao;
	}
	
	public function getAplicacao()
	{
		return $this->aplicacao;
	}
	
	public function setAplicacao(Aplicacao $aplicacao)
	{
		$this->aplicacao = $aplicacao;
	}
	
	public function redirecionaPagina($url)
	{
		$response = new Response();
		$response->sendRedirect($url);
	}
	
	public function gravarLog($chavePrimaria = "")
	{
		if($chavePrimaria != null && $chavePrimaria != ""){
			$usuario = new Usuario();
			$usuario->setCpf($_SESSION["CPF_USUARIO"]);
			
			$log = new Log();
	    	$log->setIp($_SERVER["REMOTE_ADDR"]);
	    	$log->setDataHora(date('Y-m-d H:m:s'));
	    	$log->setUsuario($usuario);
	    	$log->setOperacao($this->operacao);
	    	$log->setAplicacao($this->aplicacao);
	    	$log->setTabela($this->tabela);
	    	$log->setChavePrimaria($chavePrimaria);
	    	$logDao = new LogDao();
	    	$logDao->inserir($log);
		} else {
			$msg = "Erro ao gravar o log: <br>Informe uma chave primaria na chamada do <br/>metodo garavarLog() para poder gravar o log corretamente.";
			echo $this->url."?msgError=".$msg;
			exit;
		}
	}
	
	public function recuperarAplicacaoPorNomeArquivo()
	{
		$aplicacaoDao = new AplicacaoDao();
		$this->aplicacao = $aplicacaoDao->consultarAplicacaoPorNomeArquivo($this->nomeArquivo);
		return $this->aplicacao;
	}
	
	public static function desabilitarBotao($aplicacao, $operacao){
		PermissaoController::desabilitarBotao($aplicacao, $operacao);
	}
	
}
?>