<?php
require_once dirname(__FILE__) . "/../libloader.php";

/**
* Classe que controla acoes do usuario.
* @author Rafael Dias
*/
class VestuarioController extends AbstractController
{
	private $vestuario = null;
	private $fornecedor = null;
	private $categoria = null;
	private $vestuarioDao = null;
	private $estoqueDao = null;
	
	
	/** Construtor da classe */
	function __construct($operacao = "")
	{
		parent::AbstractController($operacao, "tb_vestuario");
		$this->vestuarioDao = new VestuarioDao();
		$this->estoqueDao = new EstoqueDao();
		$this->preencheDadosVestuario();
	}
	
	private function preencheDadosVestuario()
	{
		$this->fornecedor = new Fornecedor();
		$this->fornecedor->setCnpj(Util::removeTracosPontos($this->getValueForm("cnpj_fornecedor")));
		
		$this->categoria = new Categoria();
		$this->categoria->setCodigo($this->getValueForm("codigo_categoria"));
		
		$this->vestuario = new Vestuario();
		$this->vestuario->setFornecedor($this->fornecedor);
		$this->vestuario->setCategoria($this->categoria);
		$this->vestuario->setId($this->getValueForm("id"));
		$this->vestuario->setNome($this->getValueForm("nome"));
		$this->vestuario->setCor($this->getValueForm("cor"));
		$this->vestuario->setTamanho($this->getValueForm("tamanho"));
		$this->vestuario->setValorVestuario(Util::moeda($this->getValueForm("valor_vestuario")));
		$this->vestuario->setValorAluguel(Util::moeda($this->getValueForm("valor_aluguel")));
		$this->vestuario->setMedidas($this->getValueForm("medidas"));
		$this->vestuario->setObservacao($this->getValueForm("observacao"));		
		$this->vestuario->setQuantidade($this->getValueForm("quantidade"));
	}

	/**
	* Retorna o valor da propriedade $vestuario.
	* @access public
	* @return vestuario
	*/
	public function getVestuario()
	{
		return $this->vestuario;
	}

	public function inserir()
	{ 
	 	$idGerado = $this->vestuarioDao->inserir($this->vestuario);
	 	if($idGerado != null && $idGerado != "" && $idGerado != 0) {
	 		$erro = false;
	 		$this->vestuario->setId($idGerado);
	 		for($i=0; $i < $this->vestuario->getQuantidade(); $i++){
	 			//O código do vestuario é formado por: codigo da categoria + codigo do vestuario + valor incrementado
	 			$codigoVestuario = $this->vestuario->getCategoria()->getCodigo() . $this->vestuario->getId() . $i;
	 			$estoque = new Estoque();
	 			$estoque->setVestuario($this->vestuario);
	 			$estoque->setCodigoVestuario($codigoVestuario);
	 			$estoque->setStatus(1); //1 = disponivel
	 			if($this->estoqueDao->inserir($estoque) == false){
	 				$erro = true;
	 			}
	 		}
	 		if(!$erro){
				$this->gravarLog($idGerado);
				$this->url = $this->url."?sucess&editar&id=".$idGerado;
	 		} else{
	 			$this->vestuarioDao->excluir($idGerado);
				$this->url = $this->url."?error";
			}
		} else {
			$this->url = $this->url."?error";
		}
	
		echo $this->url;
	}
	
	public function atualizar()
	{
		if($this->vestuarioDao->alterar($this->vestuario) == true){
			$this->gravarLog($this->vestuario->getId());
			$this->url = $this->url."?sucessUpdate&editar&id=" . $this->vestuario->getId();
		} else {
			$this->url = $this->url."?errorUpdate&editar&id=" . $this->vestuario->getId();
		}
		
		echo $this->url;
	}
	
	public function excluir()
	{
		if($this->vestuarioDao->excluir($this->vestuario->getId())){
			$this->gravarLog($this->vestuario->getId());
			$this->url = $this->url."?sucessDelete";
		} else {
			$this->url = $this->url."?errorDelete";
		}
		
		echo $this->url;
	}

	public function consultarTodosVestuarios(){
		$listaVestuario = new ArrayList();
		$result = $this->vestuarioDao->consultarTodosVestuarios();
		$tamanhoLista = 0;
		
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i = 0; $i < $tamanhoLista; $i++){
					  $dados = $result[$i]->getElements();
				 	  
					  $vestuario = new Vestuario();
					  $categoria = new Categoria(); 
					  $categoria->setCodigo($dados[9]);
					  $categoria->setDescricao($dados[10]);	 
					  $vestuario->setId($dados[0]);
				 	  $vestuario->setNome($dados[1]);
				 	  $vestuario->setCor($dados[2]);
				 	  $vestuario->setMedidas($dados[3]);
				 	  $vestuario->setTamanho($dados[4]);
				 	  $vestuario->setValorAluguel($dados[5]);
				 	  $vestuario->setValorVestuario($dados[7]);
				 	  $vestuario->setCategoria($categoria);
				 	  $listaVestuario->add($vestuario, $i);
			}
		}
		
		return $listaVestuario;
	}
	
	public function consultarVestuarioPorId($idVestuario)
	{
		$vestuario = $this->vestuarioDao->consultarVestuarioPorId($idVestuario);
		$listaEstoque = $this->consultarEstoquePorVestuario($vestuario->getId());
		$vestuario->setListaEstoque($listaEstoque);
		return $vestuario;
	}

	public function consultarVestuarioPorNome($nome)
	{
		return $this->vestuarioDao->consultarVestuarioPorNome($nome);
	}
	
	public function consultarVestuarioLike($param)
	{
		return $this->vestuarioDao->consultarVestuarioLike($param);
	}  
	
	public function consultarVestuario(Vestuario $vestuario){
		$listaVestuario = new ArrayList();
		$result = $this->vestuarioDao->consultarVestuario($vestuario);
		$tamanhoLista = 0;
		
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i = 0; $i < $tamanhoLista; $i++){
					  $dados = $result[$i]->getElements();
				 	  
					  $vestuario = new Vestuario();
					  $categoria = new Categoria(); 
					  $categoria->setCodigo($dados[9]);
					  $categoria->setDescricao($dados[10]);	 
					  $vestuario->setId($dados[0]);
				 	  $vestuario->setNome($dados[1]);
				 	  $vestuario->setCor($dados[2]);
				 	  $vestuario->setMedidas($dados[3]);
				 	  $vestuario->setTamanho($dados[4]);
				 	  $vestuario->setValorAluguel($dados[5]);
				 	  $vestuario->setValorVestuario($dados[7]);
				 	  $vestuario->setCategoria($categoria);
				 	  $listaVestuario->add($vestuario, $i);
			}
		}
		
		return $listaVestuario;
	}
	
	public function consultarEstoquePorVestuario($idVestuario){
		$listaEstoque = new ArrayList();
		$result = $this->estoqueDao->consultarEstoquePorVestuario($idVestuario);
		$tamanhoLista = 0;
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			for ($i = 0; $i < $tamanhoLista; $i++){
					  $dados = $result[$i]->getElements();
					  $vestuario = new Vestuario();
					  $estoque = new Estoque(); 
					  $estoque->setCodigoVestuario($dados[0]);
					  $vestuario->setId($dados[1]);
					  $estoque->setVestuario($vestuario);
					  $estoque->setStatus($dados[2]);
				 	  $listaEstoque->add($estoque, $i);
			}
		}
		
		return $listaEstoque;
	}
	
	public function consultarEstoquePorCodigo($codigo){
		return $this->estoqueDao->consultarEstoquePorCodigo($codigo);
	}
}

    $request = new Request();
	$operacao = $request->getParameter("operacao");
	
	if($operacao != null || $operacao != ""){
		$vestuarioController  = new VestuarioController();
		if($operacao == "cadastrar"){
			$vestuarioController->inserir();
		} elseif ($operacao == "atualizar"){
			$vestuarioController->atualizar();
		} elseif ($operacao == "excluir"){
			$vestuarioController->excluir();
		} elseif ($operacao == "pesquisar"){
			$vestuarioController->consultarVestuario($vestuarioController->getVestuario());
		}  elseif($operacao == "addVestuario"){
			$estoque = $vestuarioController->consultarEstoquePorCodigo($request->getParameter("id"));
			if($estoque->getCodigoVestuario() != null && $estoque->getVestuario() != null && $estoque->getVestuario()->getId() != null) {
				$vestuario = $vestuarioController->consultarVestuarioPorId($estoque->getVestuario()->getId());
				if($vestuario->getId() != null){
					echo $estoque->getCodigoVestuario() . "," . $vestuario->getNome() . "," . "indefinida" . "," . $vestuario->getCor() . "," . $vestuario->getMedidas() . "," . $vestuario->getTamanho() . "," . $vestuario->getValorAluguel();
				} else {
					echo null;
				}
			} else {
				echo null;
			}
		} elseif($operacao == "buscarNomeVestuario"){
			$query = $vestuarioController->consultarVestuarioLike($request->getParameter("q"));
			while ($result = mysql_fetch_array($query)) {
       			echo $result[1] ."\n";
       		}
		} elseif($operacao == "buscarCodigoVestuario"){
			$query = $vestuarioController->consultarVestuarioLike($request->getParameter("q"));
			while ($result = mysql_fetch_array($query)) {
       			echo $result[0] ."\n";
       		}
		} elseif($operacao == "verificarNome"){
			$vestuario = $vestuarioController->consultarVestuarioPorNome($request->getParameter("nome"));
			if($vestuario->getId() != null && $vestuario->getId() != ""){
       			echo "../vestuario/VestuarioFormCadastrar.php?editar&id=".$vestuario->getId();
			}
		}
		else{
			$vestuarioController->redirecionaPagina("javascript:history.go(-1)");
		}
	}
	
?>