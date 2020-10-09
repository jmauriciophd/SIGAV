<?php
require_once dirname(__FILE__) . "/../libloader.php";

/**
* Classe que controla acoes do usuario.
* @author Rafael Dias
*/
class UsuarioController extends AbstractController
{
	private $usuario = null;
	private $perfil = null;
	private $usuarioDao = null;
	
	/** Construtor da classe */
	function __construct($operacao = "")
	{
		parent::AbstractController($operacao, "tb_usuario");
		$this->usuarioDao = new UsuarioDao();
		$this->preencheDadosUsuario();
	}
	
	private function preencheDadosUsuario()
	{
		$senha = $this->getValueForm("senha");
		$senhaCriptografada = sha1($senha);
		
		$this->perfil = new Perfil();
		$this->perfil->setId($this->getValueForm("perfil"));

		$this->usuario = new Usuario();
		$this->usuario->setCpf(Util::removeTracosPontos($this->getValueForm("cpf")));
		$this->usuario->setNome($this->getValueForm("nome"));
		$this->usuario->setEmail($this->getValueForm("email"));
		$this->usuario->setSituacao($this->getValueForm("situacao"));
		$this->usuario->setSenha($senhaCriptografada);
		$this->usuario->setPerfil($this->perfil);
	}
	
	/**
	* Retorna o valor da propriedade $Usuario.
	* @access public
	* @return Usuario
	*/
	public function getUsuario()
	{
		return $this->usuario;
	}
	
	public function inserir()
	{
		if($this->usuarioDao->inserir($this->usuario) == true){
			$this->gravarLog($this->usuario->getCpf());
		   	$this->url = $this->url."?sucess&editar&cpf=".$this->usuario->getCpf();
		} else{
			$this->url = $this->url."?error";
		}
		echo $this->url;
	}
	
	public function atualizar()
	{
		if($this->usuarioDao->alterar($this->usuario) == true){
			$this->gravarLog($this->usuario->getCpf());
			$this->url = $this->url."?sucessUpdate&editar&cpf=".$this->usuario->getCpf();
		} else{
			$this->url = $this->url."?errorUpdate";
		}
		echo $this->url;
	}
	
	public function excluir()
	{
		if($this->usuarioDao->excluir(Util::removeTracosPontos($this->usuario->getCpf()))){
			$this->gravarLog($this->usuario->getCpf());
			$this->url = $this->url."?sucessDelete";
		} else{
			$this->url = $this->url."?errorUpdate&editar&cpf=".$this->usuario->getCpf();
		}
		echo $this->url;
	}
	
	public function consultarUsuarioPorCpf($cpf)
	{
		return $this->usuarioDao->consultarUsuarioPorCpf($cpf);
	}

	public function consultarUsuarioPorCpfEmail($cpf, $email)
	{
		return $this->usuarioDao->consultarUsuarioPorCpfEmail($cpf, $email);
	}
	
	public function consultarTodosUsuarios()
	{
		$listaUsuario = new ArrayList();
		$result = $this->usuarioDao->consultarTodosUsuarios();
		$tamanhoLista = 0;
		
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i = 0; $i < $tamanhoLista; $i++){
					  $dados = $result[$i]->getElements();
				 	  
					  $usuario = new Usuario();	 
					  $perfil = new Perfil();
					  
					  $usuario->setCpf($dados[0]);
				 	  $usuario->setNome($dados[1]);
				 	  $perfil->setNome($dados[3]);
				 	  $situacao = ($dados[2] == 'A') ? "ATIVO" : "INATIVO";
				 	  $usuario->setSituacao($situacao);
				 	  $usuario->setPerfil($perfil);
				 	  $listaUsuario->add($usuario, $i);
			}
		}
		
		return $listaUsuario;
	}
	
	public function alterarSenha(){
		 if(sha1($this->getValueForm("senha_atual")) == $_SESSION["SENHA_USUARIO"]){
		 	$this->usuario->setCpf($_SESSION["CPF_USUARIO"]);
		 	if($this->usuarioDao->alterarSenha($this->usuario)){
		 		$this->url = $this->url . "?sucessUpdate";
		 		$_SESSION["SENHA_USUARIO"] = $this->usuario->getSenha();
		 	} else{
		 		$this->url = $this->url . "?errorUpdate";
		 	}
		 } else {
		 	$msg = "Senha atual inválida!";
		 	$this->url = $this->url . "?msgError=".$msg;
		 }
		 echo $this->url;		 
	}
	
	public function recuperarSenha(){
		 $this->usuario->setCpf(Util::removeTracosPontos($this->getValueForm("cpf_usuario")));
		 $usuario = $this->consultarUsuarioPorCpfEmail($this->usuario->getCpf(), $this->usuario->getEmail());
		 
		 if($usuario != null && $usuario->getCpf() != null && $usuario->getEmail()){
		 	$this->usuario = $usuario;
		 	if($this->resetarSenha()){
			 	$msg = "Uma nova senha foi enviada para o e-mail ". strtolower($usuario->getEmail()).".";
			 	$this->url = "../view/forms/login/LoginForm.php?msgSucess=".$msg;
		 	} else {
		 		$this->usuarioDao->alterarSenha($usuario);
		 		$msg = "Ocorreu um erro ao gerar uma nova senha e envia-lá por e-mail!";
		 		$this->url = "../view/forms/login/LoginForm.php?msgError=".$msg;
		 	}
		 } else {
		 	$msg = "CPF e/ou E-mail não encontrado na base de dados do SIGAV!";
		 	$this->url = "../view/forms/login/LoginForm.php?msgError=".$msg;
		 }
		
		 $this->redirecionaPagina($this->url);		 
	}
	
	public function resetarSenha(){
		$novaSenha = Util::gerarSenha();
		$this->usuario->setSenha(sha1($novaSenha));
	 	if($this->usuarioDao->alterarSenha($this->usuario)){
	 		$mensagem = "<p>Prezado(a) usuário(a) ".$this->usuario->getNome().", <p/>";
	 		$mensagem .= "Sua nova senha para acessar o SIGAV é ". $novaSenha ."<br/>";
	 		$mensagem .= "Qualquer dúvida entre em contato com o administrador do sistema.<br/>";
	 		$resp = Util::enviarEmail(strtolower($this->usuario->getEmail()), $this->usuario->getNome(), "Nova Senha de Acesso ao SIGAV", $mensagem);
	 		return $resp;
	 	} else {
	 		return false;
	 	}
	}
}

    $request = new Request();
	$operacao = $request->getParameter("operacao");
	
	if($operacao != null || $operacao != ""){
		$usuarioController  = new UsuarioController();
		if($operacao == "cadastrar"){
			$usuarioController->inserir();
		} elseif ($operacao == "atualizar"){
			$usuarioController->atualizar();
		} elseif ($operacao == "excluir"){
			$usuarioController->excluir();
		} elseif ($operacao == "pesquisar"){
			$usuarioController->pesquisar();
		}  elseif ($operacao == "alterarSenha"){
			$usuarioController->alterarSenha();
		} elseif ($operacao == "recuperarSenha"){
			$usuarioController->recuperarSenha();
		} elseif($operacao == "verificarCpf"){
			$usuario = $usuarioController->consultarUsuarioPorCpf($request->getParameter("cpf"));
			if($usuario->getCpf() != null && $usuario->getCpf() != ""){
       			echo "../usuario/UsuarioFormCadastrar.php?editar&cpf=".$usuario->getCpf();
			}
		} else{
			$usuarioController->redirecionaPagina("javascript:history.go(-1)");
		}
	}
?>