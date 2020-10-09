-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de GeraÁ„o: Nov 30, 2012 as 08:13 PM
-- Vers„o do Servidor: 5.1.36
-- Vers„o do PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Banco de Dados: `bd_sigav`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_aluguel`
--

CREATE TABLE IF NOT EXISTS `tb_aluguel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor_total_aluguel` decimal(9,2) NOT NULL,
  `data_entrega` datetime NOT NULL,
  `data_locacao` datetime NOT NULL,
  `data_prevista_devolucao` datetime NOT NULL,
  `data_previa` datetime DEFAULT NULL,
  `data_prova` datetime DEFAULT NULL,
  `cpf_usuario` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `cpf_cliente` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `id_pagamento` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tb_usuario_cpf` (`cpf_usuario`),
  KEY `fk_tb_cliente_cpf` (`cpf_cliente`),
  KEY `fk_tb_pagamento_id` (`id_pagamento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `tb_aluguel`
--

INSERT INTO `tb_aluguel` (`id`, `valor_total_aluguel`, `data_entrega`, `data_locacao`, `data_prevista_devolucao`, `data_previa`, `data_prova`, `cpf_usuario`, `cpf_cliente`, `id_pagamento`) VALUES
(6, '57.98', '2012-12-26 00:00:00', '0000-00-00 00:00:00', '2012-12-31 00:00:00', '2012-12-12 00:00:00', '2012-12-19 00:00:00', '02520351195', '37614622472', 17);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_aluguel_vestuario`
--

CREATE TABLE IF NOT EXISTS `tb_aluguel_vestuario` (
  `id_aluguel` int(20) NOT NULL,
  `codigo_vestuario` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `data_devolucao` datetime NOT NULL,
  `situacao` varchar(4000) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_aluguel`,`codigo_vestuario`),
  KEY `fk_tb_estoque` (`codigo_vestuario`),
  KEY `fk_tb_aluguel_id` (`id_aluguel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `tb_aluguel_vestuario`
--

INSERT INTO `tb_aluguel_vestuario` (`id_aluguel`, `codigo_vestuario`, `data_devolucao`, `situacao`) VALUES
(6, 'CMST-05M60', '0000-00-00 00:00:00', '2'),
(6, 'CMST-05M64', '0000-00-00 00:00:00', '2');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `tb_aplicacao`
--

INSERT INTO `tb_aplicacao` (`id`, `nome_arquivo`, `nome_aplicacao`, `modulo`, `descricao`) VALUES
(1, '../usuario/UsuarioFormCadastrar.php', 'USU¡RIO', 'ADMINISTRAR USU¡RIO', 'Cadastro de Usu·rio'),
(2, '../perfil/ManterPerfil.php', 'PERFIL', 'ADMINISTRAR USU¡RIO', 'Manter Perfil'),
(3, '../categoria/ManterCategoriaVestuario.php', 'CATEGORIA', 'CADASTRAR', 'Cadastrar Categoria'),
(4, '../cliente/ClienteFormCadastrar.php', 'CLIENTE', 'CADASTRAR', 'Cadastra Cliente'),
(5, '../funcionario/FuncionarioFormCadastrar.php', 'FUNCION¡RIO', 'CADASTRAR', 'Cadastra Funcion·rio'),
(6, '../fornecedor/FornecedorFormCadastrar.php', 'FORNECEDOR', 'CADASTRAR', 'Cadastra Fornecedor'),
(7, '../vestuario/VestuarioFormCadastrar.php', 'VESTU¡RIO', 'CADASTRAR', 'Cadastra Vestu·rio'),
(8, '../aluguel/AluguelFormCadastrar.php', 'ALUGAR VESTU¡RIO', 'ALUGAR VESTU¡RIO', 'ALUGAR VESTU¡RIO'),
(9, '../perfil/PermissaoFormCadastrar.php', 'PERMISS’ES DE ACESSO', 'ADMINISTRAR USU¡RIO', 'Permissıes de Acesso'),
(10, '../relatorios/RelatorioForm.php', 'RELAT”RIOS', 'RELAT”RIOS', 'RelatÛrios');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categoria`
--

CREATE TABLE IF NOT EXISTS `tb_categoria` (
  `codigo` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `descricao` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `descricao` (`descricao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `tb_categoria`
--

INSERT INTO `tb_categoria` (`codigo`, `descricao`) VALUES
('BLS-01F', 'BLUSA FEMININA'),
('CLCJ-01', 'CAL?JEANS'),
('CMST-05M', 'CAMISETA MASCULINA'),
('CMST-05P', 'CAMISETA POLO'),
('CMST-05S', 'CAMISETA SOCIAL'),
('SPT-T12', 'SAPATENIS'),
('SPT-01S', 'SAPATO SOCIAL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente`
--

CREATE TABLE IF NOT EXISTS `tb_cliente` (
  `cpf` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `sexo` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `rg` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `orgao_expeditor` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `estado_civil` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `uf_orgao_expeditor` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `id_medidas` int(11) NOT NULL,
  PRIMARY KEY (`cpf`),
  KEY `fk_tb_medidas_id` (`id_medidas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `tb_cliente`
--

INSERT INTO `tb_cliente` (`cpf`, `nome`, `sexo`, `data_nascimento`, `rg`, `orgao_expeditor`, `estado_civil`, `uf_orgao_expeditor`, `id_medidas`) VALUES
('05654187422', 'MANOEL SILVA', 'Masculino', '2002-11-04', '2344451', 'SSP', 'Casado(a)', 'SP', 7),
('37614622472', 'JO¬O DE DEUS SANTOS', 'Masculino', '2002-11-14', 'MG-98276252', 'SSP', 'Casado(a)', 'DF', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_contato`
--

CREATE TABLE IF NOT EXISTS `tb_contato` (
  `cpf_cnpj` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `tel_residencial` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `tel_comercial` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `tel_celular` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `twitter` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `facebook` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`cpf_cnpj`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `tb_contato`
--

INSERT INTO `tb_contato` (`cpf_cnpj`, `email`, `tel_residencial`, `tel_comercial`, `tel_celular`, `twitter`, `facebook`) VALUES
('05654187422', 'manoel@gmail.com', '(11) 8376-3536', NULL, '(11) 7774-7483', 'manoel', 'manoel'),
('36749853145', 'JOSE@GMAIL.COM', '(43) 6567-6757', '', '', NULL, NULL),
('37614622472', 'joao@gmail.com', '(98) 4746-4859', NULL, '(98) 7888-7778', 'joao', 'joao12'),
('69411560000135', 'RIACHUELO@RIACHUELO.COM.BR', '', '(98) 7655-4333', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_endereco`
--

CREATE TABLE IF NOT EXISTS `tb_endereco` (
  `cpf_cnpj` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `cep` varchar(8) COLLATE latin1_general_ci NOT NULL,
  `bairro` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `logradouro` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `numero` int(11) NOT NULL,
  `complemento` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `cidade` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `estado` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`cpf_cnpj`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `tb_endereco`
--

INSERT INTO `tb_endereco` (`cpf_cnpj`, `cep`, `bairro`, `logradouro`, `numero`, `complemento`, `cidade`, `estado`) VALUES
('05654187422', '05716090', 'Vila Andrade', 'Rua Itapemirum', 21, 'NENHUMA', 'S„o Paulo', 'SP'),
('36749853145', '72307306', 'SAMAMBAIA SUL', 'Quadra QR 313 Conjunto 06', 26, 'nenhum', 'Samambaia', 'DF'),
('37614622472', '72307306', 'Samambaia Sul', 'Quadra QR 313 Conjunto 06', 26, 'RUA AUGUST', 'Samambaia', 'DF'),
('69411560000135', '72307308', 'Samambaia Sul', 'Quadra QR 313 Conjunto 08', 432, 'nenhum', 'Samambaia', 'DF');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_estoque`
--

CREATE TABLE IF NOT EXISTS `tb_estoque` (
  `id_vestuario` int(11) NOT NULL,
  `codigo_vestuario` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `status` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`codigo_vestuario`),
  KEY `fk_tb_vestuario_id` (`id_vestuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `tb_estoque`
--

INSERT INTO `tb_estoque` (`id_vestuario`, `codigo_vestuario`, `status`) VALUES
(6, 'CMST-05M60', '1'),
(6, 'CMST-05M61', '1'),
(6, 'CMST-05M610', '1'),
(6, 'CMST-05M611', '1'),
(6, 'CMST-05M612', '1'),
(6, 'CMST-05M613', '1'),
(6, 'CMST-05M614', '1'),
(6, 'CMST-05M615', '1'),
(6, 'CMST-05M616', '1'),
(6, 'CMST-05M617', '1'),
(6, 'CMST-05M618', '1'),
(6, 'CMST-05M619', '1'),
(6, 'CMST-05M62', '1'),
(6, 'CMST-05M620', '1'),
(6, 'CMST-05M621', '1'),
(6, 'CMST-05M63', '1'),
(6, 'CMST-05M64', '1'),
(6, 'CMST-05M65', '1'),
(6, 'CMST-05M66', '1'),
(6, 'CMST-05M67', '1'),
(6, 'CMST-05M68', '1'),
(6, 'CMST-05M69', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_fornecedor`
--

CREATE TABLE IF NOT EXISTS `tb_fornecedor` (
  `cnpj` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `razao_social` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `nome_fantasia` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `inscricao_estadual` varchar(30) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`cnpj`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `tb_fornecedor`
--

INSERT INTO `tb_fornecedor` (`cnpj`, `razao_social`, `nome_fantasia`, `inscricao_estadual`) VALUES
('69411560000135', 'RIOS DO CHUELO', 'RIACHUELO', '2366577777');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_funcionario`
--

CREATE TABLE IF NOT EXISTS `tb_funcionario` (
  `cpf` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `sexo` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `rg` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `orgao_expeditor` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `cargo` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `salario` decimal(9,2) NOT NULL,
  `ctps` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `data_admissao` date NOT NULL,
  `data_demissao` date DEFAULT NULL,
  `foto` varchar(400) COLLATE latin1_general_ci DEFAULT NULL,
  `estado_civil` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `grau_instrucao` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `uf_orgao_expeditor` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `num_serie` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `comissao` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `possui_usuario` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `tb_funcionario`
--

INSERT INTO `tb_funcionario` (`cpf`, `nome`, `sexo`, `data_nascimento`, `rg`, `orgao_expeditor`, `cargo`, `salario`, `ctps`, `data_admissao`, `data_demissao`, `foto`, `estado_civil`, `grau_instrucao`, `uf_orgao_expeditor`, `num_serie`, `comissao`, `possui_usuario`) VALUES
('36749853145', 'JOSE MAURICIO CARDOSO', 'Masculino', '0000-00-00', '123456', 'SSP', 'DBA', '6000.00', '434324', '1122-12-20', NULL, NULL, 'Solteiro(a)', 'Ensino Superior Incompleto', 'DF', '332432', '10', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_log`
--

CREATE TABLE IF NOT EXISTS `tb_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aplicacao` int(11) NOT NULL,
  `tabela` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `chave_primaria` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `operacao` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `cpf_usuario` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `data_hora` datetime NOT NULL,
  `ip` varchar(30) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tb_aplicacao_id` (`id_aplicacao`),
  KEY `fk_tb_usuario_cpf` (`cpf_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=150 ;

--
-- Extraindo dados da tabela `tb_log`
--

INSERT INTO `tb_log` (`id`, `id_aplicacao`, `tabela`, `chave_primaria`, `operacao`, `cpf_usuario`, `data_hora`, `ip`) VALUES
(107, 1, 'tb_usuario', '02520351195', 'cadastrar', '02520351195', '2012-11-30 12:11:43', '127.0.0.1'),
(108, 1, 'tb_usuario', '77027108020', 'cadastrar', '02520351195', '2012-11-30 12:11:27', '127.0.0.1'),
(109, 1, 'tb_usuario', '77027108020', 'excluir', '02520351195', '2012-11-30 12:11:52', '127.0.0.1'),
(110, 1, 'tb_usuario', '77027108020', 'cadastrar', '02520351195', '2012-11-30 12:11:40', '127.0.0.1'),
(111, 1, 'tb_usuario', '77027108020', 'excluir', '02520351195', '2012-11-30 12:11:51', '127.0.0.1'),
(112, 1, 'tb_usuario', '77027108020', 'cadastrar', '02520351195', '2012-11-30 12:11:25', '127.0.0.1'),
(113, 1, 'tb_usuario', '77027108020', 'excluir', '02520351195', '2012-11-30 13:11:21', '127.0.0.1'),
(114, 1, 'tb_usuario', '77027108020', 'cadastrar', '02520351195', '2012-11-30 13:11:50', '127.0.0.1'),
(115, 1, 'tb_usuario', '63065581442', 'excluir', '02520351195', '2012-11-30 13:11:53', '127.0.0.1'),
(116, 1, 'tb_usuario', '63065581442', 'cadastrar', '02520351195', '2012-11-30 13:11:41', '127.0.0.1'),
(117, 1, 'tb_usuario', '63065581442', 'excluir', '02520351195', '2012-11-30 13:11:35', '127.0.0.1'),
(118, 1, 'tb_usuario', '63065581442', 'cadastrar', '02520351195', '2012-11-30 13:11:00', '127.0.0.1'),
(119, 1, 'tb_usuario', '63065581442', 'excluir', '02520351195', '2012-11-30 13:11:53', '127.0.0.1'),
(120, 1, 'tb_usuario', '63065581442', 'cadastrar', '02520351195', '2012-11-30 13:11:30', '127.0.0.1'),
(121, 1, 'tb_usuario', '63065581442', 'excluir', '02520351195', '2012-11-30 13:11:47', '127.0.0.1'),
(122, 1, 'tb_usuario', '63065581442', 'cadastrar', '02520351195', '2012-11-30 13:11:17', '127.0.0.1'),
(123, 1, 'tb_usuario', '77027108020', 'excluir', '02520351195', '2012-11-30 13:11:24', '127.0.0.1'),
(124, 1, 'tb_usuario', '77027108020', 'cadastrar', '02520351195', '2012-11-30 13:11:45', '127.0.0.1'),
(125, 1, 'tb_usuario', '77027108020', 'excluir', '02520351195', '2012-11-30 13:11:33', '127.0.0.1'),
(126, 1, 'tb_usuario', '77027108020', 'cadastrar', '02520351195', '2012-11-30 13:11:57', '127.0.0.1'),
(127, 1, 'tb_usuario', '77027108020', 'excluir', '02520351195', '2012-11-30 14:11:42', '127.0.0.1'),
(128, 1, 'tb_usuario', '77027108020', 'cadastrar', '02520351195', '2012-11-30 14:11:23', '127.0.0.1'),
(129, 1, 'tb_usuario', '77027108020', 'excluir', '02520351195', '2012-11-30 14:11:03', '127.0.0.1'),
(130, 1, 'tb_usuario', '77027108020', 'cadastrar', '02520351195', '2012-11-30 14:11:36', '127.0.0.1'),
(131, 1, 'tb_usuario', '77027108020', 'excluir', '02520351195', '2012-11-30 14:11:49', '127.0.0.1'),
(132, 1, 'tb_usuario', '77027108020', 'cadastrar', '02520351195', '2012-11-30 14:11:37', '127.0.0.1'),
(133, 1, 'tb_usuario', '48131537471', 'cadastrar', '02520351195', '2012-11-30 17:11:46', '127.0.0.1'),
(134, 1, 'tb_usuario', '02313834360', 'cadastrar', '02520351195', '2012-11-30 17:11:31', '127.0.0.1'),
(135, 1, 'tb_usuario', '03068616158', 'excluir', '02520351195', '2012-11-30 19:11:51', '192.168.1.11'),
(136, 1, 'tb_usuario', '03068616158', 'cadastrar', '02520351195', '2012-11-30 19:11:24', '192.168.1.11'),
(137, 1, 'tb_usuario', '05887601701', 'cadastrar', '02520351195', '2012-11-30 19:11:33', '192.168.1.11'),
(138, 1, 'tb_usuario', '80646450182', 'cadastrar', '02520351195', '2012-11-30 19:11:06', '192.168.1.11'),
(139, 1, 'tb_usuario', '02313834360', 'excluir', '02520351195', '2012-11-30 19:11:11', '192.168.1.11'),
(140, 1, 'tb_usuario', '02313834360', 'cadastrar', '02520351195', '2012-11-30 19:11:31', '192.168.1.11'),
(141, 1, 'tb_usuario', '12520351192', 'excluir', '02520351195', '2012-11-30 19:11:56', '192.168.1.11'),
(142, 1, 'tb_usuario', '125251192', 'excluir', '02520351195', '2012-11-30 19:11:06', '192.168.1.11'),
(143, 1, 'tb_usuario', '025201192', 'excluir', '02520351195', '2012-11-30 19:11:25', '192.168.1.11'),
(144, 1, 'tb_usuario', '02520351192', 'excluir', '02520351195', '2012-11-30 19:11:43', '192.168.1.11'),
(145, 1, 'tb_usuario', '48131537471', 'excluir', '02520351195', '2012-11-30 19:11:29', '192.168.1.11'),
(146, 1, 'tb_usuario', '63065581442', 'excluir', '02520351195', '2012-11-30 19:11:14', '192.168.1.11'),
(147, 1, 'tb_usuario', '77027108020', 'excluir', '02520351195', '2012-11-30 19:11:17', '192.168.1.11'),
(148, 8, 'tb_aluguel', '5', 'cadastrar', '02520351195', '2012-11-30 20:11:20', '127.0.0.1'),
(149, 8, 'tb_aluguel', '6', 'cadastrar', '02520351195', '2012-11-30 20:11:54', '127.0.0.1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_medidas`
--

CREATE TABLE IF NOT EXISTS `tb_medidas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tamanho` double DEFAULT NULL,
  `busto_torax` double DEFAULT NULL,
  `cintura` double DEFAULT NULL,
  `quadril` double DEFAULT NULL,
  `altura_frente` double DEFAULT NULL,
  `ombro` double DEFAULT NULL,
  `costas` double DEFAULT NULL,
  `braco` double DEFAULT NULL,
  `observacao` varchar(4000) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `tb_medidas`
--

INSERT INTO `tb_medidas` (`id`, `tamanho`, `busto_torax`, `cintura`, `quadril`, `altura_frente`, `ombro`, `costas`, `braco`, `observacao`) VALUES
(1, 26, 85, 67, 56, 43, 19, NULL, 39, 'nenhuma observaÁ„o a ser feita'),
(7, 12, 11, 10, 19, 18, 17, 15, 20, 'nenhuma observaÁ„o feita ainda');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pagamento`
--

CREATE TABLE IF NOT EXISTS `tb_pagamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_pagamento` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `num_parcelas` int(2) DEFAULT NULL,
  `valor_parcelas` decimal(9,2) DEFAULT NULL,
  `entrada` decimal(9,2) NOT NULL,
  `falta_pagar` decimal(9,2) NOT NULL,
  `multa` decimal(9,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `tb_pagamento`
--

INSERT INTO `tb_pagamento` (`id`, `tipo_pagamento`, `num_parcelas`, `valor_parcelas`, `entrada`, `falta_pagar`, `multa`) VALUES
(11, '', 0, '0.00', '0.00', '13.76', '0.00'),
(12, '', 0, '0.00', '0.00', '46.97', '0.00'),
(14, '', 0, '0.00', '0.00', '16.66', '0.00'),
(15, '', 0, '0.00', '0.00', '16.66', '0.00'),
(16, '', 0, '0.00', '0.00', '37.98', '0.00'),
(17, '', 0, '0.00', '0.00', '37.98', '0.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_perfil`
--

CREATE TABLE IF NOT EXISTS `tb_perfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `descricao` varchar(4000) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `tb_perfil`
--

INSERT INTO `tb_perfil` (`id`, `nome`, `descricao`) VALUES
(1, 'ADMINISTRADOR', 'POSSUI PERMISS√O TOTAL AO SISTEMA'),
(2, 'USU¡ÅRIO COMUM', 'POSSUI PERMISS’ES RESTRITAS'),
(5, 'OPERA«√O', 'OPERA«√O COMUM');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_permissao_acesso`
--

CREATE TABLE IF NOT EXISTS `tb_permissao_acesso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perfil` int(11) NOT NULL,
  `id_aplicacao` int(11) NOT NULL,
  `flg_acessar` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `flg_consultar` char(1) CHARACTER SET latin1 COLLATE latin1_danish_ci NOT NULL DEFAULT 'N',
  `flg_cadastrar` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `flg_atualizar` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `flg_excluir` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `flg_imprimir` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `fk_tb_perfil_id` (`id_perfil`),
  KEY `fk_tb_aplicacao_id` (`id_aplicacao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=37 ;

--
-- Extraindo dados da tabela `tb_permissao_acesso`
--

INSERT INTO `tb_permissao_acesso` (`id`, `id_perfil`, `id_aplicacao`, `flg_acessar`, `flg_consultar`, `flg_cadastrar`, `flg_atualizar`, `flg_excluir`, `flg_imprimir`) VALUES
(7, 1, 8, 'S', 'S', 'S', 'S', 'S', 'S'),
(8, 1, 3, 'S', 'S', 'S', 'S', 'S', 'S'),
(9, 1, 4, 'S', 'S', 'N', 'N', 'N', 'S'),
(10, 1, 6, 'S', 'S', 'S', 'S', 'S', 'S'),
(11, 1, 5, 'S', 'S', 'S', 'S', 'S', 'S'),
(12, 1, 2, 'S', 'S', 'S', 'S', 'S', 'S'),
(13, 1, 9, 'S', 'S', 'S', 'S', 'S', 'S'),
(14, 1, 10, 'S', 'S', 'S', 'S', 'S', 'S'),
(15, 1, 1, 'S', 'S', 'S', 'S', 'S', 'S'),
(16, 1, 7, 'S', 'S', 'S', 'S', 'S', 'S'),
(17, 2, 8, 'N', 'N', 'N', 'N', 'N', 'N'),
(18, 2, 3, 'S', 'S', 'S', 'S', 'S', 'N'),
(19, 2, 4, 'S', 'S', 'S', 'S', 'N', 'N'),
(20, 2, 6, 'N', 'N', 'N', 'N', 'N', 'N'),
(21, 2, 5, 'N', 'N', 'N', 'N', 'N', 'N'),
(22, 2, 2, 'N', 'N', 'N', 'N', 'N', 'N'),
(23, 2, 9, 'N', 'N', 'N', 'N', 'N', 'N'),
(24, 2, 10, 'N', 'N', 'N', 'N', 'N', 'N'),
(25, 2, 1, 'N', 'N', 'N', 'N', 'N', 'N'),
(26, 2, 7, 'N', 'S', 'S', 'S', 'S', 'S'),
(27, 5, 8, 'N', 'N', 'S', 'N', 'N', 'N'),
(28, 5, 3, 'N', 'N', 'S', 'N', 'N', 'N'),
(29, 5, 4, 'N', 'N', 'S', 'N', 'N', 'N'),
(30, 5, 6, 'N', 'N', 'S', 'N', 'N', 'N'),
(31, 5, 5, 'N', 'N', 'S', 'N', 'N', 'N'),
(32, 5, 2, 'N', 'N', 'S', 'N', 'N', 'N'),
(33, 5, 9, 'N', 'N', 'S', 'N', 'N', 'N'),
(34, 5, 10, 'N', 'N', 'S', 'N', 'N', 'N'),
(35, 5, 1, 'N', 'N', 'S', 'N', 'N', 'N'),
(36, 5, 7, 'N', 'N', 'S', 'N', 'N', 'N');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `cpf` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `senha` varchar(4000) COLLATE latin1_general_ci NOT NULL,
  `nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `situacao` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'A',
  `id_perfil` int(11) NOT NULL,
  PRIMARY KEY (`cpf`),
  KEY `fk_tb_perfil_id` (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`cpf`, `senha`, `nome`, `email`, `situacao`, `id_perfil`) VALUES
('02313834360', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'JOS… MAURICIO', 'JMAURICIOPHD@GMAIL.COM', 'A', 1),
('02520351195', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'RAFAEL DIAS DE SOUZA', 'RAFADIAS05@GMAIL.COM', 'A', 1),
('03068616158', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'RENAN PEREIRA', 'RENANPEREIRAMOREIRA@GMAIL.COM', 'A', 2),
('05887601701', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'RAPHAEL JOS… DA SILVA', 'RJSILVA1987@GMAIL.COM', 'A', 1),
('80646450182', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'LUIZ ANDR… DE ALMEIDA', 'LUIZANDRECEE@HOTMAIL.COM', 'A', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_vestuario`
--

CREATE TABLE IF NOT EXISTS `tb_vestuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cnpj_fornecedor` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `nome` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `codigo_categoria` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `tamanho` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `medidas` varchar(4000) COLLATE latin1_general_ci NOT NULL,
  `cor` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `valor_vestuario` decimal(9,2) NOT NULL,
  `valor_aluguel` decimal(9,2) NOT NULL,
  `observacao` varchar(4000) COLLATE latin1_general_ci DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tb_fornecedor_cnpj` (`cnpj_fornecedor`),
  KEY `fk_tb_categoria_codigo` (`codigo_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `tb_vestuario`
--

INSERT INTO `tb_vestuario` (`id`, `cnpj_fornecedor`, `nome`, `codigo_categoria`, `tamanho`, `medidas`, `cor`, `valor_vestuario`, `valor_aluguel`, `observacao`, `quantidade`) VALUES
(6, '69411560000135', 'CAMISETA SETE MARES', 'CMST-05M', 'M', 'M…DIO', 'BRANCA', '89.99', '28.99', 'nenhuma', 22);

--
-- RestriÁıes para as tabelas dumpadas
--

--
-- RestriÁıes para a tabela `tb_aluguel`
--
ALTER TABLE `tb_aluguel`
  ADD CONSTRAINT `tb_aluguel_ibfk_1` FOREIGN KEY (`cpf_usuario`) REFERENCES `tb_usuario` (`cpf`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_aluguel_ibfk_2` FOREIGN KEY (`cpf_cliente`) REFERENCES `tb_cliente` (`cpf`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_aluguel_ibfk_3` FOREIGN KEY (`id_pagamento`) REFERENCES `tb_pagamento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- RestriÁıes para a tabela `tb_aluguel_vestuario`
--
ALTER TABLE `tb_aluguel_vestuario`
  ADD CONSTRAINT `tb_aluguel_vestuario_ibfk_1` FOREIGN KEY (`id_aluguel`) REFERENCES `tb_aluguel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_aluguel_vestuario_ibfk_2` FOREIGN KEY (`codigo_vestuario`) REFERENCES `tb_estoque` (`codigo_vestuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- RestriÁıes para a tabela `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD CONSTRAINT `tb_cliente_ibfk_1` FOREIGN KEY (`id_medidas`) REFERENCES `tb_medidas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- RestriÁıes para a tabela `tb_estoque`
--
ALTER TABLE `tb_estoque`
  ADD CONSTRAINT `tb_estoque_ibfk_1` FOREIGN KEY (`id_vestuario`) REFERENCES `tb_vestuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- RestriÁıes para a tabela `tb_log`
--
ALTER TABLE `tb_log`
  ADD CONSTRAINT `tb_log_ibfk_1` FOREIGN KEY (`id_aplicacao`) REFERENCES `tb_aplicacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_log_ibfk_2` FOREIGN KEY (`cpf_usuario`) REFERENCES `tb_usuario` (`cpf`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- RestriÁıes para a tabela `tb_permissao_acesso`
--
ALTER TABLE `tb_permissao_acesso`
  ADD CONSTRAINT `tb_permissao_acesso_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `tb_perfil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_permissao_acesso_ibfk_2` FOREIGN KEY (`id_aplicacao`) REFERENCES `tb_aplicacao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- RestriÁıes para a tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD CONSTRAINT `tb_usuario_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `tb_perfil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- RestriÁıes para a tabela `tb_vestuario`
--
ALTER TABLE `tb_vestuario`
  ADD CONSTRAINT `tb_vestuario_ibfk_1` FOREIGN KEY (`codigo_categoria`) REFERENCES `tb_categoria` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_vestuario_ibfk_2` FOREIGN KEY (`cnpj_fornecedor`) REFERENCES `tb_fornecedor` (`cnpj`) ON DELETE CASCADE ON UPDATE CASCADE;
