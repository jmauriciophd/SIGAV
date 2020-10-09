<?php
require_once dirname(__FILE__) . "/../libloader.php";

/**
* Classe que controla os relatorios.
* @author Rafael Dias
*/
class RelatorioController extends AbstractController
{
	private $tipoRelatorio;
	
	/** Construtor da classe */
	function __construct($operacao = "")
	{
		parent::AbstractController($operacao, "relatorios");
		//$this->tipoRelatorio = $this->getValueForm("tipo_relatorio");
	}
	
	public function consultarAluguel(AluguelFilter $aluguelFilter)
	{
		$aluguelDao = new AluguelDao();
		$result = $aluguelDao->consultarAluguel($aluguelFilter);
		
		$aluguelVestuarioController = new AluguelVestuarioController();
		
		$listaAlugueis = new ArrayList();
		$tamanhoLista = 0;
		
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i = 0; $i < $tamanhoLista; $i++){
					$dados = $result[$i]->getElements();

					$aluguel = new Aluguel();
					$cliente = new Cliente();
					$usuario = new Usuario();
					
					$aluguel->setId($dados[0]);
					
					$cliente->setCpf($dados[1]);
					$cliente->setNome($dados[2]);
					
					$usuario->setCpf($dados[3]);
					$usuario->setNome($dados[4]);
					
					$aluguel->setDataLocacao($dados[5]);
					$aluguel->setDataPrevistaDevolucao($dados[6]);
					$aluguel->setValorTotalAluguel($dados[7]);
					
					$aluguel->setCliente($cliente);
					$aluguel->setUsuario($usuario);
								
					$listaAlugueis->add($aluguel, $i);
			}
		}
		
		return $listaAlugueis;
	}
	
}

 	$request = new Request();
	$operacao = $request->getParameter("operacao");

	if($operacao != null && $operacao != ""){
		$relatorioController  = new RelatorioController();
		if($operacao == "gerarRelatorio"){
			$relatorioController->gerarRelatorio();
		}  elseif($operacao == "gerarPDF"){
			$relatorioController->gerarPDF();
		} else{
			$clienteController->redirecionaPagina("javascript:history.go(-1)");
		}
	}

?>