<?php
require_once dirname(__FILE__) . '/../../libloader.php';
require_once dirname(__FILE__) . "/../../config/config.sys.php";

$loginController = new LoginController();

//VARIAVEIS DO CONFIG
if($_HABILITAR_SEGURANCA == true){
	if(!$loginController->usuarioAutenticado()){
			Util::alert("� necess�rio est� autenticado para acessar esta aplica��o.");
			$url = "../login/LoginForm.php"; //dirname(__FILE__)."/../../view/forms/login/LoginForm.php
			Util::redirecionaPaginaJS($url);
	}
}
?>