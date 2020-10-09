<?php
require_once dirname(__FILE__) . "/../libloader.php";

/**
* Classe que controla acoes do usuario.
* @author Jose Mauricio
*/
class AplicacaoController extends AbstractController
{
	private $aplicacao = null;
	private $aplicacaoDao = null;
	
	/** Construtor da classe */
	function __construct($operacao = "")
	{
		parent::AbstractController($operacao, "tb_aplicacao");
		$this->aplicacaoDao = new AplicacaoDao();
		$this->preencheDadosAplicacao();
	}
	
	private function preencheDadosAplicacao()
	{
		//obtem os valores vindo do formulario via post ou get
		$id = $this->getValueForm("id");
		$nomeArquivo = $this->getValueForm("nome_arquivo");
		$nomeAplicacao = $this->getValueForm("nome_aplicacao");
		$descricao = $this->getValueForm("descricao");

		//cria um novo objeto Aplicacao
		$this->aplicacao = new Aplicacao();
		$this->aplicacao->setId($id);
		$this->aplicacao->setNomeArquivo($nomeArquivo);
		$this->aplicacao->setNomeAplicacao($nomeAplicacao);
		$this->aplicacao->setDescricao($descricao);
	}
	
	/**
	* Retorna o valor da propriedade $Aplicacao
	* @access public
	* @return Usuario
	*/
	public function getAplicacao()
	{
		return $this->aplicacao;
	}
	
	/**
	* Seta um valor à propriedade $Aplicacao
	* @param string $Usuario
	*/
	public function setAplicacao(Aplicacao $aplicacao)
	{
		$this->aplicacao = $aplicacao;
	}
	
	public function consultarAplicacaoPorId($id)
	{
		return $this->aplicacaoDao->consultarAplicacaoPorId($id);
	}
		
	public function consultarTodasAplicacoes()
	{
		$listaAplicacao = new ArrayList();
		$result = $this->aplicacaoDao->consultarTodasAplicacoes();
		$tamanhoLista = 0;
		
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i = 0; $i < $tamanhoLista; $i++){
					  $dados = $result[$i]->getElements();
				 	  
					  $aplicacao = new Aplicacao();	
					  					 	 
					  $aplicacao->setId($dados[0]);
					  $aplicacao->setNomeArquivo($dados[1]);
					  $aplicacao->setNomeAplicacao($dados[2]);
					  $aplicacao->setDescricao($dados[3]);
				 	  
				 	  $listaAplicacao->add($aplicacao, $i);
			}
		}
		
		return $listaAplicacao;
	}	
	
}
?>