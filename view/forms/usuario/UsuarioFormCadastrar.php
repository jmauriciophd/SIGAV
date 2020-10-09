<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";

$usuario = new Usuario();
$usuario->setPerfil(new Perfil());
$perfilController = new PerfilController();

if(Util::editarDadosFormulario('cpf')) {
	$usuarioController = new UsuarioController();
	$usuario = $usuarioController->consultarUsuarioPorCpf($_GET['cpf']);
}
   	
function isEditavel(){
	global $usuario;
	return (Util::editarDadosFormulario('cpf') && $usuario != null && $usuario->getCpf() != null);
}

$listaArquivosCss = array("form.css", "pro-ini.css");
Util::includeArquivosCss($listaArquivosCss);

$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
						"jquery/jquery.maskedinput-1.3.min.js", 
						"jquery/jquery.validacao.js",
						"jquery/jquery.pstrength.js",
						"ajax/ajax.js", "mascaras.js", "funcoes.js", "validacao.campos.js"
				  );

Util::includeArquivosJs($listaArquivosJs);
?>
<script type="text/javascript">
var url = "../usuario/UsuarioFormCadastrar.php";

$(function(){
	
	$('#senha').pstrength();

	$("#senha").blur(function(){
		validarTamanhoSenha();
	});
	
	$("#confirma_senha").blur(function(){
		validarConfirmarSenha();
	});
	
	$("#cpf").blur(function(){
  		verificarCpf("Usuario");
	});

	$("#cadastrar").click(function(event) {
	    event.preventDefault();
	    if(validarCampos() && validarTamanhoSenha() && validarConfirmarSenha()){
		    senha = $("#senha").val();
	    	executarAcao("cadastrar&url="+url+"&senha="+senha, true); 
	    } else {
			return false;
		} 
	});
	
	$("#atualizar").click(function(event) {
	    event.preventDefault();
	    if(validarCampos()){
	    	executarAcao("atualizar&url="+url, true);
	    } else {
			return false;
		} 
	});

	$("#excluir").click(function(event) {
		event.preventDefault();
	    if(confirm("Deseja excluir o registro?")){
	   	 	executarAcao("excluir&url="+url, true);
	    }  else {
			return false;
		}
	});
	
	$("#novoCadastro").click(function(event) {
	    abrirPag(url);
	});
	
});

</script>
<!-- Header --> 
<div id="form" style="width: 578px;  position:absolute; top:50px;">
<div class="top-left"></div>
<div class="top-right"><div id="titulo_form"><?php echo (isEditavel()) ? "ATUALIZAÇÃO DO USUÁRIO" : "CADASTRO DE USUÁRIO"; ?></div></div>
<div class="inside"> 
<form method="post" action="../../../controller/UsuarioController.class.php">
      <table class="tabela" style="width: 100%;" cellpadding="0" cellspacing="6">
           <tr>
	   			<td colspan="6" align="center">
	   				<input type="hidden" name="nome_arquivo" value="<?php echo Util::getNomeArquivo(); ?>"/> 
	   				<div id="msgCampoObrigatorio">Preencha os campos obrigatórios!</div>
	   				<?php Util::exibirMsg("o", "Usuário"); ?>
	   		   </td>
	        </tr>
            <tr> 
            	<td width="34%"> 
      	        	<span class="asterico">*</span>
			        <label for="cpf" title="CPF">CPF:</label>
			    </td>
			    <td>
			    	<?php if(isEditavel()){ 
			    			echo $usuario->getCpf(); 
			    			echo '<input type="hidden" name="cpf" value="'.$usuario->getCpf().'"/>';
			    		   } else { ?>
				        <input type="text" name="cpf" id="cpf" style="width: 170px;" title="Informe o CPF" maxlength="11"/>
			      	<?php } ?>
		      	</td>
		    </tr>
      	    <tr>
	      	<td>
	      		<span class="asterico">*</span>
		        <label for="nome" title="Nome">Nome:</label>
		    </td>	
		     <td>
			    <input type="text" name="nome" id="nome" title="Informe o Nome" class="requerido" style="width: 170px;" maxlength="100" value="<?php Util::exibirValor($usuario->getNome()); ?>"/>
	      	</td>
      	   </tr>
        	<tr>
	      	<td>
	      		<span class="asterico">*</span>
		        <label for="email" title="E-mail">E-mail:</label>
		    </td>	
		     <td>
			    <input type="text" name="email" id="email" class="requerido" style="width: 170px;" title="Informe o E-mail" maxlength="100" value="<?php Util::exibirValor($usuario->getEmail()); ?>"/>
	      	</td>
      	</tr>
      	<?php if(!isEditavel('cpf')) { ?>
        <tr>
	     	 <td>
	     	 	<span class="asterico">*</span>
		        <label for="senha" title="Senha">Senha:</label>
		     </td>	
			 <td>   
		        <input type="password" name="senha" id="senha" style="width: 170px;" title="Informe a Senha" maxlength="20"/>
		     </td>
          </tr>
         <tr>
	       <td>
	       		<span class="asterico">*</span>
		        <label for="confirma_senha" title="Confirmar Senha">Confirmar Senha:</label>
		   </td>	
		    <td>   
		        <input type="password" name="confirma_senha" id="confirma_senha" style="width: 170px;" title="Informe a Confirmação da Senha" maxlength="20" />
		     </td>
         </tr>
         <?php } ?>
         <tr>
	     	 <td>
	     	 	<span class="asterico">*</span>
		        <label for="perfil" title="Perfil">Perfil:</label>
		     </td>	
		      <td colspan="2">   
	       	     <select id="perfil" name="perfil" style="width: 170px;" class="requerSelecao" title="Selecione um Perfil">
	                   <?php echo $perfilController->carregarComboPerfil($usuario->getPerfil()->getId()); ?> 
	             </select>
		       </td>
            </tr>
           <?php if(isEditavel('cpf')) { ?>	
           <tr>
	     	 <td>
		        <label id="situacao" title="Situação">Situação:</label>
		     </td>	
		      <td colspan="2">   
		        <input type="radio" name="situacao" id="ativo" value="A" <?php Util::marcarRadioButton("A", $usuario->getSituacao()); ?> /> Ativo
				<input type="radio" name="situacao" id="inativo" value="I" <?php Util::marcarRadioButton("I", $usuario->getSituacao()); ?> /> Inativo
		     </td>
          </tr>
        <?php } ?>
        <tr><td colspan="2">
        </tr>
        <tr>
		  <td colspan="2" align="center">
		  <?php if(isEditavel('cpf')) { ?>	
		  	<input type="button" name="novoCadastro" id="novoCadastro" class="botao" style="width: 120px;" title="Novo Cadastro" value="Novo Cadastro" />
		  	<input type="submit" name="atualizar" id="atualizar" title="Atualizar" value="Atualizar" <?php PermissaoController::desabilitarBotao("USUÁRIO", "atualizar"); ?>/>
		  	<input type="button" name="excluir" id="excluir" title="Excluir" value="Excluir" <?php PermissaoController::desabilitarBotao("USUÁRIO", "excluir"); ?>/> 
		  	<input type="button" name="cancelar" id="cancelar" class="botao" title="Cancelar" value="Cancelar" />
		  <?php } else{ ?>	
		  	<input type="hidden" name="situacao" id="ativo" value="A" />
		  	<input type="submit" name="cadastrar" id="cadastrar" title="Cadastrar" value="Cadastrar" <?php PermissaoController::desabilitarBotao("USUÁRIO", "cadastrar"); ?>/> 
		  	<input type="button" name="cancelar" id="cancelar" class="botao" title="Cancelar" value="Cancelar" />
		  <?php } ?>
	   	  </td>
      	</tr>
      </table>
  </form>
  <!-- Trailler -->
</div>
<div class="bottom-left"> </div>
<div class="bottom-right" style="padding-left:35px;"></div>
</div>