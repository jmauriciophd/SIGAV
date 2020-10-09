<?php
require_once dirname(__FILE__) . "/../../../libloader.php";

$usuarioController = new UsuarioController();
$result = $usuarioController->consultarTodosUsuarios();
$listaUsuarios = $result->getElements();

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
			    $('#tabelaUsuario').dataTable({
			    	"bJQueryUI": true, //muda o tema da pagina
			    	"bProcessing": true,
			        "sPaginationType": "full_numbers", //muda o tipo da paginacao
			        "oLanguage": {"sUrl": "../../js/jquery/datatables.Portuguese.txt"}, //traduz os textos da biblioteca para portugues
			    	"aaSorting": [[ 1, "asc" ]] //ordenacao inicial
			    });
			});
		</script>
<div id="container" >
<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabelaUsuario">
	<thead>
		<tr class='even gradeC'>
			<th>CPF</th>
			<th>NOME</th>
			<th>PERFIL</th>
			<th>SITUAÇÃO</th>
			<th>OPERAÇÕES</th>
		</tr>
	</thead>
	<tbody>
	   <?php 
    		foreach ($listaUsuarios as $indice => $usuario){
			  echo "<tr class='even gradeC'>"
			  	 ."<td>" . $usuario->getCpf() . "</td>"
				 ."<td>" . $usuario->getNome() . "</td>"
				 ."<td>" . $usuario->getPerfil()->getNome() . "</td>"
				 ."<td>" . $usuario->getSituacao() . "</td>"
				 ."<td>" 
				 ."<a href='#' onclick=\"abrirPag('../usuario/UsuarioFormCadastrar.php?editar&cpf={$usuario->getCpf()}')\">Alterar</a>"
				 ."</td>"
				 ."</tr>";
		    }
    	?>
	</tbody>
</table>
</div>
</div>