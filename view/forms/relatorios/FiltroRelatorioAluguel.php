<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";
Util::includeArquivosCss($listaArquivosCss);

	$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
							"jquery/jquery.dataTables.js", 
							 "funcoes.js", "mascaras.js"
							  );
					 
?>
<table>
	<tr>
	   <td><label for="data_locacao" title="Data da Loca��o">Data da Loca��o:</label></td>	
	   <td>   
	       <input type="text" id="data_locacao_inicial" name="data_locacao_inicial" size="10" title="Selecione a Data Inicial da Loca��o" /> � 
	       <input type="text" id='data_locacao_final' name='data_locacao_final' size="10" title="Selecione a Data Final da Loca��o" />
	   </td>
	   <td><label for="data_devolucao" title="Data da Devolu��o">Data da Devolu��o:</label></td>	
	   <td>   
	       <input type="text" id="data_devolucao_inicial" name="data_devolucao_inicial" size="10" title="Selecione a Data Inicial da Devolu��o" /> � 
	       <input type="text" id="data_devolucao_final" name="data_devolucao_final" size="10" title="Selecione a Data Final da Devolu��o" />
	   </td>
	</tr>
	<tr>
	   <td><label for="cpf_cliente" title="CPF do Cliente">CPF do Cliente:</label></td>	
	   <td>   
	       <input type="text" id="cpf_cliente" name="cpf_cliente" size="26" title="Informe o CPF do cliente" />
	   </td>
	   <td><label for="nome_cliente" title="Nome do Cliente">Nome do Cliente:</label></td>	
	   <td>   
	       <input type="text" id="nome_cliente" name="nome_cliente" size="26" title="Informe o nome do cliente" />
	   </td>
	</tr>
	<tr>
	   <td><label for="cpf_funcionario" title="CPF do Funcion�rio">CPF do Funcion�rio:</label></td>	
	   <td>   
	       <input type="text" id="cpf_funcionario" name="cpf_funcionario" size="26" title="Informe o CPF do Funcion�rio" />
	   </td>
	   <td><label for="nome_funcionario" title="Nome do Funcion�rio">Nome do Funcion�rio:</label></td>	
	   <td>   
	       <input type="text" id="nome_funcionario" name="nome_funcionario" size="26" title="Informe o nome do funcion�rio" />
	   </td>
	</tr>
</table>