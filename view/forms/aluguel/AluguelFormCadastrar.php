<?php
require_once dirname(__FILE__) . "/../../../libloader.php";

$aluguelVestuario = new AluguelVestuario();
$aluguelVestuarioController = new AluguelVestuarioController();

if(Util::editarDadosFormulario('id_aluguel')) {
	$aluguelVestuario = $aluguelController->pesquisar($_GET['id_aluguel']);
}

function isEditavel(){
	global $aluguelVestuario;
	return (Util::editarDadosFormulario('id_aluguel') && $aluguelVestuario != null && $aluguelVestuario->getIdAluguel() != null);
}

$listaArquivosCss = array("demo_page.css", "demo_table.css", "form.css", "calendario/smoothness/ui.all.css", "jquery.autocomplete.css");
Util::includeArquivosCss($listaArquivosCss);

$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
						"jquery/jquery.maskedinput-1.3.min.js", 
						"jquery/jquery.validacao.js",
						"jquery/jquery.autocomplete.js",
						"jquery/jquery.validacao.js",
						"jquery/jquery.dataTables.js",
						"jquery/jquery.price_format.1.7.js",
						"calendario/ui.datepicker.js", 
						"calendario/ui.datepicker-pt-BR.js",
						"ajax/ajax.js", 
						"mascaras.js", "funcoes.js", "validacao.campos.js", "calendario.js", "aluguel.js"
				 );
				 
Util::includeArquivosJs($listaArquivosJs);
?>
    <!-- Header --> 
   <div id="form" style="width: 900px;">
    <div class="top-left"></div>
	  <div class="top-right">
	  	<div id="titulo_form">ALUGAR VESTUÁRIOS</div>
	</div>
	<div class="inside">
  	<form method="post" action="../../../controller/AluguelVestuarioController.class.php">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		     <tr>
			   <td colspan="6" align="center"> 
			   		<div id="msg"></div>
		   			<div id="msgCampoObrigatorio">Preencha os campos obrigatórios!</div>
					<?php Util::exibirMsg("o", "aluguel"); ?>
					<input type="hidden" name="nome_arquivo" value="<?php echo Util::getNomeArquivo(); ?>"/>
			   </td>
			 </tr>
			 <tr>
			 <td colspan="6">
				 <table id="teste" class="tabelaInterna" width="100%" cellpadding="0" cellspacing="4">
				 <tr>
				    <td colspan="2" align="left" class="cabecalho2"><strong title="Dados Pessoais">DADOS DO FUNCIONÁRIO</strong></td>
				 </tr>
				 <tr>
				   	<td> 
				   	  <input type="hidden" name="cpf_usuario" value="<?php echo $_SESSION['CPF_USUARIO']; ?>"/>
				      <label for="funcionario" title="Funcionário">Funcionário:</label> &nbsp; <?php echo $_SESSION['NOME_USUARIO']; ?>
				    </td>
				    <td> 
				      <input type="hidden" name="data_locacao" value="<?php echo date('d/m/Y'); ?>"/>
				      <label for="data_locacao" title="Data da Locação">Data/Hora da Locação:</label> &nbsp; <?php echo date('d/m/Y H:m:s'); ?>
				    </td>
	      	    </tr>
		        </table>
			 </td>
		  </tr>
		  <tr>
			 <td colspan="6">
				 <table class="tabelaInterna" width="100%" cellpadding="0" cellspacing="4">
				 <tr>
				    <td colspan="2" align="left" class="cabecalho2"><strong title="Dados Pessoais">DADOS DO CLIENTE</strong></td>
				 </tr>
				 <tr>
				   	<td> 
				      <label for="cpf_cliente" title="CPF">CPF do Cliente:</label> &nbsp;
					  <input type="text" name="cpf_cliente" id="cpf_cliente" class="requerido" maxlength="11" />
					  <span class="asterico">*</span>
				  </td>
	      	    </tr>
		        <tr>
		           <td colspan="2">
		             <div id="status" style="display: none; padding: 5px; border: 1px solid;">
		             	<label for="nome_cliente" title="Nome">Nome:</label> <span id="nome_cliente"></span><br /><br />
			            <label for="rg_cliente" title="Rg">RG:</label> <span id="rg_cliente"></span>
			            <label for="orgao_expedicao_cliente" title="Orgão Expedição">Orgão Expedição/UF:</label> <span id="orgao_expedicao_cliente"></span>
			            <br /><br />
				        <label for="endereco_cliente" title="Endereço">Endereço:</label> <span id="endereco_cliente"></span><br /><br />
				        <label for="tel_residencial_cliente" title="Telefone Residencial">Tel. Residencial:</label> <span id="tel_residencial_cliente"></span>
				        <label for="email_cliente" title="E-mail">E-mail:</label> <span id="email_cliente"></span>
			      	 </div>
			      </td>
		        </tr>
		        </table>
			 </td>
		  </tr>
		  <tr>
			 <td colspan="6">
				 <table class="tabelaInterna" width="100%" cellpadding="0" cellspacing="4">
		          <tr>
		             <td colspan="4" align="left" class="cabecalho2">
		            	 <strong title="Dados do Vestuário">DADOS VESTUÁRIO</strong>
		             </td>
			       </tr>
		          <tr>
				      <td>
					      <label for="codigo_vestuario" title="Código do Vestuario">Código:</label> &nbsp;
					      <input type="text" name="codigo_vestuario" id="codigo_vestuario" title="Informe o código do vestuário" maxlength="20" /> &nbsp;
				      	  <input type="button" class="botao" name="addVestuario" id="addVestuario" title="Adicionar Vestuário" value="Adicionar" />
				      </td>
		          </tr>
			      <tr>
				    <td colspan="4" class="ex_highlight">
			        <table cellpadding="0" cellspacing="0" border="0" class="display" id="tabelaAddVestuario" width="100%">
						<thead>
							<tr class='cabecalho2'>
								<td>Código</td>
								<td>Vestuário</td>
								<td>Categoria</td>
								<td>Cor</td>
								<td>Medidas</td>
								<td>Tamanho</td>
								<td>Valor do Aluguel</td>
								<td></td>
							</tr>
							<tr id="msgListaVestuario">
								<td colspan="8" align="center">
									<div id="msgAviso">Nenhum vestuário adicionado a lista de aluguel</div>
								</td>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				    </td>
			      </tr>
			      </table>
			 </td>
		  </tr>
		  <tr>
			 <td colspan="6">
				 <table class="tabelaInterna" width="100%" cellpadding="0" cellspacing="4">
					  <tr>
						  <td>
					        <label for="data_entrega" title="Data de Entrega">Data de Entrega:</label> &nbsp;
						  	<input type="text" name="data_entrega" id="data_entrega" title="Informe a Data de Entrega"/>
						  	<span class="asterico">*</span>
						  </td>
						  <td>
					        <label for="data_prevista_devolucao" title="Data de Devolução">Data Prevista de Devolução:</label> &nbsp;
						 	<input type="text" name="data_prevista_devolucao" id="data_prevista_devolucao" title="Informe a Data de Devolução"/>
						  	<span class="asterico">*</span>
						  </td>
						  <td>
						    <label for="data_previa" title="Data da Prévia">Data da Prévia:</label> &nbsp;
						 	<input type="text" name="data_previa" id="data_previa" title="Informe a Data da Prévia"/>
						  </td>
						  <td>
						    <label for="data_prova" title="Data da Prova">Data da Prova:</label> &nbsp;
						 	<input type="text" name="data_prova" id="data_prova" title="Informe a Data da Prova"/>
						  </td>
				      </tr>
			       </table>
			 </td>
	   </tr>
	   <tr>
       <td colspan="6">
	    <table class="tabelaInterna" width="100%" align="center" cellpadding="0" cellspacing="4">
	        <tr>
	   			<td colspan="20" align="left" class="cabecalho2"><strong title="Dados do Pagamento">DADOS DO PAGAMENTO</strong></td>
		    </tr>
	       <tr>
	       <td colspan="2">
	 	  	<input type="hidden" name="valor_total_aluguel" id="valor_total_aluguel" value="" />
 	  	   	<label for="valor_total" title="Valor Total">Valor Total á Pagar:</label> 
 	  	   	<span id="valor_total"> R$ 0,00</span>
	 	   </td>
	       <td>
	        <label for="forma_pagamento" title="Forma de Pagamento">Forma de Pagamento:</label>
	       </td>	
		   <td>
	        <select name="forma_pagamento" id="forma_pagamento" class="requerSelecao">
	          <option value="">Selecione</option>
	          <?php Util::montarOpcoesSelect(Util::listaFormaPagamentos(), null, 1); ?>
	        </select>
	        <span class="asterico">*</span>	
	      </td>
	      </tr>
	      <tr id="cmp_parcelas">
	      <td>
	        <label for="qtd_parcelas" title="Quantidade de Parcelas" >Parcelas:</label>
	      </td>	
		  <td> 
	        <select name="qtd_parcelas" id="qtd_parcelas">
	        <?php Util::montarOpcoesSelect(Util::listaQtdParcelas(), null, 3); ?>     
	        </select>
	      </td>
	      <td>
	        <label for="valor_parcela" id="cmp_valor_parcela" title="Valor das Parcelas">Valor das Parcelas:</label>
	      </td>
	      <td>
	        <input type="text" name="valor_parcela" id="valor_parcela" maxlength="15"/>
	      </td>
	      </tr>
	      <tr>
           <td>
	        <label for="valor_entrada" title="Valor da Entrada">Entrada (R$):</label>
	      </td>	
		  <td>  
	         <input type="text" name="valor_entrada" id="valor_entrada" title="Informe Valor da Entrada" class="requerido" maxlength="15"/>
	         <span class="asterico">*</span>	
	      </td>
	      <td>
	        <label for="falta_pagar" title="Falta Pagar">Falta Pagar (R$):</label>
	      </td>	
		  <td>
		       <input type="text" name="falta_pagar" id="falta_pagar" title="Quanto Falta Pagar"  size="15" maxlength="15" readonly="readonly" value="0"/>
	      </td>
        </tr>
	   </table>
	   	</td>
	   </tr>
       <tr>
       <td colspan="6">
	      <table class="tabelaInterna" width="953"  cellpadding="0" cellspacing="4">
		      <tr>
				  <td>
				  	<span class="asterico" title="* Campos obrigatórios!">* Campos obrigatórios!</span><p></p>
				  </td>
				  <td align="left">	
				  	<input type="submit" name="cadastrar" id="cadastrar" title="Salvar" value="Salvar" <?php PermissaoController::desabilitarBotao("ALUGAR VESTUÁRIO", "cadastrar"); ?>/> &nbsp;
					<input type="button" class="botao" name="cancelar" id="cancelar" title="Cancelar" value="Cancelar" />
					<input type="hidden" name="qtdVest" id="qtdVest"/>
				  </td>
		      </tr>
	      </table>
      </td>
      </tr>
     </table>
   </form>
  <!-- Trailler -->
 </div>
	<div class="bottom-left"></div>
	<div class="bottom-right" style="padding-left:35px;"></div>
 </div>