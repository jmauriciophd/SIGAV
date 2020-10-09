with(milonic=new menuname("Main Menu")){
style=XPMainStyle;
top=62;  //Define o top do menu
left=10;
alwaysvisible=1;
orientation="horizontal";  //horizontal ou vertical
margin=2;
aI("text=;url=../inicio/pagina_inicial.php;status=;image=;");

// Módulos do Sistema
aI("text=<span style='padding:10px 10px'>INÍCIO</span>;url=javascript:abrirPag('../inicio/pagina_inicial.php');target=_self;status=Início;showmenu=Início;");
aI("text=<span style='padding:10px 10px'>CADASTRAR</span>;status=Cadastrar;showmenu=Cadastrar;");
aI("text=<span style='padding:10px 10px'>ALUGAR VESTUÁRIO</span>;url=javascript:abrirPag('../aluguel/AluguelFormCadastrar.php');target=_self;status=Alugar Vestuário;showmenu=Alugar Vestuário;");
aI("text=<span style='padding:10px 10px'>ADMINISTRAR USUÁRIO</span>;status=Administrar Usuário;showmenu=Administrar Usuário;");
aI("text=<span style='padding:10px 10px'>CONSULTAS</span>;status=Consultas;showmenu=Consultas;");
aI("text=<span style='padding:10px 10px'>RELATÓRIOS</span>;url=javascript:abrirPag('../relatorios/RelatorioForm.php');status=Relatórios;showmenu=Relatórios;");
aI("text=<span style='padding:10px 10px'>AJUDA</span>;url=javascript:abrirPopup('../ajuda/manual_mp.htm', 1200, 500);target=_blank;status=Ajuda;showmenu=Ajuda;");
}

//========Opção Cadastrar================
with(milonic=new menuname("Cadastrar")){
style=XPMenuStyle;
overflow="scroll";
margin=5;

aI("text=CATEGORIA;url=javascript:abrirPag('../categoria/ManterCategoriaVestuario.php');target=_self;status=Categoria;");
aI("text=CLIENTE;url=javascript:abrirPag('../cliente/ClienteFormCadastrar.php');target=_self;status=CLIENTE;");
aI("text=FUNCIONÁRIO;url=javascript:abrirPag('../funcionario/FuncionarioFormCadastrar.php');target=_self;status=Funcionário;");
aI("text=FORNECEDOR;url=javascript:abrirPag('../fornecedor/FornecedorFormCadastrar.php');target=_self;status=Fornecedor;");
aI("text=VESTUÁRIO;url=javascript:abrirPag('../vestuario/VestuarioFormCadastrar.php');target=_self;status=Vestuário;");
}

//========Opção Administrar Usuário================
with(milonic=new menuname("Administrar Usuário")){
style=XPMenuStyle;
overflow="scroll";
margin=4;
aI("text=CADASTRAR PERFIL;url=javascript:abrirPag('../perfil/ManterPerfil.php');target=_self;status=CADASTRAR PERFIL;");
aI("text=CADASTRAR USUÁRIO;url=javascript:abrirPag('../usuario/UsuarioFormCadastrar.php');target=_self;status=Usuário;");
aI("text=PERMISSÕES DE ACESSO;url=javascript:abrirPag('../perfil/PermissaoFormCadastrar.php');target=_self;status=Permissões de Acesso;");
aI("text=ALTERAR SENHA;url=javascript:abrirPag('../usuario/SenhaFormAlterar.php');target=_self;status=Alterar Senha;");
}

//========Opção Consultas================
with(milonic=new menuname("Consultas")){
style=XPMenuStyle;
overflow="scroll";
margin=6;
aI("text=CLIENTE;url=javascript:abrirPag('../cliente/ClienteConsulta.php');target=_self;status=Cliente;");
aI("text=ALUGUEL;url=javascript:abrirPag('../aluguel/AluguelConsulta.php');target=_self;status=Aluguel;");
aI("text=FUNCIONÁRIO;url=javascript:abrirPag('../funcionario/FuncionarioConsulta.php');target=_self;status=Funcionário;");
aI("text=FORNECEDOR;url=javascript:abrirPag('../fornecedor/FornecedorConsulta.php');target=_self;status=Fornecedor;");
aI("text=VESTUÁRIO;url=javascript:abrirPag('../vestuario/VestuarioConsulta.php');target=_self;status=Vestuário;");
aI("text=USUÁRIO;url=javascript:abrirPag('../usuario/UsuarioConsulta.php');target=_self;status=Usuário;");
}


drawMenus();