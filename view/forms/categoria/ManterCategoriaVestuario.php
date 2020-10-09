<?php
require_once dirname(__FILE__) . "/../../../libloader.php";
$categoriaController = new CategoriaController();
$result = $categoriaController->consultarTodasCategorias();
$listaCategorias  = $result->getElements();

$listaArquivosCss = array("form.css","demo_page.css","demo_table.css","demo_table_jui.css","jquery-ui-1.8.4.custom.css");

Util::includeArquivosCss($listaArquivosCss);

	$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
							"jquery/jquery.dataTables.js",
							"jquery/jquery.maskedinput-1.3.min.js",
							"ajax/bibliotecaAjax.js",
							"categoria.js", 
							"funcoes.js"
					 );

	Util::includeArquivosJs($listaArquivosJs);

?>
<script type="text/javascript" charset="iso-8859-1">
	$(document).ready(function(){
	    $('#tabela').dataTable({
	    	"bJQueryUI": true, //muda o tema da pagina
	    	"bProcessing": true,
	        "sPaginationType": "full_numbers", //muda o tipo da paginacao
	        "aoColumnDefs": [{"bSortable": false, "aTargets": [ 2 ]}],
	        "oLanguage": {"sUrl": "../../js/jquery/datatables.Portuguese.txt"}, //traduz os textos da biblioteca para portugues
	    	"aaSorting": [[ 2, "asc" ]] //ordenacao inicial
	    });
	});
</script>
 <div id="form" style="width: 900px; position:absolute; top:50px;">
 	<div class="top-left"></div>
	<div class="top-right">
		<div id="titulo_form">CADASTRO DE CATEGORIA DE VESTU&Aacute;RIO</div>
    </div>
	<div class="inside">
		<form id="categoria">
			<table  id="tabela" class="display, tabela" style="width: 100%;" cellpadding="0" cellspacing="0">
			<thead>
				<tr><td colspan='3'><div id="avisos"></div></td></tr>
				<tr class='even gradeC'>
						<th>CÓDIGO</th>
		    			<th>CATEGORIA</th>
		    			<th>OPERAÇÕES</th>
				</tr>
			</thead>
			<tbody>
    			  <?php 
    					foreach ($listaCategorias as $indice => $categoria){
    						$idLinha = "linha".$indice;
    						$codigo = $categoria->getCodigo();
    						$descricao = $categoria->getDescricao();
							echo '<tr id="'.$idLinha.'">'
								 ."<td class='linhas'>" . $codigo . "</td>"
								 ."<td class='linhas'>" . $descricao . "</td>"
							     ."<td class='linhas' style=\"text-align: center;\">"
							     ."  <a href='#' onclick=\"EditarLinha('$idLinha', '$codigo');\"><img src='../../img/editar.gif' alt='Editar' title='Editar'></a> &nbsp;&nbsp;&nbsp;"
							     ."  <a href='#' onclick=\"ExcluirLinha('$idLinha', '$codigo');\"><img src='../../img/excluir.gif' alt='Excluir' title='Excluir'></a>"
						         ."</td></tr>";
		    			}
				   ?>
			 </tbody>
			 <tfoot>
			 	   <tr>
					  <td id="novo" colspan="3">
					  	<input type="button" name="novaCategoria" value="Nova Categoria" onclick="NovoRegistro();" style="width: 120px;" title="Nova Categoria" <?php PermissaoController::desabilitarBotao("CATEGORIA", "cadastrar"); ?>/>
					  </td>
				   </tr>
			 </tfoot>
			</table>
	</form>
	<!-- Trailler -->
 </div>
	<div class="bottom-left"></div>
	<div class="bottom-right" style="padding-left:35px;"></div>
</div>