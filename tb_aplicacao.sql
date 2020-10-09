-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Nov 29, 2012 as 06:40 PM
-- Versão do Servidor: 5.1.36
-- Versão do PHP: 5.3.0

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
(1, '../usuario/UsuarioFormCadastrar.php', 'USUÁRIO', 'ADMINISTRAR USUÁRIO', 'Cadastro de Usuário'),
(2, '../perfil/ManterPerfil.php', 'PERFIL', 'ADMINISTRAR USUÁRIO', 'Manter Perfil'),
(3, '../categoria/ManterCategoriaVestuario.php', 'CATEGORIA', 'CADASTRAR', 'Cadastrar Categoria'),
(4, '../cliente/ClienteFormCadastrar.php', 'CLIENTE', 'CADASTRAR', 'Cadastra Cliente'),
(5, '../funcionario/FuncionarioFormCadastrar.php', 'FUNCIONÁRIO', 'CADASTRAR', 'Cadastra Funcionário'),
(6, '../fornecedor/FornecedorFormCadstrar.php', 'FORNECEDOR', 'CADASTRAR', 'Cadastra Fornecedor'),
(7, '../vestuario/VestuarioFormCadastrar.php', 'VESTUÁRIO', 'CADASTRAR', 'Cadastra Vestuário'),
(8, '../aluguel/AluguelFormCadastrar.php', 'ALUGAR VESTUÁRIO', 'ALUGAR VESTUÁRIO', 'ALUGAR VESTUÁRIO'),
(9, '../perfil/PermissaoFormCadastrar.php', 'PERMISSÕES DE ACESSO', 'ADMINISTRAR USUÁRIO', 'Permissões de Acesso'),
(10, '../relatorios/RelatorioForm.php', 'RELATÓRIOS', 'RELATÓRIOS', 'Relatórios');
