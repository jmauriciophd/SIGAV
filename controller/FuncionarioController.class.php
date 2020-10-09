<?php
require_once dirname(__FILE__) . "/../libloader.php";

/**
* Classe que controla as aÃ§Ãµes do usuario.
* @author Rafael Dias
*/
class FuncionarioController extends AbstractController
{
	private $funcionarioDao = null;
	private $funcionario = null;
	private $usuarioDao = null;
	private $usuario = null;
	private $endereco = null;
	private $contato = null;
	
	/** Construtor da classe */
	function __construct($operacao = "")
	{
		parent::AbstractController($operacao, "tb_funcionario");
		$this->funcionarioDao = new FuncionarioDao();
		$this->usuarioDao = new UsuarioDao();
		if($this->getOperacao() != null && $this->getOperacao() != "")
			$this->preencheDadosFuncionario();
	}
	
	private function preencheDadosFuncionario()
	{
		$this->funcionario = new Funcionario();
		$this->funcionario->setCpf(Util::removeTracosPontos($this->getValueForm("cpf")));
		$this->funcionario->setNome($this->getValueForm("nome"));
		$this->funcionario->setRg($this->getValueForm("rg"));
		$this->funcionario->setOrgaoExpedicao($this->getValueForm("orgao_expeditor"));
		$this->funcionario->setUfExpedicao($this->getValueForm("uf_orgao_expeditor"));
		$this->funcionario->setEstadoCivil($this->getValueForm("estado_civil"));
		$this->funcionario->setDataNascimento(Util::formataDataMysql($this->getValueForm("data_nascimento")));
		$this->funcionario->setSexo($this->getValueForm("sexo"));
		$this->funcionario->setGrauInstrucao($this->getValueForm("grau_instrucao"));
		$this->funcionario->setCtps($this->getValueForm("ctps"));
		$this->funcionario->setNumeroSerie($this->getValueForm("num_serie"));
		$this->funcionario->setCargo($this->getValueForm("cargo"));
		$this->funcionario->setDataAdmissao(Util::formataDataMysql($this->getValueForm("data_admissao")));
		$this->funcionario->setSalarioLiquido(Util::moeda($this->getValueForm("salario")));
		$this->funcionario->setComissao($this->getValueForm("comissao"));
		$this->funcionario->setDataDemissao(Util::formataDataMysql($this->getValueForm("data_demissao")));
		if(isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "")
			$this->funcionario->setFoto($_FILES['foto']['name']);
		
		$this->preencheDadosEndereco();
		$this->funcionario->setEndereco($this->endereco);
		$this->preencheDadosContato();
		$this->funcionario->setContato($this->contato);
		
	}
	
	private function preencheDadosUsuario()
	{
		$senha = $this->getValueForm("senha");
		$senhaCriptografada = sha1($senha);
		
		$perfil = new Perfil();
		$perfil->setId($this->getValueForm("perfil"));

		$this->usuario = new Usuario();
		$this->usuario->setCpf($this->funcionario->getCpf());
		$this->usuario->setNome($this->funcionario->getNome());
		$this->usuario->setEmail($this->funcionario->getContato()->getEmail());
		$this->usuario->setSituacao("A");
		$this->usuario->setSenha($senhaCriptografada);
		$this->usuario->setPerfil($perfil);
	}
	
	private function preencheDadosEndereco()
	{
		$this->endereco = new Endereco();
		$this->endereco->setCpfCnpj($this->funcionario->getCpf());
		$this->endereco->setCep(Util::removeTracosPontos($this->getValueForm("cep")));
		$this->endereco->setLogradouro($this->getValueForm("endereco"));
		$this->endereco->setBairro($this->getValueForm("bairro"));
		$this->endereco->setNumero($this->getValueForm("numero"));
		$this->endereco->setComplemento($this->getValueForm("complemento"));
		$this->endereco->setCidade($this->getValueForm("cidade"));
		$this->endereco->setEstado($this->getValueForm("estado"));
	}
	
	private function preencheDadosContato()
	{
		$this->contato = new Contato();
		$this->contato->setCpfCnpj($this->funcionario->getCpf());
		$this->contato->setEmail($this->getValueForm("email"));
		$this->contato->setTelResidencial($this->getValueForm("tel_residencial"));
		$this->contato->setTelCelular($this->getValueForm("tel_celular"));
		$this->contato->setTelComercial($this->getValueForm("tel_celular2"));
	}
	
	/**
	* Retorna o valor da propriedade $funcionario.
	* @access public
	* @return Funcionario
	*/
	public function getFuncionario()
	{
		return $this->funcionario;
	}
	
	public function consultarFuncionarioPorCpf($cpf)
	{
		return $this->funcionarioDao->consultarFuncionarioPorCpf($cpf);
	}
	
	public function inserir()
	{
		if($this->funcionarioDao->inserir($this->funcionario) == true){
			$this->gravarLog($this->funcionario->getCpf());
			$this->url = $this->url."?sucess&editar&cpf=".$this->funcionario->getCpf();
		} else{
			$this->url = $this->url."?error";
		}
		echo $this->url;
	}	
	
	public function atualizar()
	{
		if($this->funcionarioDao->alterar($this->funcionario) == true){
			$this->gravarLog($this->fornecedor->getCpf());
			$this->url = $this->url."?sucessUpdate&editar&cpf=" . $this->funcionario->getCpf();
		} else {
			$this->url = $this->url."?errorUpdate&editar&cpf=" . $this->funcionario->getCpf();
		}
		echo $this->url;
	}
	
	public function excluir()
	{		
		if($this->funcionarioDao->excluir($this->funcionario->getCpf())){
			$this->gravarLog($this->fornecedor->getCpf());
			$this->url = $this->url."?sucessDelete";
		} else {
			$this->url = $this->url."?errorDelete";
		}
		echo $this->url;
	}
	
	public function consultarTodosFuncionarios()
	{
		$listaFuncionario = new ArrayList();
		$result = $this->funcionarioDao->consultarTodosFuncionarios();
		$tamanhoLista = 0;
		
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i = 0; $i < $tamanhoLista; $i++){
			  $dados = $result[$i]->getElements();
		         
		    $funcionario = new Funcionario();
	        $contato     = new Contato();
		    $endereco    = new Endereco();

		    $funcionario->setCpf($dados[0]);
			$funcionario->setRg($dados[1]);
			$funcionario->setNome($dados[2]);
			$funcionario->setDataNascimento($dados[3]);
			$funcionario->setCargo($dados[4]);
			$funcionario->setCtps($dados[5]);
			$funcionario->setComissao($dados[6]);
			$funcionario->setSalarioLiquido($dados[7]);
			$funcionario->setDataAdmissao($dados[8]);
			$funcionario->setDataDemissao($dados[9]);
			$funcionario->setPossuiUsuario($dados[10]);
			$funcionario->setOrgaoExpedicao($dados[11]);
			$funcionario->setUfExpedicao($dados[12]);
			
			$endereco->setCpfCnpj($dados[0]);
			$endereco->setCep($dados[13]);
			$endereco->setLogradouro($dados[14]);
			$endereco->setNumero($dados[15]);
			$endereco->setCidade($dados[16]);
			$endereco->setEstado($dados[17]);
						
			$contato->setCpfCnpj($dados[0]);
			$contato->setEmail($dados[18]);
			$contato->setTelCelular($dados[19]);
			$contato->setTelComercial($dados[20]);
			$contato->setTwitter($dados[21]);
			$contato->setFacebook($dados[22]);
			
			$funcionario->setContato($contato);
		    $funcionario->setEndereco($endereco);
		    $listaFuncionario->add($funcionario, $i);    
	
	  }	
     }
     	 return $listaFuncionario; 
    }

	public function funcionarioCpfJaExiste($cpf){
        $funcionario = $this->funcionarioDao->consultarFuncionarioPorCpf($cpf);
        if($funcionario != null && $funcionario->getCpf() == $cpf){
        	return true;
        } else {
        	return false;
        }
	}
	
    public function carregarComboFuncionario($valor = ""){
		$listaFuncionario = $this->consultarTodosFuncionarios();
		$selectDinamico = "<option value='' selected='selected'>Selecione um Funcionario</option>";
		
		if($listaFuncionario == null || $listaFuncionario->getSize() <= 0){
		    $selectDinamico .= "<option value=''>Nenhum Funcionario cadastrado.</option>";
		} else {
			foreach ($listaFuncionario->getElements() as $indice => $funcionario){
			    $selectDinamico .= "<option value='" . $funcionario->getCpf() . "' " . Util::selecionar($funcionario->getCpf(), $valor) . " >" . $funcionario->getNome() . "</option>";
			}
		}
		
		return $selectDinamico;
	}
	
	public function carregarFoto(){	
		//carrega foto
		$pasta = "../view/forms/funcionario/fotos/";
		/* formatos de imagem permitidos */
		$permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp");
		
			$nome_imagem    = $_FILES['foto']['name']; 
			$tamanho_imagem = $_FILES['foto']['size'];	
			
			/* pega a extensão do arquivo */
			$ext = strtolower(strrchr($nome_imagem,"."));
			
			/*  verifica se a extensão está entre as extensões permitidas */
			if(in_array($ext,$permitidos)){
				/* converte o tamanho para KB */
				$tamanho = round($tamanho_imagem / 1024);
				if($tamanho < 1024){ //se imagem for até 1MB envia
					//$nome_atual = md5(uniqid(time())).$ext; //nome que dará a imagem
					$tmp = $_FILES['foto']['tmp_name']; //caminho temporário da imagem
					/* se enviar a foto, insere o nome da foto no banco de dados */
					if(move_uploaded_file($tmp,$pasta.$nome_imagem))
						echo "<img src='fotos/".$nome_imagem."' width='100px;' height='100px;' id='previsualizar'>"; //imprime a foto na tela
					else
						echo "Falha ao enviar a foto";
				} else{
					echo "A imagem deve ser de no máximo 1MB";
				}
			} else{
				echo "Somente são <br/>aceitos arquivos<br/> do tipo Imagem";
			}
		}
}

    $request = new Request();
	$operacao = $request->getParameter("operacao");

	if($operacao != null && $operacao != ""){
		$funcionarioController  = new FuncionarioController();
		if($operacao == "cadastrar"){
			$funcionarioController->inserir();
		}  elseif($operacao == "atualizar"){
			$funcionarioController->atualizar();
		} elseif($operacao == "excluir"){
			$funcionarioController->excluir();
		} elseif ($operacao == "upload"){
			$funcionarioController->carregarFoto();
		} elseif($operacao == "verificarCpf"){
			$funcionario = $funcionarioController->consultarFuncionarioPorCpf($request->getParameter("cpf"));
			if($funcionario->getCpf() != null && $funcionario->getCpf() != ""){
       			echo "../funcionario/FuncionarioFormCadastrar.php?editar&cpf=".$funcionario->getCpf();
			}
		} else{
			$funcionarioController->redirecionaPagina("javascript:history.go(-1)");
		}
	}

?>