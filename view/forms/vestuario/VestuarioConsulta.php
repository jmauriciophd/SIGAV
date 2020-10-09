<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";

$vestuarioController = new VestuarioController();
$result = $vestuarioController->consultarTodosVestuarios();
$listaVestuarios = $result->getElements();

//importa os arquivos css informados na lista
$listaArquivosCss = array("form.css", "geral.css", "geralProini.css", "demo_page.css", "demo_table.css", 
						  "jquery-ui-1.8.4.custom.css", "demo_table_jui.css", "pro-ini.css", 
						  "botoes/round-button.css", "popup.css");
Util::includeArquivosCss($listaArquivosCss);
Util::includeArquivosCss($listaArquivosCss);

	$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
							"jquery/jquery.dataTables.js", 
							 "funcoes.js"
					 );

	Util::includeArquivosJs($listaArquivosJs);

?>
<script type="text/javascript" charset="iso-8859-1">
			$(document).ready(function(){
			    $('#tabelaUsuario').dataTable({
			    	"bJQueryUI": true, //muda o tema da pagina
			    	"bProcessing": true,
			        "sPaginationType": "full_numbers", //muda o tipo da paginacao
			        "oLanguage": {"sUrl": "../../js/jquery/datatables.Portuguese.txt"}, //traduz os textos da biblioteca para portugues
			    	"aaSorting": [[ 1, "asc" ]] //ordenacao inicial
			    });
			});

			function detalharVestuario(id){
				var maskHeight = $(document).height();
				var maskWidth = $(window).width();
				var idO  = $("#opacidadeTela");

				idO.show();
		    	$("#divDetalharVestuario1").show().load("../vestuario/VestuarioDetalhar.php?id="+id);
		    	
		    	//idO.css({'width':maskWidth,'height':maskHeight});
		    	idO.fadeIn("slow");
			}
</script>

<div id="container" style="width: 1200px;">
<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabelaUsuario">
	<thead>
		<tr class='even gradeC'>
		        <th>CÓDIGO</th>
				<th>NOME</th>
				<th>CATEGORIA</th>
    			<th>COR</th>
    			<th>TAMANHO</th>
    			<th>VALOR DO VESTUARIO</th>
    			<th>VALOR DO ALUGUEL</th>
    			<th>OPERAÇÕES</th>
		</tr>
	</thead>
	<tbody>
	   <?php 
    		foreach ($listaVestuarios as $indice => $vestuario){
			  echo "<tr style='text-align:center;' class='even gradeC'>"
				  	 ."<td>" . $vestuario->getId() . "</td>"
					 ."<td>" . $vestuario->getNome() . "</td>"
					 ."<td>" . $vestuario->getCategoria()->getDescricao() . "</td>"
					 ."<td>" . $vestuario->getCor() . "</td>"
					 ."<td>" . $vestuario->getTamanho() . "</td>"
					 ."<td>R$ " . $vestuario->getValorVestuario() . "</td>"
					 ."<td>R$ " . $vestuario->getValorAluguel() . "</td>"
					 ."<td>
					 	<a href='#' onclick=\"detalharVestuario(".$vestuario->getId().");\" >Detalhar</a> |
				 		<a href='#' onclick=\"abrirPag('../vestuario/VestuarioFormCadastrar.php?editar&id={$vestuario->getId()}')\">Alterar</a> |
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
	<div id="divDetalharVestuario1" style="z-index:2; text-align: center; margin-top:0px; display: none;">
	</div>
</div> 