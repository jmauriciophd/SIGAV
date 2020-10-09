<?php 
require_once dirname(__FILE__) . "/../libloader.php";

class MenuController
{
	function __construct(){
		
	}
	
	public static function montarMenuPorPerfil($idPerfil)
	{
		if($idPerfil == null || $idPerfil == ""){
			Util::redirecionaPaginaPHP("../login/LoginForm.php");
		}
		$permissaoController = new PermissaoController();
		$permissoes = $permissaoController->consultarPermissaoPorPerfil($idPerfil);
		
		$modulos = array("CADASTRAR", "ALUGAR VESTUÁRIO", "ADMINISTRAR USUÁRIO", "CONSULTAS", "RELATÓRIOS");
		$itensConsulta = array("CLIENTE", "ALUGUEL VESTUÁRIO", "FUNCIONÁRIO", "FORNECEDOR", "VESTUÁRIO", "USUÁRIO");
		
		$itemsModuloCadastrar = null;
		$itemsModuloAlugar = null;
		$itemsModuloAdminUsuario = null; 
		$itemsModuloConsultas = null; 
		$itemsModuloRelatorios = null;
		
		foreach ($permissoes->getElements() as $indice => $permissao){
		    $itemMenu = "aI(\"text={$permissao->getAplicacao()->getNomeAplicacao()};url=javascript:abrirPag('{$permissao->getAplicacao()->getNomeArquivo()}');target=_self;status={$permissao->getAplicacao()->getNomeAplicacao()};\");";
			if($permissao->getAplicacao()->getModulo() == $modulos[0] && $permissao->getAcessa() == 'S'){
				$itemsModuloCadastrar .= $itemMenu;
			} else if($permissao->getAplicacao()->getModulo() == $modulos[1] && $permissao->getAcessa() == 'S'){
				$itemMenu = "aI(\"text=<span style='padding:10px 10px'>{$permissao->getAplicacao()->getNomeAplicacao()}</span>;url=javascript:abrirPag('{$permissao->getAplicacao()->getNomeArquivo()}');target=_self;status=Alugar Vestuário;showmenu={$permissao->getAplicacao()->getNomeAplicacao()};\");";
				$itemsModuloAlugar .= $itemMenu;
			} else if($permissao->getAplicacao()->getModulo() == $modulos[2] && $permissao->getAcessa() == 'S'){
				$itemsModuloAdminUsuario .= $itemMenu;
			} else if($permissao->getAplicacao()->getModulo() == $modulos[4] && $permissao->getAcessa() == 'S'){
				$itemMenu = "aI(\"text=<span style='padding:10px 10px'>{$permissao->getAplicacao()->getNomeAplicacao()}</span>;url=javascript:abrirPag('{$permissao->getAplicacao()->getNomeArquivo()}');target=_self;status=Alugar Vestuário;showmenu={$permissao->getAplicacao()->getNomeAplicacao()};\");";
				$itemsModuloRelatorios .= $itemMenu;
			}
			if($permissao->getConsulta() == 'S'){
				$itemMenuConsulta = null;
				
				if($permissao->getAplicacao()->getNomeAplicacao() == "CLIENTE")
					$itemMenuConsulta = "aI(\"text=CLIENTE;url=javascript:abrirPag('../cliente/ClienteConsulta.php');target=_self;status=CLIENTE;\");";
				else if($permissao->getAplicacao()->getNomeAplicacao() == "ALUGAR VESTUÁRIO")
					$itemMenuConsulta = "aI(\"text=ALUGUEL;url=javascript:abrirPag('../aluguel/AluguelConsulta.php');target=_self;status=ALUGUEL;\");";
				else if($permissao->getAplicacao()->getNomeAplicacao() == "FUNCIONÁRIO")
					$itemMenuConsulta = "aI(\"text=FUNCIONÁRIO;url=javascript:abrirPag('../funcionario/FuncionarioConsulta.php');target=_self;status=FUNCIONÁRIO;\");";
				else if($permissao->getAplicacao()->getNomeAplicacao() == "FORNECEDOR")
					$itemMenuConsulta = "aI(\"text=FORNECEDOR;url=javascript:abrirPag('../fornecedor/FornecedorConsulta.php');target=_self;status=FORNECEDOR;\");";
				else if($permissao->getAplicacao()->getNomeAplicacao() == "VESTUÁRIO")
					$itemMenuConsulta = "aI(\"text=VESTUÁRIO;url=javascript:abrirPag('../vestuario/VestuarioConsulta.php');target=_self;status=VESTUÁRIO;\");";
				else if($permissao->getAplicacao()->getNomeAplicacao() == "USUÁRIO")
					$itemMenuConsulta = "aI(\"text=USUÁRIO;url=javascript:abrirPag('../usuario/UsuarioConsulta.php');target=_self;status=USUÁRIO;\");";
				
				$itemsModuloConsultas .= $itemMenuConsulta;
			}   
		}
		
		echo "<script type=\"text/javascript\">
		with(milonic=new menuname(\"Main Menu\")){
		style=XPMainStyle; top=62; left=10; alwaysvisible=1; orientation=\"horizontal\"; margin=2;";
		
		//Imprime o item Inicio
		echo "aI(\"text=;url=../inicio/pagina_inicial.php;status=;image=;\");";
		echo "aI(\"text=<span style='padding:10px 10px'>INÍCIO</span>;url=javascript:abrirPag('../inicio/pagina_inicial.php');target=_self;status=Início;showmenu=Início;\");";
		//Imprime o item Cadastrar
		if($itemsModuloCadastrar != null){ 
			echo "aI(\"text=<span style='padding:10px 10px'>CADASTRAR</span>;status=Cadastrar;showmenu=Cadastrar;\");";
		}
		//Imprime o item Alugar Vestuario
		if($itemsModuloAlugar != null){
			echo $itemsModuloAlugar;
		}
		//Imprime o item Administrar Usuario
		if($itemsModuloAdminUsuario != null){
			echo "aI(\"text=<span style='padding:10px 10px'>ADMINISTRAR USUÁRIO</span>;status=Administrar Usuário;showmenu=Administrar Usuário;\");";
		} else {
			echo "aI(\"text=<span style='padding:10px 10px'>ALTERAR SENHA</span>;url=javascript:abrirPag('../usuario/SenhaFormAlterar.php');target=_self;status=ALTERAR SENHA;showmenu=ALTERAR SENHA;\");";
		}
		//Imprime o item Consultas
		if($itemsModuloConsultas != null){
			echo "aI(\"text=<span style='padding:10px 10px'>CONSULTAS</span>;status=Consultas;showmenu=Consultas;\");";
		}
		//Imprime o item Relatorios
		if($itemsModuloRelatorios != null){
			echo $itemsModuloRelatorios;
		} 
		//Imprime o item Ajuda
		echo "aI(\"text=<span style='padding:10px 10px'>AJUDA</span>;url=javascript:abrirPopup('../ajuda/manual_mp.htm', 1200, 500);target=_blank;status=Ajuda;showmenu=Ajuda;\");";
		//fecha o wilhe do javascript
		echo "}";
			
		//========Opção Cadastrar================
		if($itemsModuloCadastrar != null){
			echo "with(milonic=new menuname(\"Cadastrar\")){
			style=XPMenuStyle; overflow=\"scroll\"; margin=5;".
				$itemsModuloCadastrar 
			."}";
		}
		
		//========Opção Administrar Usuário================
		if($itemsModuloAdminUsuario != null){
			$itemsModuloAdminUsuario .= "aI(\"text=ALTERAR SENHA;url=javascript:abrirPag('../usuario/SenhaFormAlterar.php');target=_self;status=Alterar Senha;\");";
			echo "with(milonic=new menuname(\"Administrar Usuário\")){
			style=XPMenuStyle; overflow=\"scroll\"; margin=5;".
				$itemsModuloAdminUsuario 
			."}";
		}
		
		//========Opção Consultas================	
		if($itemsModuloConsultas != null){
			echo "with(milonic=new menuname(\"Consultas\")){
			style=XPMenuStyle; overflow=\"scroll\"; margin=5;".
				$itemsModuloConsultas 
			."}";
		}
		
		echo "drawMenus(); </script>";
	}
	
} 
?>
