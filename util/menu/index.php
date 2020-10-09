<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SIGAV-Sitema Gestor de Aluguel de Vestu&aacute;rio</title>
<link rel="stylesheet" type="text/css" href="../../view/css/menu.css" />
<script type="text/javascript" src="../../view/js/funcoes.js"></script>
</head>
<body >
<?php
session_start();
require_once dirname(__FILE__) . "/../../libloader.php";

$plevel_0 =  new Menu("Cadastro");
$plevel_1 =  new Menu("Pesquisa");
$plevel_2 =  new Menu("Relat&oacute;rio");
$plevel_3 =  new Menu("Configura&ccedil;&otilde;es");
$Ilevel_0=new MenuItem("Cliente","../../view/forms/cliente/ClienteFormCadastrar.php");
$Ilevel_1=new MenuItem("Vestuario","../../view/forms/vestuario/VestuarioFormCadastrar.php");
$Ilevel_2=new MenuItem("Usuario","../../view/forms/usuario/UsuarioFormCadastrar.php");
$Ilevel_3=new MenuItem("Perfil","../../view/forms/perfil/PerfilFormCadastrar.php");
$Ilevel_4=new MenuItem("Funcionario","../../view/forms/funcionario/FuncionarioFormCadastrar.php");
$Ilevel_5=new MenuItem("Pagamentos","../../view/forms/pagamento/PagamentoFuncionarioForm.php");
$menuBar=new MenuBar();
$plevel_0->addItem($Ilevel_0);
$plevel_0->addItem($Ilevel_1);
$plevel_0->addItem($Ilevel_2);
$plevel_0->addItem($Ilevel_3);
$plevel_0->addItem($Ilevel_4);
$plevel_0->addItem($Ilevel_5);
$menuBar->addMenu($plevel_0);
$menuBar->addMenu($plevel_1);
$menuBar->addMenu($plevel_2);
$menuBar->addMenu($plevel_3);
$menuBar->printOut();
echo "<div align='center'>Seja Bem Vindo " . $_SESSION["NOME_USUARIO"] . " ao SIGAV</div>";
?>
</body>
</html>
