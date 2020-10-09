<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";

		$fornecedor = new Fornecedor();
		$fornecedor->setContato(new Contato());
		$fornecedor->setEndereco(new Endereco());
		$fornecedorController = new FornecedorController();

if(Util::editarDadosFormulario('cnpj')) {
	$fornecedor = $fornecedorController->consultarFornecedorPorCnpj($_GET['cnpj']);
}

function isEditavel(){
	global $fornecedor;
	return (Util::editarDadosFormulario('cnpj') && $fornecedor != null && $fornecedor->getCnpj() != null);
}

	$listaArquivosCss = array("demo_page.css","demo_table.css",
	"demo_table_jui.css","jquery-ui-1.8.4.custom.css","jquery.autocomplete.css",
	"form.css"
	 );
	Util::includeArquivosCss($listaArquivosCss);

	$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
							"jquery/jquery.maskedinput-1.3.min.js", 
							"jquery/jquery.autocomplete.js",
							"jquery/jquery.validacao.js",
							"jquery/jquery.cep-1.0.min.js",
	                        "jquery/jquery.dataTables.js",
							"ajax/ajax.js",
							"mascaras.js", "funcoes.js", "cep.js", "validacao.campos.js"
					 );

	Util::includeArquivosJs($listaArquivosJs);

?>
	<script type="text/javascript">
    	var url = "../fornecedor/FornecedorFormCadastrar.php";
	  
		$(function(){
			$("#cpf").blur(function(event){
		  		verificarCnpj("Fornecedor");
			});

			$("#cadastrar").click(function(event) {
			    event.preventDefault();
			    if(validarCampos()){
			    	executarAcao("cadastrar&url="+url, true); 
			    }  else {
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
			    if(confirm("Deseja excluir o registro?")){
			    	event.preventDefault();
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
 <div id="form" style="width: 900px;  position:absolute; top:50px;">
  <div class="top-left"></div>
	<div class="top-right">
	<div id="titulo_form">
	   <?php echo (isEditavel('cnpj')) ? "ATUALIZAÇÃO DO FORNECEDOR" : "CADASTRO DE FORNECEDOR"; ?> 
	 </div></div>
 <div class="inside">
<form id="fornecedor" method="post" action="../../../controller/FornecedorController.class.php"  enctype="multipart/form-data">
       <table class="tabela" width="100%" cellpadding="0" cellspacing="4">
	    <tr>
	   		<td colspan="6" align="center">
	   			<input type="hidden" name="nome_arquivo" value="<?php echo Util::getNomeArquivo(); ?>"/> 
	   			<div id="msgCampoObrigatorio">Preencha os campos obrigatórios!</div>
	   			<?php Util::exibirMsg("o", "fornecedor"); ?>
	   		</td>
	      </tr>
	      <tr>
   			<td colspan="6" align="left" class="cabecalho2"><strong title="Dados Básicos">Dados Básicos</strong></td>
		  </tr>
		  <tr>
      	     <td> 
			  <label for="cnpj" title="CNPJ">CNPJ</label>
			 </td>
			 <td>
			   	<?php if(isEditavel()){ 
			 		echo $fornecedor->getCnpj(); 
			 		echo '<input type="hidden" name="cnpj" value="'.$fornecedor->getCnpj().'"/>';
			   		   } else { ?>
			        <input type="text" name="cnpj" id="cnpj" title="Informe o CNPJ" maxlength="20"/>
			      	<span class="asterico">*</span>
			         	<?php } ?>
		     </td>
		     <td>
		        <label for="razao_social" title="Razão Social">Razão Social:</label>
		     </td>	
			 <td>   
		        <input type="text" name="razao_social" id="razao_social" class="requerido" title="Informe a Razão Social"  maxlength="100" value="<?php Util::exibirValor($fornecedor->getRazaoSocial()); ?>"/>
		      	<span class="asterico">*</span>
		     </td>
           </tr>
           <tr>
	        <td>
		        <label for="nome_fantasia" title="Nome Fantasia">Nome Fantasia:</label>
		    </td>	
		    <td>     
		        <input type="text" name="nome_fantasia" id="nome_fantasia" class="requerido" title="Informe o Nome Fantasia"  maxlength="100" value="<?php Util::exibirValor($fornecedor->getNomeFantasia()); ?>" />
		      	<span class="asterico">*</span>
	        </td> 
	        <td>
	        <label for="inscricao_estadual" title="Inscrição Estadual">Inscrição Estadual:</label>
	        </td>	
		    <td>  
	        <input type="text" name="inscricao_estadual" id="inscricao_estadual" class="requerido" title="Informe a Inscrição Estadual"  maxlength="100" value="<?php Util::exibirValor($fornecedor->getInscricaoEstadual()); ?>" />
	      	<span class="asterico">*</span>
	        </td>
        </tr>
        <tr>
	   		<td colspan="6" align="left" class="cabecalho2"><strong title="Dados do Endereço">DADOS DO ENDEREÇO</strong></td>
		 </tr>
	      <tr>
	        <td>
		        <label for="cep" title="CEP">CEP:</label>
		      </td>	
			  <td colspan="5">   
		        <input type="text" name="cep" id="cep" class="requerido" title="Informe o CEP" maxlength="50" value="<?php Util::exibirValor($fornecedor->getEndereco()->getCep()); ?>"/>
		      	<span class="asterico">*</span>
		      	<img src="../../img/icons/lupa.png" id="buscarEnderecoPorCep" alt="Pesquisar Endereço" width="17px" height="17px" title="Pesquisar Endereço pelo CEP"/>
		      	<div id="loading" style="display:none;">
			      	<img src="../../img/ajax-loader.gif" alt="Pesquisando Endereço..."/>
			      	<label for="pesquisando" title="Pesquisando Endereço pelo CEP informado. Aguarde...">Pesquisando Endereço...</label>
		      	</div>
		      </td>
	      </tr>
	      <tr>
		      <td >
		        <label for="endereco" title="Endereço">Endereço:</label>
		      </td>	
			  <td >
		        <input type="text" name="endereco" id="endereco" class="requerido" title="Informe o Endereço"  maxlength="100" style="width: 200px" value="<?php  Util::exibirValor($fornecedor->getEndereco()->getLogradouro()); ?>"/>
		      	<span class="asterico">*</span>
		      </td>
		      <td>
		        <label for="numero" title="Número">Número:</label>
		      </td>	
			  <td>
		        <input type="text" name="numero" id="numero" class="requerido" title="Informe o Número"  maxlength="10" style="width: 138px" value="<?php   Util::exibirValor($fornecedor->getEndereco()->getNumero()); ?>"/>
		      	<span class="asterico">*</span>
		      </td>
		     </tr>
		     <tr> 
		      <td>
		        <label for="bairro" title="Bairro">Bairro:</label>
		      </td>	
			  <td >
		        <input type="text" name="bairro" id="bairro" class="requerido" title="Informe o Bairro"  maxlength="100" style="width: 200px" value="<?php Util::exibirValor($fornecedor->getEndereco()->getBairro()); ?>"/>
		     	<span class="asterico">*</span>
		      </td>
             <td>
	        <label for="cidade" title="Cidade">Cidade:</label>
	       </td>	
		    <td>
	        <input type="text" name="cidade" id="cidade" class="requerido" title="Informe a Cidade"  maxlength="100" style="width: 200px" value="<?php  Util::exibirValor($fornecedor->getEndereco()->getCidade()); ?>"/>
	      	<span class="asterico">*</span>
	        </td>
	       </tr>
	       <tr>
	        <td>
	        <label for="estado" title="Estado">Estado:</label>
	        </td>	
		    <td>
	        <select name="estado" id="estado" class="requerSelecao" title="Selecione um Estado">
			        	    <option value="" > Selecione </option>
			        		<?php 
						      Util::montarOpcoesSelect(Util::listaEstadosBrasileiro(), $fornecedor->getEndereco()->getEstado(), 1);
						    ?>
			        </select>
			        
	        <span class="asterico">*</span>
	      </td>
	      <td>
	        <label for="complemento" title="Complemento">Complemento:</label>
	      </td>	
		  <td>
	        <input type="text" name="complemento" id="complemento" title="Informe o Complemento do Endereço"  maxlength="10" style="width: 200px" value="<?php  Util::exibirValor($fornecedor->getEndereco()->getComplemento()); ?>"/>
	      </td>
	  	</tr>
	    <tr>
	   			<td colspan="4" align="left" class="cabecalho2"><strong title="Dados de Contato">DADOS DO CONTATO</strong></td>
		  </tr>
	      <tr>
		       <td width="10%">
			      <label for="email" title="E-mail">E-mail:</label>
			   </td>	
			   <td width="5%">   
			      <input type="text" name="email" id="email" class="requerido" title="Informe o E-mail" maxlength="100" value="<?php Util::exibirValor($fornecedor->getContato()->getEmail()); ?>"/>
		       	  <span class="asterico">*</span>	
		       </td>
		      <td width="10%">
		        <label for="tel_comercial" title="Telefone Comercial">Tel. Comercial:</label>
		      </td>	
			  <td width="20%">  
		        <input type="text" name="tel_comercial" id="tel_comercial" class="requerido" title="Informe o Telefone Comercial" maxlength="10" value="<?php Util::exibirValor($fornecedor->getContato()->getTelComercial()); ?>"/>
		      	<span class="asterico">*</span>
		      </td>
	      </tr>
          <tr>
          	  <td colspan="4">
          	    <span class="asterico" title="* Campos obrigatórios!">* Campos obrigatórios!</span><p />
				  <?php if(isEditavel()){	?>
		  			<div id="botoes" style="margin-left:40px;">
		  			<input type="button" name="novoCadastro" id="novoCadastro" class="botao" style="width: 120px;" title="Novo Cadastro" value="Novo Cadastro" />
				  	<input type="submit" name="atualizar" id="atualizar" title="Atualizar" value="Atualizar" <?php PermissaoController::desabilitarBotao("FORNECEDOR", "atualizar"); ?>/> &nbsp;
				  	<input type="button" name="excluir" id="excluir" title="Excluir" value="Excluir" <?php PermissaoController::desabilitarBotao("FORNECEDOR", "excluir"); ?>/> 
		  			<input type="button" class="botao" name="cancelar" id="cancelar" title="Cancelar" value="Cancelar" />
			   	 <?php } else{ ?>
			   	 	<input type="submit" name="cadastrar" id="cadastrar" title="Cadastrar" value="Cadastrar" <?php PermissaoController::desabilitarBotao("FORNECEDOR", "cadastrar"); ?>/> &nbsp;
				  	<input type="button" class="botao" name="cancelar" id="cancelar" title="Cancelar" value="Cancelar" />
			   	 <?php } ?>
			   	  </div>
			   	  </td>
		      </tr>
	      </table>
     </form>
	<!-- Trailler -->
    </div>
	<div class="bottom-left"></div>
	<div class="bottom-right" style="padding-left:35px;"></div>
   </div>