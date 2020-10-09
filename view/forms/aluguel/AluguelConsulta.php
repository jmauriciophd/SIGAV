<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";

$aluguelVestuarioController = new AluguelVestuarioController();
$result = $aluguelVestuarioController->consultarTodosAlugueis();
$listaAlugueis = $result->getElements();

$listaArquivosCss = array("form.css", "modal.css", "geralProini.css", "demo_page.css", "demo_table.css", 
						  "jquery-ui-1.8.4.custom.css", "demo_table_jui.css", "pro-ini.css", 
						  "botoes/round-button.css", "popup.css");

Util::includeArquivosCss($listaArquivosCss);

	$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
							"jquery/jquery.dataTables.js", 
							 "funcoes.js"
					 );

	Util::includeArquivosJs($listaArquivosJs);

?>
<script type="text/javascript" charset="iso-8859-1">
			$(document).ready(function(){
			    $('#tabelaAluguel').dataTable({
			    	"bJQueryUI": true, //muda o tema da pagina
			    	"bProcessing": true,
			        "sPaginationType": "full_numbers", //muda o tipo da paginacao
			        "oLanguage": {"sUrl": "../../js/jquery/datatables.Portuguese.txt"}, //traduz os textos da biblioteca para portugues
			    	"aaSorting": [[ 1, "asc" ]] //ordenacao inicial
			    });
			});
			
			function detalharAluguel(id){
				var maskHeight = $(document).height();
				var maskWidth = $(window).width();
				var idO  = $("#opacidadeTela");

				idO.show();
		    	$("#divDetalharAluguel").show().load("../aluguel/AluguelDetalhar.php?id="+id);
		    	
		    	//idO.css({'width':maskWidth,'height':maskHeight});
		    	idO.fadeIn("slow");
	}
</script>
<div id="container" style="width: 1182px;">
<div id="demo">
	<table style="width: 100%;" cellpadding="0" cellspacing="0" border="0" class="display" id="tabelaAluguel">
		<thead>
			<tr class='even gradeC'>
				<th>Nº CONTRATO</th>
    			<th>NOME DO CLIENTE</th>
    			<th>VALOR TOTAL DO ALUGUEL</th>
    			<th>DATA DA LOCAÇÃO</th>
    			<th>PREVISÃO P/ DEVOLUÇAO</th>
    			<th>OPERAÇÕES</th>
    	     </tr>
	      </thead>
	      <tbody>
		  <?php 
    		foreach ($listaAlugueis as $indice => $aluguel){
			  echo "<tr style='text-align:center;' class='even gradeC'>"
				  	 ."<td>" . $aluguel->getId() . "</td>"
					 ."<td>" . $aluguel->getCliente()->getNome() . "</td>"
					 ."<td>" . $aluguel->getValorTotalAluguel() . "</td>"
					 ."<td>" . $aluguel->getDataLocacao() . "</td>"
					 ."<td>" . $aluguel->getDataPrevistaDevolucao() . "</td><br />"
					 ."<td>
				 		<a href='#' onclick=\"detalharAluguel('".$aluguel->getId()."');\" >Detalhar</a> |
				 		<a href='#' onclick=\"abrirPag('../aluguel/AluguelFormCadastrar.php?editar&id={$aluguel->getId()}')\">Alterar</a> |
				 		<a href='#' onclick=\"abrirPag('../aluguel/ContratoAluguel.php?id_aluguel={$aluguel->getId()}')\">Emitir Contrato</a>
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
	<div id="divDetalharAluguel" style="z-index:2; text-align: center; margin-top:0px; display: none;">
	</div>
</div> 