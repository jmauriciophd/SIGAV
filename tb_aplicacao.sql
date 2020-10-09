-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Gera��o: Nov 29, 2012 as 06:40 PM
-- Vers�o do Servidor: 5.1.36
-- Vers�o do PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Banco de Dados: `bd_sigav`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_aplicacao`
--

CREATE TABLE IF NOT EXISTS `tb_aplicacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_arquivo` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `nome_aplicacao` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `modulo` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `descricao` varchar(4000) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome_arquivo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=17 ;

--
-- Extraindo dados da tabela `tb_aplicacao`
--

INSERT INTO `tb_aplicacao` (`id`, `nome_arquivo`, `nome_aplicacao`, `modulo`, `descricao`) VALUES
(1, '../usuario/UsuarioFormCadastrar.php', 'USU�RIO', 'ADMINISTRAR USU�RIO', 'Cadastro de Usu�rio'),
(2, '../perfil/ManterPerfil.php', 'PERFIL', 'ADMINISTRAR USU�RIO', 'Manter Perfil'),
(3, '../categoria/ManterCategoriaVestuario.php', 'CATEGORIA', 'CADASTRAR', 'Cadastrar Categoria'),
(4, '../cliente/ClienteFormCadastrar.php', 'CLIENTE', 'CADASTRAR', 'Cadastra Cliente'),
(5, '../funcionario/FuncionarioFormCadastrar.php', 'FUNCION�RIO', 'CADASTRAR', 'Cadastra Funcion�rio'),
(6, '../fornecedor/FornecedorFormCadstrar.php', 'FORNECEDOR', 'CADASTRAR', 'Cadastra Fornecedor'),
(7, '../vestuario/VestuarioFormCadastrar.php', 'VESTU�RIO', 'CADASTRAR', 'Cadastra Vestu�rio'),
(8, '../aluguel/AluguelFormCadastrar.php', 'ALUGAR VESTU�RIO', 'ALUGAR VESTU�RIO', 'ALUGAR VESTU�RIO'),
(9, '../perfil/PermissaoFormCadastrar.php', 'PERMISS�ES DE ACESSO', 'ADMINISTRAR USU�RIO', 'Permiss�es de Acesso'),
(10, '../relatorios/RelatorioForm.php', 'RELAT�RIOS', 'RELAT�RIOS', 'Relat�rios');
