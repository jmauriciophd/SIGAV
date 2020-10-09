<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";
         
$funcionarioController = new FuncionarioController();
$result = $funcionarioController->consultarTodosFuncionarios();
$listaFuncionarios  = $result->getElements();

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
			    $('#tabelaFuncionario').dataTable({
			    	"bJQueryUI": true, //muda o tema da pagina
			    	"bProcessing": true,
			        "sPaginationType": "full_numbers", //muda o tipo da paginacao
			        "oLanguage": {"sUrl": "../../js/jquery/datatables.Portuguese.txt"}, //traduz os textos da biblioteca para portugues
			    	"aaSorting": [[ 1, "asc" ]] //ordenacao inicial
			    });
			    $("#excluir").click(function(event) {
                    
					if(confirm("Deseja excluir o registro!")){
				    event.preventDefault();
				    executarAcao("excluir");
					}
				});
			 });
			function detalharFuncionario(cpf){
				var maskHeight = $(document).height();
				var maskWidth = $(window).width();
				var idO  = $("#opacidadeTela");

				idO.show();
		    	$("#divDetalharFuncionario").show().load("../funcionario/FuncionarioDetalhar.php?cpf="+cpf);
		    	
		    	//idO.css({'width':maskWidth,'height':maskHeight});
		    	idO.fadeIn("slow");
		}
</script>
<div id="container" style="width:1300px;">
<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabelaFuncionario">
	<thead>
		<tr class='even gradeC'>
				<th>CPF</th>
    			<th>NOME</th>
    			<th>CARGO</th>
    			<th>DATA ADMISSÃO</th>
    			<th>DATA DEMISSÃO</th>    			
    			<th>ENDERECO</th>
    			<th>TEL. CELULAR</th>
    			<th>OPERAÇÕES</th>
		</tr>
	</thead>
	<tbody>
	   <?php 
    		foreach ($listaFuncionarios as $indice => $funcionario){
			  echo "<tr class='even gradeC'>"
				     ."<td>" . $funcionario->getCpf() . "</td>"
					 ."<td>" . $funcionario->getNome()   . "</td>"
					 ."<td>" . $funcionario->getCargo()   . "</td>"
					 ."<td>" . $funcionario->getDataAdmissao()   . "</td>"
					 ."<td>" . $funcionario->getDataDemissao()   . "</td>"
					 ."<td>" . $funcionario->getEndereco()->getLogradouro() ."/". $funcionario->getEndereco()->getNumero() . "</td>"
					 ."<td>" . $funcionario->getContato()->getTelCelular()  . "</td>"
					 ."<td> 
					    <a href='#' onclick=\"detalharFuncionario('".$funcionario->getCpf()."');\" >Detalhar</a> |
				 		<a href='#' onclick=\"abrirPag('../funcionario/FuncionarioFormCadastrar.php?editar&cpf={$funcionario->getCpf()}')\">Alterar</a> |
				 		<a href='#' onclick='executarAcao(\"excluir&cpf=".$funcionario->getCpf()."\");'>Excluir</a>
	    			  </td>"
				 ."</tr>";
		    }
    	?>
	</tbody>  </table>
 </div>
 </div>
<!-- popup modal -->
   <div id="opacidadeTela">
	<div id="divDetalharFuncionario" style="z-index:2; text-align: center; margin-top:0px; display: none;">
	</div>
</div> 