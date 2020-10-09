<?php
require_once dirname(__FILE__) . "/../libloader.php";

/**
* Classe que controla as ações do usuario.
* @author Rafael Dias
*/
class ClienteController extends AbstractController
{
	private $clienteDao = null;
	private $medidasDao = null;
	private $cliente = null;
	private $endereco = null;
	private $contato = null;
	private $medidas = null;
	
	/** Construtor da classe */
	function __construct($operacao = "")
	{
		parent::AbstractController($operacao, "tb_cliente");
		$this->medidasDao = new MedidasDao();
		$this->clienteDao = new ClienteDao();
		$this->preencheDadosCliente();
	}
	
	private function preencheDadosCliente()
	{
		//obtem os valores vindo do formulario via post ou get
		$cpf  = Util::removeTracosPontos($this->getValueForm("cpf"));
		$rg   = $this->getValueForm("rg");
		$nome = $this->getValueForm("nome");
		$estadoCivil=$this->getValueForm("estado_civil");
		$dataNacimento= Util::formataDataMysql($this->getValueForm("data_nascimento"));
		$sexo =$this->getValueForm("sexo");
		$orgaoEspeditor  =$this->getValueForm("orgao_expeditor");
		$ufExpeditor=$this->getValueForm("uf_orgao_expeditor");
		$medidas = $this->getValueForm("medidas");	
		//retira aspas duplas e simples
		$cpf = preg_replace('/(\'|")/', '', $cpf);
		//cria um novo objeto Cliente
		$this->cliente = new Cliente();
		$this->cliente->setCpf($cpf);
		$this->cliente->setRg($rg);
		$this->cliente->setNome($nome);
		$this->cliente->setEstadoCivil($estadoCivil);
		$this->cliente->setDataNascimento($dataNacimento);
		$this->cliente->setSexo($sexo);
		$this->cliente->setOrgaoExpedicao($orgaoEspeditor);
		$this->cliente->setUfExpedicao($ufExpeditor);
		
		$this->preencheDadosEndereco(); 
		$this->cliente->setEndereco($this->endereco);
		
		$this->preencheDadosContato();
		$this->cliente->setContato($this->contato);
		
		$this->preencheDadosMedida();
		$this->cliente->setMedidas($this->medidas);
	}
	
	private function preencheDadosEndereco()
	{
		$this->endereco = new Endereco();
		$this->endereco->setCpfCnpj($this->cliente->getCpf());
		$cep       =Util::removeTracosPontos($this->getValueForm("cep"));
		$endereco  =$this->getValueForm("endereco");
		$bairro    =$this->getValueForm("bairro");
		$numero    =$this->getValueForm("numero");
		$complemento=$this->getValueForm("complemento");
		$cidade    =$this->getValueForm("cidade");
		$estado    =$this->getValueForm("estado");
		
		$this->endereco->setCep($cep);
		$this->endereco->setLogradouro($endereco);
		$this->endereco->setBairro($bairro);
		$this->endereco->setNumero($numero);
		$this->endereco->setComplemento($complemento);
		$this->endereco->setCidade($cidade);
        $this->endereco->setEstado($estado);
	}
	
	private function preencheDadosContato()
	{
		$this->contato = new Contato();
		$this->contato->setCpfCnpj($this->cliente->getCpf());
		$email         = $this->getValueForm("email");
		$telResidencial=$this->getValueForm("tel_residencial");
		$telCelular    =$this->getValueForm("tel_celular");
		$twitter       =$this->getValueForm("twitter");
		$facebook      =$this->getValueForm("facebook");
		
		$this->contato->setEmail($email);
		$this->contato->setTelResidencial($telResidencial);
		$this->contato->setTelCelular($telCelular);
		$this->contato->setTwitter($twitter);
		$this->contato->setFacebook($facebook);
	}
		
	private function preencheDadosMedida()
	{
		$this->medidas = new Medidas();
		$this->medidas->setId($this->getValueForm("id_medidas"));
		$this->medidas->setTamanho($this->getValueForm("tamanho"));
		$this->medidas->setBustoTorax($this->getValueForm("busto_torax"));
		$this->medidas->setCintura($this->getValueForm("cintura"));
		$this->medidas->setQuadril($this->getValueForm("quadril"));
		$this->medidas->setAlturaFrente($this->getValueForm("altura_frente"));
		$this->medidas->setOmbro($this->getValueForm("ombro"));
		$this->medidas->setCostas($this->getValueForm("costas"));
		$this->medidas->setBraco($this->getValueForm("braco"));
		$this->medidas->setObservacao($this->getValueForm("observacao"));
	}
	
	public function getCliente()
	{
		return $this->cliente;
	}
	
	public function inserir()
	{
		$idGerado = $this->medidasDao->inserir($this->medidas);
		
		if($idGerado != 0){
			$this->medidas->setId($idGerado);
			$this->cliente->setMedidas($this->medidas);
			
			if($this->clienteDao->inserir($this->cliente) == true){
				$this->gravarLog($this->cliente->getCpf());
				$url = "../cliente/ClienteFormCadastrar.php?sucess&editar&cpf=".$this->cliente->getCpf();
			} else {
				$this->medidasDao->excluir($idGerado);
				$url = "../cliente/ClienteFormCadastrar.php?error";
			}
		} else {
			$msg = "N&atilde;o foi poss&itilde;vel cadastrar as medidas do cliente";
			$url = "../cliente/ClienteFormCadastrar.php?msgError=".$msg;
		}
		
		echo $url;
	}
	
	public function consultarClientePorCpf($cpf)
	{
		return $this->clienteDao->consultarClientePorCpf($cpf);
	}
	
	public function consultarClientePorCpfLike($cpf)
	{
		return $this->clienteDao->consultarClientePorCpfLike(Util::removeTracosPontos($cpf));
	}
	
	public function consultarTodosClientes()
	{
	    $listaCliente = new ArrayList();
		$result = $this->clienteDao->consultarTodosClientes();
		$tamanhoLista = 0;
		
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i = 0; $i < $tamanhoLista; $i++){
					$dados = $result[$i]->getElements();

					$cliente =new Cliente();
					$endereco=new Endereco();
					$contato =new Contato();
					
					$cliente->setCpf($dados[0]);
					$cliente->setRg($dados[1]);
					$cliente->setNome($dados[2]);
					$cliente->setEstadoCivil($dados[3]);
					$cliente->setDataNascimento($dados[4]);
					$cliente->setSexo($dados[5]);
					$cliente->setOrgaoExpedicao($dados[6]);
					$cliente->setUfExpedicao($dados[7]);
								
					$endereco->setCpfCnpj($dados[0]);
					$endereco->setCep($dados[8]);
					$endereco->setLogradouro($dados[9]);
					$endereco->setBairro($dados[10]);
					$endereco->setNumero($dados[11]);
					$endereco->setComplemento($dados[12]);
					$endereco->setCidade($dados[13]);
					$endereco->setEstado($dados[14]);
					
					$contato->setCpfCnpj($dados[0]);
					$contato->setEmail($dados[15]);
					$contato->setTelCelular($dados[16]);
					$contato->setTelResidencial($dados[17]);
					$contato->setTwitter($dados[18]);
					$contato->setFacebook($dados[19]);

					$cliente->setContato($contato);
		            $cliente->setEndereco($endereco);
					$listaCliente->add($cliente, $i);
			}
			
		}
		
		return $listaCliente;
	}	
	
	public function atualizar()
	{
		if($this->medidasDao->alterar($this->medidas) == true){
			if($this->clienteDao->alterar($this->cliente) == true){
				$this->gravarLog($this->cliente->getCpf());
				$this->url = $this->url."?sucessUpdate&editar&cpf=" . $this->cliente->getCpf();
			} else {
				$this->url = $this->url."?errorUpdate&editar&cpf=" . $this->cliente->getCpf();
			}
		} else {
			$msg = "N&atilde;o foi poss&itilde;vel atualizar as medidas do cliente";
			$this->url = $this->url."?msgError=".$msg."&editar&cpf=" . $this->cliente->getCpf();
		}
		
		echo $this->url;
	}
	
	public function excluir()
	{
		if($this->clienteDao->excluir($this->cliente->getCpf())){
			$this->gravarLog($this->cliente->getCpf());
			$this->url = $this->url."?sucessDelete";
		} else {
			$this->url = $this->url."?errorDelete";
		}
		
		echo $this->url;
	}

}	
	
    $request = new Request();
	$operacao = $request->getParameter("operacao");

	if($operacao != null && $operacao != ""){
		$clienteController  = new ClienteController();
		if($operacao == "cadastrar"){
			$clienteController->inserir();
		}  elseif($operacao == "atualizar"){
			$clienteController->atualizar();
		} elseif($operacao == "excluir"){
			$clienteController->excluir();
		} elseif($operacao == "exibirDadosCliente"){
			$cliente = $clienteController->consultarClientePorCpf($request->getParameter("cpf"));
			echo $cliente->getNome() . "," . $cliente->getRg() . ", " . $cliente->getOrgaoExpedicao() . "/" . $cliente->getUfExpedicao() . "," . $cliente->getEndereco()->getLogradouro() . " - " . $cliente->getEndereco()->getCidade() . "/" . $cliente->getEndereco()->getEstado() . "," . $cliente->getContato()->getTelResidencial() . "," . $cliente->getContato()->getEmail();
		} elseif($operacao == "buscarCpfCliente"){
			$query = $clienteController->consultarClientePorCpfLike($request->getParameter("q"));
			while ($result = mysql_fetch_array($query)) {
       			echo $result[0]."\n";
       		}
		} elseif($operacao == "verificarCpf"){
			$cliente = $clienteController->consultarClientePorCpf($request->getParameter("cpf"));
			if($cliente->getCpf() != null && $cliente->getCpf() != ""){
       			echo "../cliente/ClienteFormCadastrar.php?editar&cpf=".$cliente->getCpf();
			}
		} else{
			$clienteController->redirecionaPagina("javascript:history.go(-1)");
		}
	}
	
?>