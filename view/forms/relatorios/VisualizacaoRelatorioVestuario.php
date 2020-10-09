<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";
$aluguelFilter = new AluguelFilter();
$aluguelFilter->setDataCadastro($_GET["data_locacao_inicial"]);
$aluguelFilter->setDataCadastroFinal($_GET["data_locacao_final"]);
$aluguelFilter->setDataAtualizaoInicial($_GET["data_devolucao_inicial"]);
$aluguelFilter->setDataAtualizaoFinal($_GET["data_devolucao_final"]);
$aluguelFilter->setCpfCliente($_GET["cpf_cliente"]);
$aluguelFilter->setNomeCliente($_GET["nome_cliente"]);
$aluguelFilter->setCpfFuncionario($_GET["cpf_funcionario"]);
$aluguelFilter->setNomeFuncionario($_GET["nome_funcionario"]);
$aluguelFilter->setCnpjFornecedor($_GET["nome_funcionario"]);
$aluguelFilter->setNomeFornecedor($_GET["nome_funcionario"]);
$aluguelFilter->setCategoria($_GET["nome_funcionario"]);
$aluguelFilter->setValorVestuario($_GET["nome_funcionario"]);

$relatorioController = new RelatorioController("");
$result = $relatorioController->consultarAluguel($aluguelFilter);
$listaAluguel = $result->getElements();

$aluguelVestuarioController = new AluguelVestuarioController();
?>

<table class="tabela" align="left" style="width: 100%;" cellpadding="0" cellspacing="4">
	<thead>
		<tr align="left">
		   <th>data Cadastro</th>
		   <th>Funcionário</th>
		   <th>Cliente</th>
		   <th>Código dos Vestuários</th>
		   <th>Data da Locação</th>
		   <th>Data da Devolução</th>
		   <th>Valor Total do Aluguel</th>	
		</tr>
	</thead>
	<tbody>
	<?php foreach ($listaAluguel as $indice => $aluguel){ 
			$codigosVestuarios = $aluguelVestuarioController->recuperarCodigosVestuarioPorIdAluguel($aluguel->getId());			
	?>
		<tr align="left">
			<td><?php echo $aluguel->getId(); ?></td>
			<td><?php echo $aluguel->getUsuario()->getNome(); ?></td>
			<td><?php echo $aluguel->getCliente()->getNome(); ?></td>
			<td><?php echo $codigosVestuarios; ?></td>
			<td><?php echo $aluguel->getDataLocacao(); ?></td>
			<td><?php echo $aluguel->getDataPrevistaDevolucao(); ?></td>
			<td><?php echo $aluguel->getValorTotalAluguel(); ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>