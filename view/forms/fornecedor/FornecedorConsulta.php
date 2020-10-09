<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";

$fornecedorController = new FornecedorController();
$result = $fornecedorController->consultarTodosFornecedores();
$listaFornecedores  = $result->getElements();

$listaArquivosCss = array("form.css","demo_page.css","demo_table.css","demo_table_jui.css","jquery-ui-1.8.4.custom.css");

Util::includeArquivosCss($listaArquivosCss);

	$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
							"jquery/jquery.dataTables.js", 
							 "funcoes.js"
					 );

	Util::includeArquivosJs($listaArquivosJs);

?>
<script type="text/javascript" charset="iso-8859-1">
			$(document).ready(function(){
			    $('#tabelaFornecedor').dataTable({
			    	"bJQueryUI": true, //muda o tema da pagina
			    	"bProcessing": true,
			        "sPaginationType": "full_numbers", //muda o tipo da paginacao
			        "oLanguage": {"sUrl": "../../js/jquery/datatables.Portuguese.txt"}, //traduz os textos da biblioteca para portugues
			    	"aaSorting": [[ 1, "asc" ]] //ordenacao inicial
			    });
			 });
			  function detalharFornecedor(cnpj){
					var maskHeight = $(document).height();
					var maskWidth = $(window).width();
					var idO  = $("#opacidadeTela");

					idO.show();
			    	$("#divDetalharFornecedor").show().load("../fornecedor/FornecedorDetalhar.php?cnpj="+cnpj);
			    	
			    	//idO.css({'width':maskWidth,'height':maskHeight});
			    	idO.fadeIn("slow");
		    	}
			  
			
		</script>
<div id="container" style="width:1200px;">
<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabelaFornecedor">
	<thead>
		<tr class='even gradeC'>
				<th>CNPJ</th>
    			<th>RAZÃO SOCIAL</th>
    			<th>NOME FANTASIA</th>
    			<th>CEP</th>
    			<th>ENDEREÇO</th>
    			<th>CIDADE</th>
    			<th>ESTADO</th>    			
    			<th>E-MAIL</th>
    			<th>TEL. COMERCIAL</th>
    			<th>OPERAÇÕES</th>
		</tr>
	</thead>
	<tbody>
	   <?php 
    		foreach ($listaFornecedores as $indice => $fornecedor){
			  echo "<tr class='even gradeC'>"
				  	 ."<td>" . $fornecedor->getCnpj()."</td>"
				  	 ."<td>" . $fornecedor->getRazaoSocial()."</td>"
					 ."<td>" . $fornecedor->getNomeFantasia()."</td>"
					 ."<td>" . $fornecedor->getEndereco()->getCep()."</td>"
					 ."<td>" . $fornecedor->getEndereco()->getLogradouro(). "</td>"
					 ."<td>" . $fornecedor->getEndereco()->getCidade()."</td>"
					 ."<td>" . $fornecedor->getEndereco()->getEstado()."</td>"
					 ."<td>" . $fornecedor->getContato()->getEmail()."</td>"
					 ."<td>" . $fornecedor->getContato()->getTelComercial()."</td>"
					 ."<td>
				 		<a href='#' onclick=\"detalharFornecedor(".$fornecedor->getCnpj().");\" >Detalhar</a> |
				 		<a href='#' onclick=\"abrirPag('../fornecedor/FornecedorFormCadastrar.php?editar&cnpj={$fornecedor->getCnpj()}')\">Alterar</a> |
				 		<a href=''>Excluir</a>
	    			  </td>"
     			   ."</tr>";
		    }
    	?>
	</tbody>
</table>

</div>
</div>
<!-- popup modal -->
<div id="opacidadeTela">
	<div id="divDetalharFornecedor" style="z-index:2; text-align: center; margin-top:0px; display: none;">
	</div>
</div> 