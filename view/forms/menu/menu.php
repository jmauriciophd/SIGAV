<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-BR" lang="pt-BR">
<head>
<title>SIGAV - Sistema Gestor de Aluguel de Vestuário</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
require_once dirname(__FILE__) . "/../../../config/config.sys.php"; 
require_once dirname(__FILE__) . "/../../../libloader.php";

LoginController::verficaAutenticidadeUsuario();

$nomeUsuario = (isset($_SESSION["NOME_USUARIO"])) ? $_SESSION["NOME_USUARIO"] : "Não autenticado";
$perfilUsuario = (isset($_SESSION['NOME_PERFIL_USUARIO'])) ? $_SESSION['NOME_PERFIL_USUARIO'] : "Não autenticado";

//importa os arquivos css informados na lista
$listaArquivosCss = array("form.css", "geral.css", "geralProini.css", "pro-ini.css", "botoes/round-button.css", "popup.css");
Util::includeArquivosCss($listaArquivosCss);

//cria a variavel javascript tempo_max_sessao para armazenar o tempo maximo da sessao do usuario
echo "<script type=\"text/javascript\"> var tempo_max_sessao = ". TEMPO_SESSAO ."; </script>";

//importa os arquivos javascript informados na lista
$listaArquivosJs = array("menu/menu_src.js", "menu/mmenudom.js", "menu/menu_sistema.js",
						 "jquery/jquery-1.8.1.min.js", "jquery/jquery.validacao.js", "jquery/modal.popup.js",
						 "ajax/ajax.js", "funcoes.modal.popup.js", "validacao.campos.js", "sessao.expirada.js", "funcoes.js"
						 );

Util::includeArquivosJs($listaArquivosJs);

MenuController::montarMenuPorPerfil($_SESSION['ID_PERFIL_USUARIO']);
?>
</head>
<body>
<div id="corpo_pagina">
<div id="topo">
	<div class="nomeSistemaSigav">
		SIGAV - Sistema Gestor de Aluguel de Vestuário
  	</div>
  	<div class="infoUsuario">
			<span>Usuário: <?php echo $nomeUsuario; ?></span>&nbsp;&nbsp;
			<span>Perfil: <?php echo $perfilUsuario; ?></span>&nbsp;&nbsp; 
			<span>Versão: <?php echo VERSAO_SISTEMA; ?></span>&nbsp;&nbsp;
  	</div>
</div>
<div id="menu_horizontal">
<div id="centro_menu">
<div id="texto_horas"  class="style2">
<span style="color: #00E;"><strong>Sua sessão expira em: </strong></span></div>
<div id="horas" class="style2"><span><label  ><?php echo TEMPO_SESSAO; ?>min:00seg</label></span></div>
<div id="sair">
<a href="../../../controller/LogoutController.class.php"><img title="Sair do sistema" src="../../img/exit.gif" alt="Sair" width="16px;" height="16px;"/></a>
</div>
</div>
</div>
  		
<div id="divCorpoPrincipal">
<?php 
if(isset($_SESSION['MSG_ERROR_HANDLE']) && !empty($_SESSION['MSG_ERROR_HANDLE'])){
	 echo "<p></p>".$_SESSION['MSG_ERROR_HANDLE'];
	 unset($_SESSION['MSG_ERROR_HANDLE']);
     exit(0);
} else {
	require_once "../inicio/pagina_inicial.php";
}
?>
</div>

<div id="opacidade">
	<div id="carregando" style="z-index:2; text-align: center; margin-top:150px; display: none;">
		<img src="../../img/loading.gif" width="80px;" height="80px;"/><br/>
		<span style="font-family:Tahoma; font-size: 12px; background-color: white; text-align: center"><b>Processando...</b></span>
	</div>
</div> 
</div>

<script type="text/javascript">
setInterval(apresentaHoras, 1000);
</script>
</body>
</html>