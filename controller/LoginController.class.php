<?php
require_once dirname(__FILE__) . "/../libloader.php";
require_once dirname(__FILE__) . "/../config/config.sys.php";
Util::iniciaSessao();

class LoginController
{
	// DEFININDO VARI�VEIS
	private $usuario;
	private $usuarioDao;
	private $perfilDao;
	public  $msgErro;

	// DEFINIR AS INFORMA��ES DA CLASSE
	public function LoginController() {
	}
	
	// FAZENDO LOGIN DO USUARIO
	public function autenticar($cpf, $senha, $redireciona = true) {
		$this->usuario = new Usuario();
		$this->usuarioDao = new UsuarioDao();
		
		//Consulta o usu�rio
		$this->usuario = $this->usuarioDao->consultarUsuarioPorCpf(addslashes($cpf));
			// Se o usu�rio existir
			if($this->usuario != null && $this->usuario->getCpf() != null){
				if($this->usuario->getSituacao() == 'I'){  //Se o usuario n�o estiver ativo
					$this->msgErro = "A situa��o do usu�rio se encontra INATIVO! Por Favor, contate o Administrador do Sistema.";
					return $this->msgErro;
				} //Se a senha estiver incorreta
				elseif($this->usuario->getSenha() != sha1($senha)){ 
					$this->msgErro = "A senha informada est� incorreta!";
					return $this->msgErro;
				} // Se a senha estiver correta
				else {
					// Coloca as informa��es em sess�es
					session_name("loginUsuario"); //nome da sessao
					$_SESSION['CPF_USUARIO'] = $this->usuario->getCpf();
					$_SESSION['NOME_USUARIO'] = $this->usuario->getNome();
					$_SESSION['EMAIL_USUARIO'] = $this->usuario->getEmail();
 					$_SESSION['SENHA_USUARIO'] = $this->usuario->getSenha();
					$_SESSION['ID_PERFIL_USUARIO'] = $this->usuario->getPerfil()->getId();
					$_SESSION['NOME_PERFIL_USUARIO'] = $this->usuario->getPerfil()->getNome();
    				$_SESSION["ULTIMO_ACESSO"] = date("Y-n-j H:i:s"); 
					
    				//echo "Usuario ".$_SESSION['NOME_USUARIO']." autenticado com sucesso ";
					//Redireciona para a pagina inicial do sistema
					header("Location: ../menu/menu.php");
				}
			} // Se o usu�rio n�o existir
			else{
				$this->msgErro = "N�o foi localizado um usu�rio para o CPF informado.";
				return $this->msgErro;
			}
	}
	
	// VERIFICA SE O USU�RIO EST� LOGADO
	public static function usuarioAutenticado() {
		// Se estiver logado
		if((isset($_SESSION['CPF_USUARIO']) && !empty($_SESSION['CPF_USUARIO'])) 
				&& (isset($_SESSION['SENHA_USUARIO']) && !empty($_SESSION['SENHA_USUARIO']))){
			return true;
		} else{ // Se n�o estiver logado
			return false;
		}
	}
	
	// LOGOUT
	public static function logout($redireciona = false) {
		// Limpa a Sess�o
		$_SESSION = array(); 			 
		// Destroi a Sess�o
		session_destroy();
		// Modifica o ID da Sess�o
		//session_regenerate_id();
		// Se for necess�rio redirecionar
		if ($redireciona):
			header("Location: ../index.php");
			exit;
		endif;
	}
	
	public static function verficaAutenticidadeUsuario(){
		//VARIAVEIS DO CONFIG
		if(HABILITAR_SEGURANCA == true){
			if(!LoginController::usuarioAutenticado()){
					//Util::alert("� necess�rio est� autenticado para acessar esta aplica��o.");
					$url = "../login/LoginForm.php"; //dirname(__FILE__)."/../../view/forms/login/LoginForm.php
					Util::redirecionaPaginaJS($url);
			} else if(LoginController::sessaoExpirada()){
					$url = "../login/LoginForm.php?session_expired";
					Util::redirecionaPaginaJS($url);
			}
		}
	}
	
	public static function sessaoExpirada(){
	    $dataSalva = $_SESSION["ULTIMO_ACESSO"]; 
	    $agora = date("Y-n-j H:i:s"); 
	    $tempo_transcorrido = (strtotime($agora)-strtotime($dataSalva)); 
	    if($tempo_transcorrido >= (TEMPO_SESSAO * 60)) { 
		      LoginController::logout();
		      return true;
	    }else {
	    	  $_SESSION["ULTIMO_ACESSO"] = $agora; 
	    	  return false;
	    } 
	}
	
}
?>