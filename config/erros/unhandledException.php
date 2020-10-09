<?php
session_start();
function erro_handler_main($code,$message,$filename,$line){
  $error = '<div id="divErroMain" style="font-family: tahoma;">
			<center><h2>Ocorreu um erro não esperado durante a sua solicitação</h2></center>
			<p style="margin-left: 20px">
		    <font color="red"><strong>Por favor, reporte este problema ao adminsitrador do sistema ou a equipe técnica responsável. Obrigado pela sua cooperação.</strong></font>
		    <br/><br/>
		    Você poderá visualizar o erro clicando no link abaixo, ou <a href="#" onclick="jafascript:refresh();">tentar novamente</a>.
		    <br/><a href="#" onclick="mostrarEsconderElemento(\'divErro\');">Detalhes do erro</a>
		    <div id="divErro" style="display: none">
		    Codigo: ' . $code . '<br/>
		    Descricao: ' . $message . '<br/>
		    Arquivo: ' . $filename . '<br/>
		    Linha: ' . $line . '<br/>
		    </div></p></div>'; 
	
	$_SESSION['MSG_ERROR_HANDLE'] = $error;	
			
   // header("Location: ../../../view/forms/menu/menu.php");
}
 
set_error_handler('erro_handler_main');
?>
