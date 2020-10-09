<?php
require_once dirname(__FILE__) . "/../libloader.php";

/**
* Classe que controla acoes do usuario.
* @author Rafael Dias
*/
class AluguelVestuarioController extends AbstractController
{
	private $aluguelVestuarioDao = null;
	private $aluguelDao = null;
	private $usuarioDao = null;
	private $clienteDao = null;
	private $pagamentoDao = null;
	private $aluguelVestuario = null;
	private $aluguel = null;
	private $cliente = null;
	private $usuario = null;
	private $pagamento = null;
	private $listaVestuarios = null;
	
	/** Construtor da classe */
    public function __construct($operacao = "")
	{
	 	parent::AbstractController($operacao, "tb_aluguel");
	 	$this->aluguelDao = new AluguelDao();
		$this->aluguelVestuarioDao = new AluguelVestuarioDao();
		$this->pagamentoDao = new PagamentoDao();
		$this->preencheDadosAluguel();
	}
	
	private function preencheDadosAluguel()
	{
			//recebe valores do formulario via post ou get
			$this->cliente = new Cliente();
			$this->cliente->setCpf(Util::removeTracosPontos($this->getValueForm("cpf_cliente")));
			
			$this->usuario = new Usuario();
			$this->usuario->setCpf(Util::removeTracosPontos($this->getValueForm("cpf_usuario"))); 
			
			$this->aluguel = new Aluguel();
			$this->aluguel->setId($this->getValueForm("id"));
			$this->aluguel->setCliente($this->cliente);
			$this->aluguel->setUsuario($this->usuario);
			$this->aluguel->setValorTotalAluguel($this->getValueForm("valor_total_aluguel"));
			$this->aluguel->setDataEntrega(Util::formataDataMysql($this->getValueForm("data_entrega")));
			$this->aluguel->setDataPrevistaDevolucao(Util::formataDataMysql($this->getValueForm("data_prevista_devolucao")));
			$this->aluguel->setDataLocacao(Util::formataDataMysql($this->getValueForm("data_locacao")));
			$this->aluguel->setDataPrevia(Util::formataDataMysql($this->getValueForm("data_previa")));
			$this->aluguel->setDataProva(Util::formataDataMysql($this->getValueForm("data_prova")));
			
		    $listaAluguelVestuarios = new ArrayList();
			
		    $qtdVestuarios = $this->getValueForm("qtdVest");
			
		    if(isset($_POST["codigo"])){
				for($i = 0; $i < $qtdVestuarios; $i++){
						$codigoVestuario = $_POST["codigo"][$i];
						//echo "codigo$i ".$codigoVestuario;
						$estoque = new Estoque();
				    	$estoque->setCodigoVestuario($codigoVestuario);
						$aluguelVestuario = new AluguelVestuario();
						$aluguelVestuario->setAluguel($this->aluguel);
						$aluguelVestuario->setEstoque($estoque);
				    	$aluguelVestuario->setSituacao(2); // 1 = disponivel, 2 = alugado, 3 = devolução atrasada
				    	$listaAluguelVestuarios->add($aluguelVestuario, $i);
			    }
		    }
		     
		    $this->aluguel->setListaAluguelVestuarios($listaAluguelVestuarios);
		    
		    $this->preencheDadosPagamento();
		    $this->aluguel->setPagamento($this->pagamento);
	}
	
	private function preencheDadosPagamento()
	{
		$this->pagamento = new Pagamento();
		$this->pagamento->setTipoPagamento($this->getValueForm("forma_pagamento"));
		$this->pagamento->setNumParcelas($this->getValueForm("qtd_parcelas"));
		$this->pagamento->setValorParcelas($this->getValueForm("valor_parcela"));
		$this->pagamento->setEntrada($this->getValueForm("valor_entrada"));
		$this->pagamento->setFaltaPagar($this->getValueForm("falta_pagar"));
		$this->pagamento->setMulta($this->getValueForm("multa"));
	}
    
	public function inserir()
	{
		$msg = "";
		$url = "";
		$idPagamentoGerado = $this->pagamentoDao->inserir($this->pagamento);
		if($idPagamentoGerado != 0){
			$this->pagamento->setId($idPagamentoGerado);
			$this->aluguel->setPagamento($this->pagamento);
			$idGerado = $this->aluguelDao->inserir($this->aluguel);
			if($idGerado != 0){
				$this->aluguel->setId($idGerado);
				$listaAluguelVestuarios = $this->aluguel->getListaAluguelVestuarios();
				$error = false;
				
			  	foreach($listaAluguelVestuarios->getElements() as $aluguelVestuario){
					$aluguelVestuario->setAluguel($this->aluguel);
					if($this->aluguelVestuarioDao->inserir($aluguelVestuario) == false){
						$msg .= "Erro ao tentar alugar o vestuário Nº: ".$aluguelVestuario->getEstoque()->getCodigoVestuario()." do aluguel  ".$aluguelVestuario->getAluguel()->getId().".<br/>";
						$error = true;
						break;
					} else {
						$msg .= "O vestuário Nº: ". $aluguelVestuario->getEstoque()->getCodigoVestuario() . " foi alugado com sucesso.<br/>";
					}
				}
				if(!$error){
					$this->gravarLog($idGerado);
					//$url = $this->url."?id_aluguel=".$idGerado;
					$id_contrato = $idGerado;
					echo require_once '../view/forms/aluguel/ContratoAluguel.php';
				} else {
					$this->aluguelDao->excluir($idGerado);
					$url = $this->url."?msgError=".$msg;
				}
			} else {
				$msg = "Não foi possivel alugar o(s) vestuário(s).";
				$url = $this->url."?msgError=".$msg;
			}	
		} else {
			$this->pagamentoDao->excluir($idPagamentoGerado);
			$msg = "Não foi possivel registrar o pagamento do aluguel do(s) vestuário(s).";
			$url = $this->url."?msgError=".$msg;
		}
		echo $url;
	}
	
	public function consultarAluguelVestuatioPorIdAluguel($idAluguel)
	{
		$listaAlugueisVestuarios = new ArrayList();
		$estoqueDao = new EstoqueDao();
		$vestuarioDao = new VestuarioDao();
		$result = $this->aluguelVestuarioDao->consultarAluguelVestuatioPorIdAluguel($idAluguel);
		$tamanhoLista = 0;
		
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i = 0; $i < $tamanhoLista; $i++){
					  $dados = $result[$i]->getElements(); 
				 	  
					  $aluguel = new Aluguel();
					  $aluguel->setId($dados[0]);
					  
					  $estoque = $estoqueDao->consultarEstoquePorCodigo($dados[1]);
					  $vestuario = $vestuarioDao->consultarVestuarioPorId($estoque->getVestuario()->getId());
					  $estoque->setVestuario($vestuario);
					  
					  $aluguelVestuario = new AluguelVestuario();
					  $aluguelVestuario->setAluguel($aluguel);
				 	  $aluguelVestuario->setEstoque($estoque);
				 	  $aluguelVestuario->setDataDevolucao($dados[2]);
				 	  $aluguelVestuario->setSituacao($dados[3]);
				 	  
				 	  $listaAlugueisVestuarios->add($aluguelVestuario, $i);
			}
		}
		
		return $listaAlugueisVestuarios;
	}
	
	public function recuperarCodigosVestuarioPorIdAluguel($idAluguel){
		$result = $this->consultarAluguelVestuatioPorIdAluguel($idAluguel);
		$listaAlugueisVestuarios = $result->getElements();
		$codigosVestuarios = "";
		
		foreach ($listaAlugueisVestuarios as $indice => $aluguelVestuario){
			$codigosVestuarios .= $aluguelVestuario->getEstoque()->getCodigoVestuario() . ", ";
		}
		
		return $codigosVestuarios;
	}
	
	public function consultarTodosAlugueis()
	{   
		$listaAlugueis = new ArrayList();
		$result = $this->aluguelDao->consultarTodosAlugueis();
		$tamanhoLista = 0;
		
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i = 0; $i < $tamanhoLista; $i++){
					  $dados = $result[$i]->getElements(); 
				 	  
					  $aluguel = new Aluguel();
					  $cliente = new Cliente();
					  $cliente->setNome($dados[1]);
					  $aluguel->setId($dados[0]);
				 	  $aluguel->setCliente($cliente);
				 	  $aluguel->setValorTotalAluguel($dados[2]);
				 	  $aluguel->setDataLocacao($dados[3]);
				 	  $aluguel->setDataPrevistaDevolucao($dados[4]);
				 	  
				 	  $listaAlugueis->add($aluguel, $i);
			}
		}
		
		return $listaAlugueis;
	}	
	
	public function atualizar()
	{
		if($this->aluguelVestuarioDao->alterar($this->aluguelVestuario) == true){
			//echo 'Aluguel atualizado com sucesso.';
			$this->redirecionaPagina("../view/forms/aluguel/AluguelFilterPesquisa.php");
		} else{
			//echo 'Não foi possivel atualizar o Aluguel.';
			$this->redirecionaPagina("../view/forms/aluguel/AluguelFormCadastrar.php?error&editar&id_aluguel=".$this->aluguelVestuario->getIdAluguel());
		}
	}
	
	public function excluir($idAluguel)
	{
		if($this->aluguelVestuarioDao->excluir(Util::removeTracosPontos($idAluguel))){
			return true;
		} else {
			return false;
		}
	}

	public function consultarAluguelPorId($idAluguel){
		$this->aluguel = $this->aluguelDao->consultarAluguelPorId($idAluguel);
		
		$this->usuarioDao = new UsuarioDao();
		$this->usuario = $this->usuarioDao->consultarUsuarioPorCpf($this->aluguel->getUsuario()->getCpf());
		
		$this->aluguel->setUsuario($this->usuario);
		
		$this->clienteDao = new ClienteDao();
		$this->cliente = $this->clienteDao->consultarClientePorCpf($this->aluguel->getCliente()->getCpf());
		
		$this->aluguel->setCliente($this->cliente);
		
		$this->pagamentoDao = new PagamentoDao();
		$this->pagamento = $this->pagamentoDao->consultarPagamentoPorId($this->aluguel->getPagamento()->getId());
		
		$this->aluguel->setPagamento($this->pagamento);
		
		$listaAluguelVestuario = $this->consultarAluguelVestuatioPorIdAluguel($this->aluguel->getId());
		
		$this->aluguel->setListaAluguelVestuarios($listaAluguelVestuario);
		
		return $this->aluguel;
	}
}

    $request = new Request();
	$operacao = $request->getParameter("operacao");

	if($operacao != null && $operacao != ""){
		$aluguelVestuarioController  = new AluguelVestuarioController();
		if($operacao == "cadastrar"){
			$aluguelVestuarioController->inserir();
		} elseif($operacao == "atualizar"){
			$aluguelVestuarioController->atualizar();
		} elseif($operacao == "excluir"){
			$aluguelVestuarioController->excluir();
		} else{
			$aluguelVestuarioController->redirecionaPagina("javascript:history.go(-1)");
		}
	}

?>