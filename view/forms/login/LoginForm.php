<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SIGAV - Sistema Gestor de Aluguel de Vestuário</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link  rel="stylesheet" type="text/css" href="../../css/login.css"/>
<link  rel="stylesheet" type="text/css" href="../../css/modal.css"/>
<script type="text/javascript" src="../../js/jquery/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery.validacao.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="../../js/mascaras.js"></script>
<script type="text/javascript" src="../../js/validacao.campos.js"></script>
<script type="text/javascript" src="../../js/funcoes.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#email").val(" ");  
});
</script>
</head>
<body>
<?php 
require_once '../../../libloader.php';
if(isset($_POST['operacao'])){
	$loginController = new LoginController();
	$msg = $loginController->autenticar(Util::removeTracosPontos($_POST['cpf']), $_POST['senha'], true); 
}
?>
<div id="corpo_pagina">
<div id="topo">
	<div class="nomeSistemaSigav">SIGAV - Sistema Gestor de Aluguel de Vestuário</div>
</div>
	<div id="menu_horizontal">
		<div id="centro_menu"></div>
	</div><br />
	<div id="msgCampoObrigatorio" style="display: none;">
		<img src="../../img/stop.png" alt="Mensagem de Erro" class="img_erro" />
		Preencha os campos obrigatorios!
	</div>
   	<?php 
   		  if(isset($msg) && $msg != ""){
   			 echo "<div id='mensagem'><img src='../../img/stop.png' alt='Mensagem de Erro' class='img_erro'/> $msg</div>"; 
   		  } elseif (isset($_GET['session_expired'])){ 
   	  		 echo "<div id='mensagem'><img src='../../img/stop.png' alt='Mensagem de Erro' class='img_erro'/> Sua sessão expirou!</div>";
   	  	  }
   	  	  
   	  	  Util::exibirMsg("o", "login");
   	  	  echo "<p></p>";
   	?>

<form action="LoginForm.php" method="post">
<div id="info_sistema">
<strong>Bem-vindo ao Sistema &quot;SIGAV&quot;</strong><br />
<p>Este sistema irá ajudá-lo a agilizar o processo de aluguel de vestuário,
a ter um melhor gerenciamento dos clientes e fornecedores, fazer laçamento de contas á pagar, pagamento de funconários e muito mais.
O SIGAV é um sistema totalmente online, fácil e simples de usar. Funciona em qualquer navegador e roda em qualquer sistema operacional.
Você tem acesso direto de qualquer navegador (Mozilla Firefox, Internet Explorer 7 ou superior, Google Chrome, etc), qualquer sistema Operacional (Windows, Linux, MacOS, etc) e qualquer aparelho (desktop, notebook, netbook, e etc). 
</p>
<p> Para acessar o SIGAV informe o seu CPF e sua senha nos campos ao lado e clique no botão "Acessar".
	Esqueceu sua senha? <a href="#recuperarSenha" rel="modal" title="Clique aqui para recuperar a senha">Clique Aqui</a> para recuperar a seenha. </p>
</div>
<div id="login_form">
	<div class="top-left"><img src="../../img/acesso.png" alt="acesso.png" width="33" height="45" /></div>
	<div class="top-right"><div id="titulo_form">Acesso Restrito</div></div>
	<div class="inside">
		<div class="campo">
			<input type="hidden" name="operacao" value="autenticar"/>
	    	<label for="cpf" class="label_usuario_login">CPF:</label>&nbsp;
        	<input type="text" name="cpf" id="cpf"  maxlength="11" title="Informe seu CPF"/><br/>
        </div>
        <div class="campo">
        	<label for="senha" class="label_senha_login">Senha:</label>
        	<input type="password" name="senha" id="senha" maxlength="20" title="Informe sua Senha"/>
    	</div>
    </div>
	<div class="bottom-left"></div><div class="bottom-right" style="padding-left:35px;">
	<span class="button"><input type="submit" name="acessar" value="Acessar" title="Acessar"/></span>
	</div>
</div>
 </form>
 </div>
<?php include_once 'RecuperarSenhaForm.php'; ?>
</body>
</html>