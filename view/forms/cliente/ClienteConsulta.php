<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";
      
    $cliente = new Cliente();
	$cliente->setContato(new Contato());
	$cliente->setEndereco(new Endereco());
	
    $clienteController = new ClienteController();
    $result = $clienteController->consultarTodosClientes();
    $listaClientes  = $result->getElements();
    
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
			    $('#tabelaCliente').dataTable({
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
			function detalharCliente(cpf){
				var maskHeight = $(document).height();
				var maskWidth = $(window).width();
				var idO  = $("#opacidadeTela");

				idO.show();
		    	$("#divDetalharCliente").show().load("../cliente/ClienteDetalhar.php?cpf="+cpf);
		    	
		    	//idO.css({'width':maskWidth,'height':maskHeight});
		    	idO.fadeIn("slow");
		}
</script>
<div id="container" style="width:1200px;" >
<div id="demo">
<table id="tabelaCliente" cellpadding="0" cellspacing="0" border="0" class="display" >
	<thead>
		<tr class='even gradeC'>
				<th>CPF</th>
    			<th>RG</th>
    			<th>NOME</th>
    			<th>DATA DE NASCIMENTO</th>
    			<th>ESTADO CIVIL</th>
    			<th>SEXO</th>    			
    			<th>ENDERECO</th>
    			<th>TELEFONE CELULAR</th>    			
    			<th>OPERAÇÕES</th>
		</tr>
	</thead>
	<tbody>
	   <?php 
    		foreach ($listaClientes as $indice => $cliente){
			  echo "<tr class='even gradeC'>"
			  	 ."<td>" . $cliente->getCpf() . "</td>"
			  	 ."<td>" . $cliente->getRg()." - ".$cliente->getOrgaoExpedicao()."/".$cliente-> getUfExpedicao()  ."</td>"
				 ."<td>" . $cliente->getNome()   . "</td>"
				 ."<td>" . $cliente->getDataNascimento() . "</td>"
				 ."<td>" . $cliente->getEstadoCivil()   . "</td>"
				 ."<td>" . $cliente->getSexo()          . "</td>"
				 ."<td>" . $cliente->getEndereco()->getLogradouro() . "</td>"
				 ."<td>" . $cliente->getContato()->getTelCelular()  . "</td>"
				 ."<td>
				 		<a href='#' onclick=\"detalharCliente('".$cliente->getCpf()."');\" >Detalhar</a> |
				 		<a href='#' onclick=\"abrirPag('../cliente/ClienteFormCadastrar.php?editar&cpf={$cliente->getCpf()}')\">Alterar</a> |
				 		<a href='#' onclick=\"executarAcao('excluir&cpf={$cliente->getCpf()}') \">Excluir</a>"
				   ."</td>"
				 ."</tr>";
		    }
    	?>
			</tbody>
		</table>
		</div>
		</div>
	<!-- popup modal -->
   <div id="opacidadeTela">
	<div id="divDetalharCliente" style="z-index:2; text-align: center; margin-top:0px; display: none;">
	</div>
</div> 