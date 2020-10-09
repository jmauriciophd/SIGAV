<?php 
	require_once dirname(__FILE__) . "/../../../libloader.php";
	$cliente = new Cliente();
	$cliente->setContato(new Contato());
	$cliente->setEndereco(new Endereco());
	$cliente->setMedidas(new Medidas());
		
    if(Util::editarDadosFormulario('cpf')) {
    	$clienteController = new ClienteController();
		$cliente = $clienteController->consultarClientePorCpf($_GET['cpf']);
   	}
   	
   	function isEditavel(){
		global $cliente;
		return (Util::editarDadosFormulario('cpf') && $cliente != null && $cliente->getCpf() != null);
	}

	$listaArquivosCss = array("form.css", "calendario/smoothness/ui.all.css");
	Util::includeArquivosCss($listaArquivosCss);

	$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
							"jquery/jquery.maskedinput-1.3.min.js", 
							"jquery/jquery.validacao.js",
							"jquery/jquery.cep-1.0.min.js",
							"calendario/ui.datepicker.js", 
							"calendario/ui.datepicker-pt-BR.js",
							"ajax/ajax.js",
							"mascaras.js", "funcoes.js", "cep.js", "validacao.campos.js", "calendario.js"
					 );

	Util::includeArquivosJs($listaArquivosJs);
?>
	
<script type="text/javascript">
	var url = "../cliente/ClienteFormCadastrar.php";

	$(function(){
		$("#cpf").blur(function(event){
	  		verificarCpf("Cliente");
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
			event.preventDefault();
		    if(confirm("Deseja excluir o registro?")){
		   	 	executarAcao("excluir&url="+url, true);
		    }  else {
				return false;
			}
		});
		
		$("#novoCadastro").click(function(event) {
			event.preventDefault();
		    abrirPag(url);
		});
	});
</script>
	   
	    <!-- Header --> 
	     <div id="form" style="width: 900px; position:absolute; top:50px;">
	       <div class="top-left"></div>
		    <div class="top-right"><div id="titulo_form">
		               <?php if(isEditavel()){
			   				echo "ATUALIZAÇÃO DO CLIENTE";
						}else{
		   				  	echo "CADASTRO DE CLIENTE";}
			   			?></div></div>
		      <div class="inside">
		  	<form id="clienteForm" method="post" action="../../../controller/ClienteController.class.php" enctype="multipart/form-data">
				<input type="hidden" name="nome_arquivo" value="<?php echo Util::getNomeArquivo(); ?>"/>
				<table class="tabela" width="100%" cellpadding="0" cellspacing="4">
		      	<tr>
			   		<td colspan="6" align="center"> 
			   			<div id="msgCampoObrigatorio">Preencha os campos obrigatorios!</div>
						<?php Util::exibirMsg("o", "cliente"); ?>
			   		</td>
			    </tr>
			        <tr>
				 	<td colspan="10" align="left" class="cabecalho2"><strong title="Dados Pessoais">DADOS PESSOAIS</strong></td>
						 </tr>
						  <tr>
						  	<td> 
						        <label for="cpf" title="CPF">CPF:</label>
						    </td>
						    <td>
						        <?php if(isEditavel()){ 
					    				echo $cliente->getCpf(); 
					    				echo '<input type="hidden" name="cpf" value="'.$cliente->getCpf().'"/>';
					    		   	  } else { ?>
						        		<input type="text" name="cpf" id="cpf" title="Informe o CPF" maxlength="11"/>
						      			<span class="asterico">*</span>
					      		<?php } ?>
					       </td>
					       <td>
						        <label for="nome" title="Nome">Nome:</label>
						   </td>						   
						   <td>     
						        <input type="text" name="nome" id="nome" class="requerido" title="Informe o Nome" size="25" maxlength="100" value="<?php Util::exibirValor($cliente->getNome()); ?>"/>
						      	<span class="asterico">*</span>
					      	</td>
						   </tr>
						   <tr>
						   <td>
						        <label for="rg" title="rg">RG:</label>
						   </td>	
						   <td>   
						        <input type="text" name="rg" id="rg" class="requerido" title="Informe o RG" maxlength="20" value="<?php Util::exibirValor($cliente->getRg()); ?>"/>
						      	<span class="asterico">*</span>
						  </td>
					       <td>
					        <label for="orgao_expeditor" title="Orgão Expeditor/UF">Orgão Expeditor/UF:</label>
					     </td>	
						 <td>   
					        <input type="text" name="orgao_expeditor" id="orgao_expeditor"  class="requerido" title="Informe o Orgão Expeditor" maxlength="6"  value="<?php Util::exibirValor($cliente->getOrgaoExpedicao()); ?>"/> / 
					      	<select name="uf_orgao_expeditor" id="uf_orgao_expeditor" class="requerSelecao" title="Informe o Estado do Orgão Emissor do RG">
					      			<option value="">--</option>
					      			<?php 
								      	Util::montarOpcoesSelect(Util::listaEstadosBrasileiro(), $cliente->getEndereco()->getEstado(), 2);
								    ?>
							</select>
					      	<span class="asterico">*</span>
					     </td>
				        </tr>
				      	<tr>
				      	   <td align="left">
						        <label for="data_nascimento" title="Data de Nascimento">Data de Nascimento:</label>
						     </td>	
							 <td>   
						        <input type="text" name="data_nascimento" id="data_nascimento" class="requerido" title="Informe a Data de Nascimento" size="10"  maxlength="10" value="<?php Util::exibirValor(Util::formataDataPtBr($cliente->getDataNascimento())); ?>"/>
						      	<span class="asterico">*</span>
						    </td>
				      	  <td>
				      	   		<label for="estado_civil" title="Estado Civil">Estado Civil:</label>
				      	   </td>
				      	   <td>
				      	   		<select name="estado_civil" id="estado_civil" class="requerSelecao" title="Selecione um Estado Civil">
				      	   			<option value="">Selecione</option>
				      	   			<?php 
								      	Util::montarOpcoesSelect(Util::listaEstadosCivis(), $cliente->getEstadoCivil(), 3);
								    ?>
				      	   		</select>
				      	   		<span class="asterico">*</span>
				      	   </td>
				      	   </tr>			
				      	  <tr>
				      	   <td>
						        <label for="sexo" title="Sexo">Sexo:</label>
						   </td>	
						   <td>     
						        <input type="radio" name="sexo" id="sexoF" value="Feminino" <?php Util::marcarRadioButton("Feminino", $cliente->getSexo()); ?> /> Feminino
						        <input type="radio" name="sexo" id="sexoM" value="Masculino" <?php Util::marcarRadioButton("Masculino", $cliente->getSexo()); ?> /> Masculino
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
				        <input type="text" name="cep" id="cep" class="requerido" title="Informe o CEP"  maxlength="50" value="<?php Util::exibirValor($cliente->getEndereco()->getCep()); ?>"/>
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
				        <input type="text" name="endereco" id="endereco" class="requerido" title="Informe o Endereço"  size="45" maxlength="100" value="<?php Util::exibirValor($cliente->getEndereco()->getLogradouro()); ?>"/>
				      	<span class="asterico">*</span>
				      </td>
				      <td>
				        <label for="numero" title="Número">Número:</label>
				      </td>	
					  <td>
				        <input type="text" name="numero" id="numero" class="requerido" title="Informe o Número"  maxlength="10" value="<?php Util::exibirValor($cliente->getEndereco()->getNumero()); ?>"/>
				      	<span class="asterico">*</span>
				      </td>
				      </tr>
				   <tr>
				      <td>
				        <label for="bairro" title="Bairro">Bairro:</label>
				      </td>	
					  <td >
				        <input type="text" name="bairro" id="bairro" class="requerido" title="Informe o Bairro"  maxlength="100"  value="<?php Util::exibirValor($cliente->getEndereco()->getBairro()); ?>"/>
				     	<span class="asterico">*</span>
				      </td>
		             <td>
			        <label for="cidade" title="Cidade">Cidade:</label>
			      </td>	
				  <td>
			        <input type="text" name="cidade" id="cidade" class="requerido" title="Informe a Cidade"  maxlength="100"  value="<?php Util::exibirValor($cliente->getEndereco()->getCidade()); ?>"/>
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
						      	Util::montarOpcoesSelect(Util::listaEstadosBrasileiro(), $cliente->getEndereco()->getEstado());
						    ?>
			        </select>
			        <span class="asterico">*</span>
			      </td>
			      <td>
			        <label for="complemento" title="Complemento">Complemento:</label>
			      </td>	
				  <td>
			        <input type="text" name="complemento" id="complemento" class="requerido" title="Informe o Complemento do Endereço"  maxlength="100"  value="<?php Util::exibirValor($cliente->getEndereco()->getComplemento()); ?>"/>
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
					      <input type="text" name="email" id="email" title="Informe o E-mail"  maxlength="100" value="<?php Util::exibirValor($cliente->getContato()->getEmail()); ?>"/>
				        </td>
				      <td width="10%">
				        <label for="tel_residencial" title="Telefone Residencial">Tel. Residencial:</label>
				      </td>	
					  <td width="20%">  
				        <input type="text" name="tel_residencial" id="tel_residencial" class="requerido" title="Informe o Telefone Residencial" maxlength="10" value="<?php Util::exibirValor($cliente->getContato()->getTelResidencial()); ?>"/>
				     	<span class="asterico">*</span>
				     </td>
			      </tr>
			      <tr>
				      <td>
				        <label for="tel_celular" title="Telefone Celular">Telefone Celular:</label>
				      </td>	
					  <td>  
				        <input type="text" name="tel_celular" id="tel_celular" title="Telefone Celular" maxlength="10" value="<?php Util::exibirValor($cliente->getContato()->getTelCelular()); ?>"/>
				      </td>
			      </tr>
		          <tr>
		           <td>
			        <label for="twitter" title="Twitter">Twitter:</label>
			      </td>	
				  <td> 
			        <input type="text" name="twitter" id="twitter" title="Informe o Twitter"  maxlength="100"  value="<?php Util::exibirValor($cliente->getContato()->getTwitter()); ?>"/>
			      	<?php if(isEditavel()){	?>
			      	<a href="https://twitter.com/<?php Util::exibirValor($cliente->getContato()->getTwitter()); ?>" target="_blank" title="Clique aqui para acessar o twitter do cliente"><img src="../../img/icons/twiter32.png" alt="Facebook" width="16px" height="16px"/></a>
			      	<?php } ?>
			      </td>
		          <td>
			        <label for="facebook" title="Facebook">Facebook:</label>
			      </td>	
				  <td>
			        <input type="text" name="facebook" id="facebook" title="Informe o Facebook"  maxlength="100"  value="<?php Util::exibirValor($cliente->getContato()->getFacebook()); ?>"/>
			      	<?php if(isEditavel()){	?>
			      	<a href="https://www.facebook.com/<?php Util::exibirValor($cliente->getContato()->getFacebook()); ?>" target="_blank" title="Clique aqui para acessar o facebook do cliente"><img src="../../img/icons/face.ico" alt="Facebook" width="16px" height="16px"/></a>
			      	<?php } ?>
			      </td>
		         </tr>
		         <tr>
				 	<td colspan="10" align="left" class="cabecalho2">
				 		<strong title="Medidas do Cliente">MEDIDAS DO CLIENTE</strong>
				 	</td>
				 </tr>
				 <tr>
				      <td>
				        <label for="tamanho" title="Tamanho (cm)">Tamanho (cm):</label>
				      </td>	
					  <td>  
				        <input type="text" name="tamanho" id="tamanho_medidas" title="Informe o Tamanho padrão da roupa em centimetros(cm)"  maxlength="5"  value="<?php Util::exibirValor($cliente->getMedidas()->getTamanho()); ?>"/>
			      	 </td>
			      	 <td>
				        <label for="busto_torax" title="Busto/Tórax (cm)">Busto/Tórax (cm):</label>
				      </td>	
					  <td>  
				        <input type="text" name="busto_torax" id="busto_torax" title="Informe o tamanho do busto/tórax em centimetros(cm)"  maxlength="5"  value="<?php Util::exibirValor($cliente->getMedidas()->getBustoTorax()); ?>"/>
			      	 </td>
			      </tr>
			      <tr>
			      	  <td>
				        <label for="cintura" title="Cintura (cm)">Cintura (cm):</label>
				      </td>	
					  <td>  
				        <input type="text" name="cintura" id="cintura" title="Informe o tamanho da cintura em centimetros(cm)"  maxlength="5"  value="<?php Util::exibirValor($cliente->getMedidas()->getCintura()); ?>"/>
			      	  </td>
				      <td>
				        <label for="quadril" title="Quadril (cm)">Quadril (cm):</label>
				      </td>	
					  <td>  
				        <input type="text" name="quadril" id="quadril" title="Informe o tamanho do quadril em centimetros(cm)"  maxlength="5"  value="<?php Util::exibirValor($cliente->getMedidas()->getQuadril()); ?>"/>
			      	 </td>
			      </tr>
			      <tr>
			      	  <td>
				        <label for="altura_frente" title="Altura Frente (cm)">Altura Frente (cm):</label>
				      </td>	
					  <td>  
				        <input type="text" name="altura_frente" id="altura_frente" title="Informe a altura de frente em centimetros(cm)" maxlength="5" value="<?php Util::exibirValor($cliente->getMedidas()->getAlturaFrente()); ?>"/>
			      	  </td>
				      <td>
				        <label for="ombro" title="Ombro (cm)">Ombro (cm):</label>
				      </td>	
					  <td>  
				        <input type="text" name="ombro" id="ombro" title="Informe o tamanho do ombro em centimetros(cm)" maxlength="5" value="<?php Util::exibirValor($cliente->getMedidas()->getOmbro()); ?>"/>
			      	 </td>
			      </tr>
			      <tr>
			      	  <td>
				        <label for="costas" title="Costas (cm)">Costas (cm):</label>
				      </td>	
					  <td>  
				        <input type="text" name="costas" id="costas" title="Informe o tamanho das costas em centimetros(cm)" maxlength="5" value="<?php Util::exibirValor($cliente->getMedidas()->getCostas()); ?>"/>
			      	  </td>
				      <td>
				        <label for="braco" title="Braço (cm)">Braço (cm):</label>
				      </td>	
					  <td>  
				        <input type="text" name="braco" id="braco" title="Informe o tamanho do braço em centimetros(cm)" maxlength="5" value="<?php Util::exibirValor($cliente->getMedidas()->getBraco()); ?>"/>
			      	 </td>
			      </tr>
		         <tr>
				      <td valign="top">
				        <label for="observacao" title="Observação">Observação:</label>
				      </td>	
					  <td colspan="4">  
				        <textarea name="observacao" id="observacao" rows="10" cols="80" title="Informe uma Observação"><?php Util::exibirValor($cliente->getMedidas()->getObservacao()); ?></textarea>
				      </td>
			      </tr>
		           <tr>
					  <td colspan="4">	
					  	<span class="asterico" title="* Campos obrigatórios!">* Campos obrigatórios!</span><p/>
					  	<div id="botoes" style="margin-left:40px;">
					  	<?php if(isEditavel()){	?>
					  		<input type="hidden" name="id_medidas" id="id_medidas" value="<?php Util::exibirValor($cliente->getMedidas()->getId()); ?>">
					  		<input type="button" name="novoCadastro" id="novoCadastro" class="botao" style="width: 120px;" title="Novo Cadastro" value="Novo Cadastro" /> &nbsp;
						  	<input type="submit" name="atualizar" id="atualizar" title="Atualizar" value="Atualizar" <?php PermissaoController::desabilitarBotao("CLIENTE", "atualizar"); ?>/> &nbsp;
						  	<input type="button" name="excluir" id="excluir" title="Excluir" value="Excluir" <?php PermissaoController::desabilitarBotao("CLIENTE", "excluir"); ?>/> &nbsp;
				  			<input type="button" name="cancelar" id="cancelar" class="botao" title="Cancelar" value="Cancelar" />
				   	 	<?php } else { ?>
					   	 	<input type="submit" name="cadastrar" id="cadastrar" title="Cadastrar" value="Cadastrar" <?php PermissaoController::desabilitarBotao("CLIENTE", "cadastrar"); ?>/> &nbsp;
						  	<input type="button" name="cancelar" id="cancelar" class="botao" title="Cancelar" value="Cancelar" />
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