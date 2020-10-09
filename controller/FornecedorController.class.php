<?php
require_once dirname(__FILE__) . "/../libloader.php";

/**
* Classe que controla as ações do usuario.
* @author Rafael Dias e Jos� Mauricio
*/
class FornecedorController extends AbstractController
{
	private $fornecedorDao = null;
	private $fornecedor = null;
	private $endereco = null;
	private $contato = null;
	
	/** Construtor da classe */
	function __construct($operacao = "")
	{
		parent::AbstractController($operacao, "tb_fornecedor");
		$this->fornecedorDao = new FornecedorDao();
		$this->preencheDadosFornecedor();
	}
	
	private function preencheDadosFornecedor()
	{
		//obtem os valores vindo do formulario via post ou get
		$cnpj=Util::removeTracosPontos($this->getValueForm("cnpj"));
		$razaoSocial=$this->getValueForm("razao_social");
		$nomeFantasia=$this->getValueForm("nome_fantasia");
		$inscricaoEstadual=$this->getValueForm("inscricao_estadual");
		
		//retira aspas duplas e simples
		$cnpj = preg_replace('/(\'|")/', '', $cnpj);
		//cria um novo objeto Fornecedor
		$this->fornecedor= new Fornecedor();
		$this->fornecedor->setCnpj($cnpj);
		$this->fornecedor->setRazaoSocial($razaoSocial);
		$this->fornecedor->setNomeFantasia($nomeFantasia);
		$this->fornecedor->setInscricaoEstadual($inscricaoEstadual);
		
		$this->preencheDadosEndereco();
		$this->fornecedor->setEndereco($this->endereco);
		
		$this->preencheDadosContato();
		$this->fornecedor->setContato($this->contato);
	
	}
	
	private function preencheDadosEndereco()
	{
	    $this->endereco = new Endereco();
		$this->endereco->setCpfCnpj($this->fornecedor->getCnpj());
		$cep       =Util::removeTracosPontos($this->getValueForm("cep"));
		$endereco  =$this->getValueForm("endereco");
		$bairro    =$this->getValueForm("bairro");
		$numero    =$this->getValueForm("numero");
		$cidade    =$this->getValueForm("cidade");
		$estado    =$this->getValueForm("estado");
		$complemento=$this->getValueForm("complemento");
		
		$this->endereco->setCep($cep);
		$this->endereco->setLogradouro($endereco);
		$this->endereco->setBairro($bairro);
		$this->endereco->setNumero($numero);
		$this->endereco->setCidade($cidade);
        $this->endereco->setEstado($estado);
		$this->endereco->setComplemento($complemento);
	
	}
	
	private function preencheDadosContato()
	{
		$this->contato = new Contato();
		$this->contato->setCpfCnpj($this->fornecedor->getCnpj());
		$this->contato->setEmail($this->getValueForm("email"));
		$this->contato->setTelComercial($this->getValueForm("tel_comercial"));
		}
	
	/**
	* Retorna o valor da propriedade $fornecedor.
	* @access public
	* @return Fornecedor
	*/
	public function getFornecedor()
	{
		return $this->fornecedor;
	}
	
    public function inserir()
	{
		if($this->fornecedorDao->inserir($this->fornecedor) == true){
			$this->gravarLog($this->fornecedor->getCnpj());
			$this->url = $this->url."../fornecedor/FornecedorFormCadastrar.php?sucess&editar&cnpj=".$this->fornecedor->getCnpj();
		} else{
			$this->url = $this->url. "../fornecedor/FornecedorFormCadastrar.php?error";
		}
	
		echo $this->url;
	}
	
	public function consultarFornecedorPorCnpj($cnpj)
	{
		return $this->fornecedorDao->consultarFornecedorPorCnpj($cnpj);
	}
	
	public function consultarTodosFornecedores()
	{
        $listaFornecedor = new ArrayList();
		$result = $this->fornecedorDao->consultarTodosFornecedores();
		$tamanhoLista = 0;
		
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i = 0; $i < $tamanhoLista; $i++){
					  $dados = $result[$i]->getElements();

					$fornecedor = new Fornecedor();
					$endereco   = new Endereco();
					$contato    = new Contato();
					
					$fornecedor->setCnpj($dados[0]);
					$fornecedor->setRazaoSocial($dados[1]);
					$fornecedor->setNomeFantasia($dados[2]);
					$fornecedor->setInscricaoEstadual($dados[3]);
					
					$endereco->setCpfCnpj($dados[0]);
					$endereco->setCep($dados[4]);
					$endereco->setLogradouro($dados[5]);
					$endereco->setBairro($dados[6]);
					$endereco->setNumero($dados[7]);
					$endereco->setCidade($dados[8]);
					$endereco->setEstado($dados[9]);
					$endereco->setComplemento($dados[10]);
					
					$contato->setCpfCnpj($dados[0]);
					$contato->setEmail($dados[11]);
					$contato->setTelComercial($dados[12]);
					
		
					$fornecedor->setContato($contato);
				    $fornecedor->setEndereco($endereco);
					$listaFornecedor->add($fornecedor, $i);
			}
			
		}
		
		return $listaFornecedor;
	}	

	public function atualizar()
	{
		if($this->fornecedorDao->alterar($this->fornecedor) == true){
			$this->gravarLog($this->fornecedor->getCnpj());
			$this->url = $this->url."?sucessUpdate&editar&cnpj=" . $this->fornecedor->getCnpj();
		} else {
			$this->url = $this->url."?errorUpdate";
		}
		
		echo $this->url;
	}
	
	public function excluir()
	{
		if($this->fornecedorDao->excluir(Util::removeTracosPontos($this->fornecedor->getCnpj()))){
			$this->gravarLog($this->fornecedor->getCnpj());
			$this->url = $this->url."?sucessDelete";
		} else {
			$this->url = $this->url."?errorUpdate&editar&cnpj=".$this->fornecedor->getCnpj();
		}
		
		echo $this->url;
	}
	
	public function carregarComboFornecedor($valor = ""){
		$listaFornecedor = $this->consultarTodosFornecedores();
		$selectDinamico = "<option value='' selected='selected'>Selecione um fornecedor</option>";
		
		if($listaFornecedor == null || $listaFornecedor->getSize() <= 0){
		    $selectDinamico .= "<option value=''>Nenhuma fornecedor cadastrado.</option>";
		} else {
			foreach ($listaFornecedor->getElements() as $indice => $fornecedor){
			    $selectDinamico .= "<option value='" . $fornecedor->getCnpj() . "' " . Util::selecionar($fornecedor->getCnpj(), $valor) . " >" . $fornecedor->getNomeFantasia() . "</option>";
			}
		}
		
		return $selectDinamico;
	}
	
}
    $request = new Request();
	$operacao = $request->getParameter("operacao");

	if($operacao != null && $operacao != ""){
		$fornecedorController  = new FornecedorController();
		if($operacao == "cadastrar"){
			$fornecedorController->inserir();
		}  elseif($operacao == "atualizar"){
			$fornecedorController->atualizar();
		} elseif($operacao == "excluir"){
			$fornecedorController->excluir();
		} elseif($operacao == "verificarCnpj"){
			$fornecedor = $fornecedorController->consultarFornecedorPorCnpj($request->getParameter("cnpj"));
			if($fornecedor->getCnpj() != null && $fornecedoor->getCnpj() != ""){
       			echo "../fornecedor/FornecedorFormCadastrar.php?editar&cnpj=".$fornecedor->getCnpj();
			}
		}
		 else{
			$fornecedorController->redirecionaPagina("javascript:history.go(-1)");
		}
	}

?>