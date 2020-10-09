<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";

$listaArquivosCss = array("form.css", "pro-ini.css");
Util::includeArquivosCss($listaArquivosCss);

$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
						"jquery/jquery.validacao.js",
						"jquery/jquery.pstrength.js",
						"ajax/ajax.js", "funcoes.js", "validacao.campos.js"
				  );

Util::includeArquivosJs($listaArquivosJs);
?>
<script type="text/javascript">
var url = "../usuario/SenhaFormAlterar.php";

$(function(){
	
	$("#senha").pstrength();

	$("#confirma_senha").blur(function(){
  		verificarSenha();
	});
	
	$("#alterar").click(function(event) {
	    event.preventDefault();
	    senhaAtual = "&senha_atual="+$("#senha_atual").val();
	    senha = "&senha="+$("#senha").val();
	    executarAcao("alterarSenha&url="+url+senhaAtual+senha, true);
	});
});

function verificarSenha(){
	if($("#senha").val() != $("#confirma_senha").val()){
		alert("A confirmação da senha não confere com a senha digitada!");
		$("#senha").val("");
		$("#confirma_senha").val("");
		$("#senha").focus();
		return false;
	} else{
		return true;
	}
}
</script>
<!-- Header --> 
  <!-- Header -->
  <div id="form"  style="width:500px; position:absolute; top:50px;">
 <div class="top-left"></div>
	<div class="top-right"><div id="titulo_form">ALTERAÇÃO DE SENHA</div></div>
	<div class="inside"> 
  <!-- Content -->   
 
<form style="left:410px;" method="post" action="../../../controller/UsuarioController.class.php">
<table class="tabela" style="width:100%;">
		<tr>
   			<td colspan="6" align="center">
   				<input type="hidden" name="nome_arquivo" value="<?php echo Util::getNomeArquivo(); ?>"/> 
   				<div id="msgCampoObrigatorio">Preencha os campos obrigatórios!</div>
   				<?php Util::exibirMsg("a", "Senha"); ?>
   		   </td>
        </tr>
<tr>
  <td width="209" valign="middle" style="height:20px;">Senha Atual:</td>
  <td width="278"><input name="senha_atual" type="password" id="senha_atual" style="width:200px;" maxlength="20" /></td>
</tr>
<tr>
   <td style="height:20px">Nova Senha:</td>
   <td>
    <input name="senha" type="password" id="senha" style="width:200px;" maxlength="20"/>
   </td>
</tr>
<tr>
  <td style="height:20px">Confirmar Nova Senha:</td>
  <td><input name="confirma_senha" type="password" id="confirma_senha" style="width:200px;" maxlength="20"/>
  </td>
</tr>
<tr>
  <td height="41" colspan="2" align="center" valign="middle">
    <input type="submit" class="botao" style="width:110px;" name="alterar" id="alterar" value="Alterar Senha"/> 
    <input type="button" class="botao"  name="cancelar" id="cancelar" value="Cancelar"/> 
  </td>
</tr>
</table>
</form>
 <!-- Trailler -->
 </div>
	<div class="bottom-left"></div>
	<div class="bottom-right" style="padding-left:35px;"></div>
</div>