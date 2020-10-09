<?php 
	require_once dirname(__FILE__) . "/../../../libloader.php";
	
	$perfil = new Perfil();
	$perfilController = new PerfilController();
	
	$result = $perfilController->consultarTodosPerfis();
	$listaPerfis = $result->getElements();
	
	if(Util::editarDadosFormulario('id')) {
		$perfil = $perfilController->consultarPerfilPorId($_GET['id']);
	}

	$listaArquivosCss = array("form.css", "demo_page.css", "demo_table.css", "demo_table_jui.css", "jquery-ui-1.8.4.custom.css");
	Util::includeArquivosCss($listaArquivosCss);

	$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
							"jquery/jquery.maskedinput-1.3.min.js", 
							"jquery/jquery.validacao.js",
							"jquery/jquery.dataTables.js",
							"ajax/ajax.js", "mascaras.js", "funcoes.js", "validacao.campos.js"
					 );

	Util::includeArquivosJs($listaArquivosJs);
?>
<script type="text/javascript" charset="iso-8859-1">
var url = "../perfil/ManterPerfil.php";

$(document).ready(function(){
    $('#tabelaPerfil').dataTable({
    	"bJQueryUI": true, //muda o tema da pagina
    	"bProcessing": true,
        "sPaginationType": "full_numbers", //muda o tipo da paginacao
        "oLanguage": {"sUrl": "../../js/jquery/datatables.Portuguese.txt"}, //traduz os textos da biblioteca para portugues
    	"aaSorting": [[ 2, "asc" ]] //ordenacao inicial
    });

	$("#cadastrar").click(function(event) {
	    event.preventDefault();
	    executarAcao("cadastrar", true);    
	});

	$("#atualizar").click(function(event) {
	    event.preventDefault();
	    executarAcao("atualizar&url="+url, true);
	});
	
	$("#excluir").click(function(event) {
		if(confirm("Deseja excluir o registro?")){
		    event.preventDefault();
		    executarAcao("excluir&url="+url, true);
		}
	});

	$("#novoCadastro").click(function(event) {
		event.preventDefault();
	    abrirPag(url);
	});
	
});

function alterarLinha(id){
	executarAcao("carregarPerfilParaEdicao&url=../perfil/ManterPerfil.php&idPerfilLinha="+id, true);
}

function excluirLinha(id){
	if(confirm("Deseja excluir o registro?")){ 
		executarAcao("excluir&id="+id+"&url=../perfil/ManterPerfil.php", true); 
	} else { 
		return false; 
	}
}
</script>
<!-- Header -->
 <div id="form" style="width: 856px;">
 <div class="top-left"></div>
	<div class="top-right"><div id="titulo_form">
			<?php if(Util::editarDadosFormulario('id'))
	   				echo "ATUALIZAÇÃO DO PERFIL";
   				  else
   				  	echo "CADASTRO DE PERFIL";
	   		?></div></div>
	<div class="inside"> 
  <!-- Content -->   
<form method="post" action="../../../controller/PerfilController.class.php" accept-charset="iso-8859-1">
      <table class="tabela" align="center" style="width: 786px;" cellpadding="0" cellspacing="4">
         <tr>
	   		<td colspan="2" align="center"> 
	   			<div id="msgCampoObrigatorio">Preencha os campos obrigatorios!</div>
	   			<?php Util::exibirMsg("o", "perfil"); ?>
	   			<input type="hidden" name="nome_arquivo" value="<?php echo Util::getNomeArquivo(); ?>"/>
	   		</td>
	    </tr>
	    <tr><td colspan="2"></td></tr>
      	<tr>
	      	<td>
		        <label for="perfil" title="Perfil">Perfil:</label>
		    </td>	
		    <td>		        		
		        <input type="text" name="perfil" id="perfil" class="requerido" title="Informe o Nome do Perfil" size="12" maxlength="100" value="<?php Util::exibirValor($perfil->getNome()); ?>"/>
	      	    <span class="asterico">*</span>
	      	</td>
      	</tr>
        <tr>
	     	 <td valign="top">
		        <label id="descricao" title="Descrição">Descrição:</label>
		     </td>	
			 <td>   
		        <textarea name="descricao" id="descricao" title="Informe a Descrição" class="requerido" cols="35" rows="5"><?php Util::exibirValor($perfil->getDescricao()); ?></textarea>
		      	<span class="asterico">*</span>
		     </td>
        </tr>
        <tr><td colspan="2"><p></p></td></tr>
        <tr>
		  <td colspan="2" align="center">
		  <?php if(Util::editarDadosFormulario('id')) { ?>	
		  	<input type="hidden" name="id" value="<?php Util::exibirValor($perfil->getId()); ?>"/>
		  	<input type="button" name="novoCadastro" id="novoCadastro" class="botao" style="width: 120px;" title="Novo Cadastro" value="Novo Cadastro" />
		  	<input type="submit" name="atualizar" id="atualizar" title="Atualizar" value="Atualizar" <?php PermissaoController::desabilitarBotao("PERFIL", "atualizar"); ?>/>
		  	<input type="button" name="excluir" id="excluir" title="Excluir" value="Excluir" <?php PermissaoController::desabilitarBotao("PERFIL", "excluir"); ?>/> 
		  <?php } else { ?>	
		  	<input name="cadastrar" type="submit" id="cadastrar" title="Cadastrar" value="Cadastrar" <?php PermissaoController::desabilitarBotao("PERFIL", "cadastrar"); ?>/> 
		  	<input name="cancelar" type="button" id="cancelar" class="botao" title="Cancelar" value="Cancelar" />
		  <?php } ?>
	   	  </td>
      </tr>
      </table>
    </form>
   <!-- Trailler -->
   
<div id="container">
<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabelaPerfil">
	<thead>
		<tr class='even gradeC'>
			<th>NOME</th>
			<th>DESCRIÇÃO</th>
			<th>OPERAÇÕES</th>
		</tr>
	</thead>
	<tbody>
	   <?php 
    		foreach ($listaPerfis as $indice => $perfil) {
			  echo "<tr class='even gradeC'>"
				 ."<td>" . $perfil->getNome() . "</td>"
				 ."<td>" . $perfil->getDescricao() . "</td>"
				 ."<td align='center'>" 
				 ." <a href='#' onclick='alterarLinha(".$perfil->getId().")'>Alterar</a> | "
				 ." <a href='#' onclick='excluirLinha(".$perfil->getId().");'>Excluir</a>"
				 ."</td>"
				 ."</tr>";
		    }
    	?>
	</tbody>
</table>
</div>
</div>
 </div>
	<div class="bottom-left"></div>
	<div class="bottom-right" style="padding-left:35px;"></div>
</div>