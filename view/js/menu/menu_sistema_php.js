with(milonic=new menuname("Main Menu")){
style=XPMainStyle;
top=62;  //Define o top do menu
left=10;
alwaysvisible=1;
orientation="horizontal";  //horizontal ou vertical
margin=2;
aI("text=;url=../inicio/pagina_inicial.php;status=;image=;");

// M�dulos do Sistema
aI("text=<span style='padding:10px 10px'>IN�CIO</span>;url=javascript:abrirPag('../inicio/pagina_inicial.php');target=_self;status=In�cio;showmenu=In�cio;");
aI("text=<span style='padding:10px 10px'>CADASTRAR</span>;status=Cadastrar;showmenu=Cadastrar;");
aI("text=<span style='padding:10px 10px'>ALUGAR VESTU�RIO</span>;url=javascript:abrirPag('../aluguel/AluguelFormCadastrar.php');target=_self;status=Alugar Vestu�rio;showmenu=Alugar Vestu�rio;");
aI("text=<span style='padding:10px 10px'>ADMINISTRAR USU�RIO</span>;status=Administrar Usu�rio;showmenu=Administrar Usu�rio;");
aI("text=<span style='padding:10px 10px'>CONSULTAS</span>;status=Consultas;showmenu=Consultas;");
aI("text=<span style='padding:10px 10px'>RELAT�RIOS</span>;url=javascript:abrirPag('../relatorios/RelatorioForm.php');status=Relat�rios;showmenu=Relat�rios;");
aI("text=<span style='padding:10px 10px'>AJUDA</span>;url=javascript:abrirPopup('../ajuda/manual_mp.htm', 1200, 500);target=_blank;status=Ajuda;showmenu=Ajuda;");
}

//========Op��o Cadastrar================
with(milonic=new menuname("Cadastrar")){
style=XPMenuStyle;
overflow="scroll";
margin=5;

aI("text=CATEGORIA;url=javascript:abrirPag('../categoria/ManterCategoriaVestuario.php');target=_self;status=Categoria;");
aI("text=CLIENTE;url=javascript:abrirPag('../cliente/ClienteFormCadastrar.php');target=_self;status=CLIENTE;");
aI("text=FUNCION�RIO;url=javascript:abrirPag('../funcionario/FuncionarioFormCadastrar.php');target=_self;status=Funcion�rio;");
aI("text=FORNECEDOR;url=javascript:abrirPag('../fornecedor/FornecedorFormCadastrar.php');target=_self;status=Fornecedor;");
aI("text=VESTU�RIO;url=javascript:abrirPag('../vestuario/VestuarioFormCadastrar.php');target=_self;status=Vestu�rio;");
}

//========Op��o Administrar Usu�rio================
with(milonic=new menuname("Administrar Usu�rio")){
style=XPMenuStyle;
overflow="scroll";
margin=4;
aI("text=CADASTRAR PERFIL;url=javascript:abrirPag('../perfil/ManterPerfil.php');target=_self;status=CADASTRAR PERFIL;");
aI("text=CADASTRAR USU�RIO;url=javascript:abrirPag('../usuario/UsuarioFormCadastrar.php');target=_self;status=Usu�rio;");
aI("text=PERMISS�ES DE ACESSO;url=javascript:abrirPag('../perfil/PermissaoFormCadastrar.php');target=_self;status=Permiss�es de Acesso;");
aI("text=ALTERAR SENHA;url=javascript:abrirPag('../usuario/SenhaFormAlterar.php');target=_self;status=Alterar Senha;");
}

//========Op��o Consultas================
with(milonic=new menuname("Consultas")){
style=XPMenuStyle;
overflow="scroll";
margin=6;
aI("text=CLIENTE;url=javascript:abrirPag('../cliente/ClienteConsulta.php');target=_self;status=Cliente;");
aI("text=ALUGUEL;url=javascript:abrirPag('../aluguel/AluguelConsulta.php');target=_self;status=Aluguel;");
aI("text=FUNCION�RIO;url=javascript:abrirPag('../funcionario/FuncionarioConsulta.php');target=_self;status=Funcion�rio;");
aI("text=FORNECEDOR;url=javascript:abrirPag('../fornecedor/FornecedorConsulta.php');target=_self;status=Fornecedor;");
aI("text=VESTU�RIO;url=javascript:abrirPag('../vestuario/VestuarioConsulta.php');target=_self;status=Vestu�rio;");
aI("text=USU�RIO;url=javascript:abrirPag('../usuario/UsuarioConsulta.php');target=_self;status=Usu�rio;");
}


drawMenus();