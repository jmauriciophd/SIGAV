<?php
require_once dirname(__FILE__) . "/../../../libloader.php";

$perfilController = new PerfilController();
$comboPerfil = $perfilController->carregarComboPerfil();
$perfil = $perfilController->consultarPerfilPorId(1);

$permissaoControler = new PermissaoController();
$permissao1=$permissaoControler->consultarPermissaoPorPerfil(1);

$aplicacaoController = new AplicacaoController();
$result = $aplicacaoController->consultarTodasAplicacoes();
$listaAplicacoes = $result->getElements();

$listaArquivosCss = array("demo_page.css", "demo_table.css", "demo_table_jui.css", "jquery-ui-1.8.4.custom.css");
Util::includeArquivosCss($listaArquivosCss);

$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
						"jquery/jquery.dataTables.js",
						"jquery/jquery.validacao.js",
						"ajax/ajax.js", "funcoes.js", "permissoes.js", "validacao.campos.js"
				  );
				 
Util::includeArquivosJs($listaArquivosJs);
?>
<!-- Header --> 
<div id="form" style="width: 1028px; left:6%; position:absolute; top:50px;">
<div class="top-left"></div>
<div class="top-right">
<div id="titulo_form">Cadastro de Permissões de Acesso</div>
</div>
<div class="inside"> 
<!-- <div id="container" style="width:1200px; position:absolute; left:100px;">
<div id="demo"> -->
<div id='msg' style="text-align: center;"></div>
<form method="post" action="../../../controller/PermissaoController.class.php">
	<input type="hidden" name="nome_arquivo" value="<?php echo Util::getNomeArquivo(); ?>"/>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabelaPerfil">
	    	<tr class="even gradeC" >
			 <td><label for="perfil"><strong>Perfil:</strong> </label></td>
             <td><select id="perfil" name="perfil" style="width: 240px;" class="requerido" title="Selecione um Perfil">
		     <?php echo $comboPerfil; ?>
	         </select>
	         <span class="asterico">*</span>
	         </td>
	         </tr>
	         <tr class="even gradeC" >
		  	 <td><strong>Nome Perfil:</strong></td>
		  	 <td><span id="perfilNome">Selecione um perfil</span></td>
		  	 </tr>
		  	 <tr class="even gradeC">
		  	 <td><strong>Descricão:</strong></td>
			 <td><span id="descricao">Selecione um perfil</span></td>
			 </tr>
	</table>

    <table cellpadding="0" cellspacing="0" border="0" class="display" id="tabelaAplicacao">
	  <thead>
		<tr class="even gradeC">
			<th><input type="checkbox" name="marcarTodosCBAcesso" id="marcarTodosCBAcesso" title="Selecionar todos os checkboxs de permissão de acesso da página atual"/></th> 
			<th width="20%">Aplicação</th>
			<th>Privilégio para Cadastrar
				<div style='text-align: center;'><input type="checkbox" name="marcarTodosCBCadastro" id="marcarTodosCBCadastro" title="Selecionar todos os checkboxs de permissão de cadastro da página atual"/></div>
			</th>
			<th>Privilégio para Alterar<br />
				<input type="checkbox" name="marcarTodosCBAltera" id="marcarTodosCBAltera" title="Selecionar todos os checkboxs de permissão de alteração da página atual"/>
			</th>
			<th>Privilégio para Excluir<br />
				<input type="checkbox" name="marcarTodosCBExclui" id="marcarTodosCBExclui" title="Selecionar todos os checkboxs de permissão de exclusão da página atual"/>
			</th>
			<th>Privilégio para Consultar<br />
				<input type="checkbox" name="marcarTodosCBConsulta" id="marcarTodosCBConsulta" title="Selecionar todos os checkboxs de permissão de consulta da página atual"/>
			</th>
			<th>Privilégio para Imprimir<br />
				<input type="checkbox" name="marcarTodosCBImprimi" id="marcarTodosCBImprimi" title="Selecionar todos os checkboxs de permissão de impressão da página atual"/>
			</th>
		</tr>
	  </thead>	
	  <tbody>
		<?php foreach ($listaAplicacoes as $indice => $aplicacao){ ?>
			  <tr class='linha'>
			  	  <td><input type='checkbox' name='acesso[]' class='checkAcesso' id='acesso<?php echo $indice; ?>' value='<?php echo $aplicacao->getId();?>'/></td>
			  	  <td><input type='hidden' name='aplicacao[]' id='aplicacao<?php echo $indice; ?>' value='<?php echo $aplicacao->getId();?>'/>
			  	  <?php echo $aplicacao->getNomeAplicacao();?></td>
				  <td style='text-align: center;'><input type='checkbox' name='cadastra[]' class='checkCadastra' id='cadastra<?php echo $indice; ?>' value='<?php echo $aplicacao->getId();?>'/></td>
				  <td style='text-align: center;'><input type='checkbox' name='altera[]'   class='checkAltera' id='altera<?php echo $indice; ?>' value='<?php echo $aplicacao->getId();?>'/></td>
				  <td style='text-align: center;'><input type='checkbox' name='exclui[]'   class='checkExclui' id='exclui<?php echo $indice; ?>' value='<?php echo $aplicacao->getId();?>'/></td>
				  <td style='text-align: center;'><input type='checkbox' name='consulta[]' class='checkConsulta' id='consulta<?php echo $indice; ?>' value='<?php echo $aplicacao->getId();?>'/></td>
				  <td style='text-align: center;'><input type='checkbox' name='imprimi[]'  class='checkImprimi' id='imprimi<?php echo $indice; ?>' value='<?php echo $aplicacao->getId();?>'/></td>
			 </tr>
		  <?php } ?>
	    </tbody>
        </table>
       	  
       	<table class="tabelaInterna" width="953"  cellpadding="0" cellspacing="4">
		      <tr>
				  <td align="center">	
				  	<input name="cadastrar" type="button" id="cadastrar" title="Salvar Selecionados" value="Salvar" <?php PermissaoController::desabilitarBotao("PERMISSÕES DE ACESSO", "cadastrar"); ?>/> &nbsp;
				  	<input name="cancelar" type="button" id="cancelar" class="botao" title="Cancelar" value="Cancelar" />
			     	<input type="hidden" name="id_permissao" id="id_permissao"/>
			     	<input type="hidden" name="qtdeAplicacoes" value="<?php echo $result->getSize(); ?>"/>
			     </td>
		      </tr>
	   </table>
</form>
<!-- </div></div> -->
<!-- Trailler -->
</div>
<div class="bottom-left"></div>
<div class="bottom-right" style="padding-left:35px;"></div>
</div>