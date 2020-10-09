<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";

$funcionario = new Funcionario();
$funcionario->setContato(new Contato());
$funcionario->setEndereco(new Endereco());

if(Util::editarDadosFormulario('cpf')) {
	$funcionarioController = new FuncionarioController();
	$funcionario = $funcionarioController->consultarFuncionarioPorCpf($_GET['cpf']);
}

function isEditavel(){
	global $funcionario;
	return (Util::editarDadosFormulario('cpf') && $funcionario != null && $funcionario->getCpf() != null);
}

$listaArquivosCss = array("form.css", "calendario/smoothness/ui.all.css");
Util::includeArquivosCss($listaArquivosCss);

$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
						"jquery/jquery.maskedinput-1.3.min.js", 
						"jquery/jquery.validacao.js",
						"jquery/jquery.cep-1.0.min.js",
						"jquery/jquery.price_format.1.7.js",
						"calendario/ui.datepicker.js", 
						"calendario/ui.datepicker-pt-BR.js",
						"ajax/ajax.js",
						"mascaras.js", "funcoes.js", "cep.js", "validacao.campos.js", "calendario.js"
				 );

Util::includeArquivosJs($listaArquivosJs);
?>
<script type="text/javascript">
	var url = "../funcionario/FuncionarioFormCadastrar.php";

	$(function(){
		$("#cpf").blur(function(event){
	  		verificarCpf("Funcionario");
		});

		$("#cadastrar").click(function(event) {
		    event.preventDefault();
		    if(validarCampos()){
		    	executarAcao("cadastrar&url="+url); 
		    } else {
				return false;
			} 
		});
		$("#atualizar").click(function(event) {
		    event.preventDefault();
		    executarAcao("atualizar&url="+url);
		});
		
		$("#excluir").click(function(event) {
		    if(confirm("Deseja excluir o registro?")){
		    	event.preventDefault();
		   	 	executarAcao("excluir&url="+url);
		    }  else {
				return false;
			}
		});
		
		$("#novoCadastro").click(function(event) {
		    abrirPag(url);
		});

		$("#salario").priceFormat({
	        prefix: 'R$ ',
	        centsSeparator: ',',
	        thousandsSeparator: '.'
		});
		
	});
</script>
    <!-- Header --> 
     <div id="form" style="width: 900px; position:absolute; top:50px;">
       <div class="top-left"></div>
	   <div class="top-right">
    	<div id="titulo_form">
            <?php echo (isEditavel('cpf')) ?  "ATUALIZAÇÃO DO FUNCIONÁRIO" : "CADASTRO DE FUNCIONÁRIO"; ?>
	   	</div>
	   </div>
	<div class="inside">
  	<form id="funcionarioForm" method="post" action="../../../controller/FuncionarioController.class.php" enctype="multipart/form-data">
		<table class="tabela" style="width: 100%;" cellpadding="0" cellspacing="4">
      	<tr>
	   	   <td colspan="6" align="center">
	   	   				<input type="hidden" name="nome_arquivo" value="<?php echo Util::getNomeArquivo(); ?>"/>  
			   			<div id="msgCampoObrigatorio">Preencha os campos obrigatorios!</div>
						<?php Util::exibirMsg("o", "funcionário"); ?>
   	    	</td>
     	  </tr>
	    <tr><td colspan="6">
	    <table class="tabelaInterna">
			    <tr>
		   			<td colspan="10" align="left" class="cabecalho2">
		   				<strong title="Dados Pessoais">DADOS PESSOAIS</strong>
		   			</td>
				</tr>
				<tr>
					<td width="14%" rowspan="5" align="center" >
						<div id="visualizar" class="fotoCarregada">
						<?php 
							if(isEditavel()){ 
								echo "<img src='fotos/".$funcionario->getFoto()."' width='100px;' height='100px;'/>";
						    } else {
								echo "<img src='../../img/sem-foto.jpg' alt='Sem Foto' width='100px;' height='100px;' title='Sem Foto' id='semFoto'/>";
							} 
						?>
						</div>
			      	</td>
			      	<td width="12%">
				        <label for="foto" title="Foto 3x4">Foto 3x4:</label>
				    </td>
			      	<td colspan="1">
			      		<input type="file" id="foto" name="foto" value="envio" title="Selecione uma foto 3x4 do funcionário" />
			      	</td>
		      	</tr>
		      	<tr>
		      		<td> 
				        <label for="cpf" title="CPF">CPF:</label>
				    </td>
				    <td>
				    	<?php if(isEditavel()){ 
				    			echo $funcionario->getCpf() . "<input type='hidden' name='cpf' value='".$funcionario->getCpf()."'/>";
				    		   } else { ?>
						        <input type="text" name="cpf" id="cpf" title="Informe o CPF" maxlength="11"/>
						      	<span class="asterico">*</span>
				      	<?php } ?>
			      	</td>
				    <td>
				        <label for="rg" title="rg">RG:</label>
				     </td>	
					 <td>   
				        <input type="text" name="rg" id="rg" class="requerido" title="Informe o RG" maxlength="20" value="<?php Util::exibirValor($funcionario->getRg()); ?>"/>
				      	<span class="asterico">*</span>
				     </td>
		      	</tr>
		        <tr>
				     <td>
				        <label for="nome" title="Nome">Nome:</label>
				  	 </td>	
				     <td>     
				        <input type="text" name="nome" id="nome" class="requerido" title="Informe o Nome" maxlength="100" value="<?php Util::exibirValor($funcionario->getNome()); ?>"/>
				      	<span class="asterico">*</span>
			      	 </td>
				     <td>
				        <label for="orgao_expeditor" title="Orgão Expeditor/UF">Orgão Expeditor/UF:</label>
				     </td>	
					 <td>   
				        <input type="text" name="orgao_expeditor" id="orgao_expeditor" class="requerido" title="Informe o Orgão Expeditor" maxlength="6" value="<?php Util::exibirValor($funcionario->getOrgaoExpedicao()); ?>"/> / 
				      	<select name="uf_orgao_expeditor" id="orgao_expeditor" class="requerSelecao" title="Selecione um Estado">
			        	    <option value="" >--</option>
			        		<?php 
						      Util::montarOpcoesSelect(Util::listaEstadosBrasileiro(), $funcionario->getEndereco()->getEstado(), 2);
						    ?>
			        	</select>
			          	<span class="asterico">*</span>
				     </td>
		        </tr>
		      	<tr>
		      	   <td>
		      	   		<label for="estado_civil" title="Estado Civil">Estado Civil:</label>
		      	   </td>
		      	   <td>
		      	   		<select name="estado_civil" id="estado_civil" class="requerSelecao" title="Selecione um Estado Civil">
		      	   		        <option value="">Selecione</option>
				      	   		<?php 
				      	   		 Util::montarOpcoesSelect(Util::listaEstadosCivis(), $funcionario->getEstadoCivil(), 3);
				      	   		?>
				      	</select>   		
		      	   		<span class="asterico">*</span>
		      	   </td>
		      	   <td>
				        <label for="data_nascimento" title="Data de Nascimento">Data de Nascimento:</label>
				     </td>	
					 <td>   
				        <input type="text" name="data_nascimento" id="data_nascimento" class="requerido" title="Informe a Data de Nascimento" maxlength="10" value="<?php Util::exibirValor($funcionario->getDataNascimento()); ?>"/>
				      	<span class="asterico">*</span>
				    </td>
		      	  </tr>
		      	  <tr>
		      	   <td>
				        <label for="sexo" title="Sexo">Sexo:</label>
				   </td>	
				   <td>     
				      <input type="radio" name="sexo" id="sexoF" value="Feminino" <?php Util::marcarRadioButton("Feminino", $funcionario->getSexo()); ?> /> Feminino
				      <input type="radio" name="sexo" id="sexoM" value="Masculino" <?php Util::marcarRadioButton("Masculino", $funcionario->getSexo()); ?> /> Masculino
			      	<span class="asterico">*</span>
			       </td>
		      	   <td>
		      	   		<label for="grau_instrucao" title="Grau de Instrunção">Grau de Instrunção:</label>
		      	   </td>
		      	   <td>
	      	   		<select name="grau_instrucao" id="grau_instrucao" class="requerSelecao" title="Selecione um Grau de Instrunção">
		      	   		<option value="">Selecione</option>
			      	   	<?php Util::montarOpcoesSelect(Util::listaGrauInstrucao(), $funcionario->getGrauInstrucao(), 3); ?>
	      	   		</select>
	      	   		<span class="asterico">*</span>
		      	   </td>
		      </tr>
     	    </table>
	       </td>
	       </tr>
	      <tr><td colspan="6">
		  <table class="tabelaInterna">
	      <tr>
	   		<td colspan="6" align="left" class="cabecalho2">
	   			<strong title="Dados do Endereço">DADOS DO ENDEREÇO</strong>
	   		</td>
		  </tr>
	      <tr>
		      <td>
		        <label for="cep" title="CEP">CEP:</label>
		      </td>	
			  <td colspan="5">   
		        <input type="text" name="cep" id="cep" class="requerido" title="Informe o CEP" maxlength="50" value="<?php Util::exibirValor($funcionario->getEndereco()->getCep()); ?>"/>
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
		        <input type="text" name="endereco" id="endereco" class="requerido" title="Informe o Endereço" maxlength="100" style="width: 200px" value="<?php Util::exibirValor($funcionario->getEndereco()->getLogradouro()); ?>"/>
		      	<span class="asterico">*</span>
		      </td>
		      <td>
		        <label for="numero" title="Número">Número:</label>
		      </td>	
			  <td>
		        <input type="text" name="numero" id="numero" class="requerido" title="Informe o Número" maxlength="8" style="width: 138px" value="<?php Util::exibirValor($funcionario->getEndereco()->getNumero()); ?>"/>
		      	<span class="asterico">*</span>
		      </td>
		      <td>
		        <label for="bairro" title="Bairro">Bairro:</label>
		      </td>	
			  <td >
		        <input type="text" name="bairro" id="bairro" class="requerido" title="Informe o Bairro" maxlength="100" style="width: 200px" value="<?php Util::exibirValor($funcionario->getEndereco()->getBairro()); ?>"/>
		     	<span class="asterico">*</span>
		      </td>
           </tr>
           <tr>
	       <td>
	        <label for="cidade" title="Cidade">Cidade:</label>
	       </td>	
		    <td>
		        <input type="text" name="cidade" id="cidade" class="requerido" title="Informe a Cidade" maxlength="100" style="width: 200px" value="<?php Util::exibirValor($funcionario->getEndereco()->getCidade()); ?>"/>
		      	<span class="asterico">*</span>
	        </td>
	        <td>
	        	<label for="estado" title="Estado">Estado:</label>
	        </td>	
		    <td>
			    <select name="estado" id="estado" class="requerSelecao" title="Selecione um Estado">
	        	    <option value="" >Selecione</option>
	        		<?php Util::montarOpcoesSelect(Util::listaEstadosBrasileiro(), $funcionario->getEndereco()->getEstado(), 1); ?>
		        </select>
	        	<span class="asterico">*</span>
	      </td>
	      <td>
	        <label for="complemento" title="Complemento">Complemento:</label>
	      </td>	
		  <td>
	        <input type="text" name="complemento" id="complemento" title="Informe o Complemento do Endereço"  maxlength="100" style="width: 200px" value="<?php Util::exibirValor($funcionario->getEndereco()->getComplemento()); ?>"/>
	      </td>
	  	</tr>
	  </table>
	  </td></tr>
	  <tr><td>
	  <table class="tabelaInterna">
		  <tr>
   			<td colspan="6" align="left" class="cabecalho2">
   				<strong title="Dados de Contato">DADOS DO CONTATO</strong>
   			</td>
		  </tr>
	      <tr>
		      <td>
		        <label for="tel_residencial" title="Telefone Residencial">Tel. Residencial:</label>
		      </td>	
			  <td >  
		        <input type="text" name="tel_residencial" id="tel_residencial" class="requerido" title="Informe o Telefone Residencial" maxlength="10" value="<?php Util::exibirValor($funcionario->getContato()->getTelResidencial()); ?>"/>
		      	<span class="asterico">*</span>
		      </td>
		      <td>
		        <label for="tel_celular" title="Telefone Celular 1">Telefone Celular 1:</label>
		      </td>	
			  <td>  
		        <input type="text" name="tel_celular" id="tel_celular" title="Telefone Celular 1" maxlength="10" value="<?php Util::exibirValor($funcionario->getContato()->getTelCelular()); ?>"/>
		      </td>
		      <td>
		        <label for="tel_celular2" title="Telefone Celular 2">Telefone Celular 2:</label>
		      </td>	
			  <td> 
		        <input type="text" name="tel_celular2" id="tel_celular2" title="Informe o Telefone Celular 2" maxlength="10" value="<?php Util::exibirValor($funcionario->getContato()->getTelComercial()); ?>"/>
		      </td>
	      </tr>
	      <tr>
		      <td>
			      <label for="email" title="E-mail">E-mail:</label>
			   </td>	
			   <td colspan="4">   
			      <input type="text" name="email" id="email" class="requerido" title="Informe o E-mail" maxlength="100" value="<?php Util::exibirValor($funcionario->getContato()->getEmail()); ?>"/>
		       	  <span class="asterico">*</span>	
		       </td>
	      </tr>
      </table>
      </td></tr>
	  <tr><td>
	  <table class="tabelaInterna">
		  <tr>
   			<td colspan="6" align="left" class="cabecalho2">
   				<strong title="Dados de Contato">DADOS COMPLEMENTARES</strong>
   			</td>
		  </tr>
	      <tr>
		       <td>
			      <label for="ctps" title="Número da CTPS">Nº. CTPS:</label>
			   </td>	
			   <td>   
			      <input type="text" name="ctps" id="ctps" class="requerido" title="Informe o Número da CTPS" maxlength="30" value="<?php Util::exibirValor($funcionario->getCtps()); ?>"/>
		       	  <span class="asterico">*</span>	
		       </td>
		      <td >
		        <label for="num_serie" title="Número de Série da CTPS">Nº. Série:</label>
		      </td>	
			  <td>  
		        <input type="text" name="num_serie" id="num_serie" class="requerido" title="Informe o Número de Série da CTPS" maxlength="30" value="<?php Util::exibirValor($funcionario->getNumeroSerie()); ?>"/>
		      	<span class="asterico">*</span>
		      </td>
		      <td>
		        <label for="cargo" title="Cargo">Cargo:</label>
		      </td>	
			  <td>  
		        <input type="text" name="cargo" id="cargo" class="requerido" title="Informe um Cargo" value="<?php Util::exibirValor($funcionario->getCargo()); ?>"/>
		        <span class="asterico">*</span>
		      </td>
	      </tr>
	      <tr>
		      <td>
		        <label for="salario" title="Sálario">Sálario:</label>
		      </td>	
		      <td> 
		        <input type="text" name="salario" id="salario" class="requerido" title="Informe o Sálario" maxlength="20" value="<?php Util::exibirValor($funcionario->getSalarioLiquido()); ?>"/>
		        <span class="asterico">*</span>
		      </td>
			  <td>
		        <label for="comissao" title="Comissão (%)">Comissão (%):</label>
		      </td>	
		      <td> 
		        <input type="text" name="comissao" id="comissao" class="requerido" title="Informe s Comissão (%)" maxlength="20" value="<?php Util::exibirValor($funcionario->getComissao()); ?>"/>
		        <span class="asterico">*</span>
		      </td>
		      <td>
		        <label for="data_admissao" title="Data de Admissão">Data de Admissão:</label>
		      </td>	
			  <td> 
		        <input type="text" name="data_admissao" id="data_admissao" class="requerido" title="Informe o Data de Admissão" maxlength="10" value="<?php Util::exibirValor($funcionario->getDataAdmissao()); ?>"/>
		      	<span class="asterico">*</span>
		      </td>
	      </tr>
	      <?php if(isEditavel()){ ?>
	      <tr>
	      	  <td>
		        <label for="data_demissao" title="Data de Demissão">Data de Demissão:</label>
		      </td>	
			  <td> 
		        <input type="text" name="data_demissao" id="data_demissao" title="Informe o Data de Demissão" maxlength="10" value="<?php Util::exibirValor($funcionario->getDataDemissao()); ?>"/>
		      </td>
	      </tr>
	      <?php } ?>
      </table>
      </td>
      </tr>
      <tr>
      <td colspan="6">
	      <table class="tabelaInterna" width="953" cellpadding="0" cellspacing="4">
		      <tr>
				  <td>
				  	<span class="asterico" title="* Campos obrigatórios!">* Campos obrigatórios!</span><p></p>
				  </td>
				  <td>
					  <?php if(isEditavel()){ ?>
					    <div id="botoes" style="margin-left:40px;">
					  	<input type="button" name="novoCadastro" id="novoCadastro" class="botao" style="width: 120px;" title="Novo Cadastro" value="Novo Cadastro" />
			  			<input type="submit" name="atualizar" id="atualizar" title="Atualizar" value="Atualizar" <?php PermissaoController::desabilitarBotao("FUNCIONÁRIO", "atualizar"); ?>/> &nbsp;
					  	<input type="button" name="excluir" id="excluir" title="Excluir" value="Excluir" <?php PermissaoController::desabilitarBotao("FUNCIONÁRIO", "excluir"); ?>/> 
			  			<input type="button" class="botao" name="cancelar" id="cancelar" title="Cancelar" value="Cancelar" />
				   	 <?php } else{ ?>
				   	 	<input type="submit" name="cadastrar" id="cadastrar" title="Cadastrar" value="Cadastrar" <?php PermissaoController::desabilitarBotao("FUNCIONÁRIO", "cadastrar"); ?>/> &nbsp;
					  	<input type="button" class="botao" name="cancelar" id="cancelar" title="Cancelar" value="Cancelar" />
				   	 <?php } ?>
				   	 </div>
			   	  </td>
		      </tr>
	      </table>
      </td></tr>
     </table>
  </form>
  <!-- Trailler -->
    </div>
	<div class="bottom-left"></div>
	<div class="bottom-right" style="padding-left:35px;"></div>
	</div>