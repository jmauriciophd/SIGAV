<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";
   
$aluguel = new Aluguel();
$aluguel->setCliente(new Cliente());
$aluguel->setUsuario(new Usuario());

if(isset($_GET['id'])){
   $aluguelController = new AluguelVestuarioController();
   $aluguel = $aluguelController->consultarAluguelPorId($_GET['id']);    	
}
    
$listaArquivosCss = array("form.css", "popup.css", "demo_page.css", "demo_table.css", 
						  "demo_table_jui.css", "jquery-ui-1.8.4.custom.css");
	
Util::includeArquivosCss($listaArquivosCss);

$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
						"jquery/jquery.dataTables.js",
						"jquery/jquery.validacao.js",
						"jquery/jquery.price_format.1.7.js",
						"ajax/ajax.js", "funcoes.modal.popup.js",
						"funcoes.js", "validacao.campos.js"
                       );

Util::includeArquivosJs($listaArquivosJs);
?>
  <!-- Header --> 
      <div id="form" style="position:absolute;">
       <div class="top-left"><div id="titulo_form">DETALHAMENTO DO ALUGUEL
       <a href="#" class="close" onclick="fecharModal();">X Fechar</a>
       </div></div>
	    <div class="top-right"></div>
		 <div class="inside">
  	<form method="post" action="../../../controller/AluguelVestuarioController.class.php">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
	 	 <tr>
			 <td colspan="6">
				 <table id="teste" class="tabelaInterna" width="100%" cellpadding="0" cellspacing="4">
				 <tr>
				    <td colspan="2" align="left" class="cabecalho2"><strong title="Dados Pessoais">DADOS DO FUNCIONÁRIO</strong></td>
				 </tr>
				 <tr>
				   	<td> 
				   	  <?php echo $_SESSION['CPF_USUARIO']; ?>
				      &nbsp; <?php echo $_SESSION['NOME_USUARIO']; ?>
				    </td>
				    <td> 
				      <?php echo date('d/m/Y H:m:s'); ?>
				      &nbsp; <?php echo date('d/m/Y H:m:s'); ?>
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
					  <?php echo $aluguel->getCliente()->getCpf(); ?>
				  </td>
	      	    </tr>
		        <tr>
		           <td colspan="2">
		             <div id="status" style="display: none; padding: 5px; border: 1px solid;">
		             	<label for="nome_cliente" title="Nome">Nome:</label><?php $aluguel->getCliente()->getNome(); ?><br /><br />
			            <label for="rg_cliente" title="Rg">RG:</label> <?php $aluguel->getCliente()->getRg(); ?>
			            <label for="orgao_expedicao_cliente" title="Orgão Expedição">Orgão Expedição/UF:</label> <?php $aluguel->getCliente()->getOrgaoExpedicao(); ?>
			            <br /><br />
				        <label for="endereco_cliente" title="Endereço">Endereço:</label><?php $aluguel->getCliente()->getEndereco()->getLogradouro(); ?><br /><br />
				        <label for="tel_residencial_cliente" title="Telefone Residencial">Tel. Residencial:</label> <?php $aluguel->getCliente()->getContato()->getTelResidencial(); ?>
				        <label for="email_cliente" title="E-mail">E-mail:</label><?php $aluguel->getCliente()->getContato()->getEmail(); ?>
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
									<td><?php ?></td>
								    <td><?php ?></td>
								     <td><?php ?></td>
								     <td><?php ?></td>
								     <td><?php ?></td>
								     <td><?php ?></td>
								     <td><?php ?></td>
								     <td><?php ?></td>
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
						    <?php echo $aluguel->getDataEntrega(); ?>
						  </td>
						  <td>
					        <label for="data_prevista_devolucao" title="Data de Devolução">Data Prevista de Devolução:</label> &nbsp;
						 	<?php echo $aluguel->getDataPrevistaDevolucao(); ?>
						  </td>
						  <td>
						    <label for="data_previa" title="Data da Prévia">Data da Prévia:</label> &nbsp;
                           <?php echo $aluguel->getDataPrevia(); ?>
						  </td>
						  <td>
						    <label for="data_prova" title="Data da Prova">Data da Prova:</label> &nbsp;
						 	<?php echo $aluguel->getDataProva(); ?>
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
	        <td>
	        <label for="valor_total" title="Valor Total">Valor Total:</label>
	       </td>
	       <td colspan="2">
	 	  	<?php echo $aluguel->getValorTotalAluguel(); ?>
	 	   </td>
	       <td>
	        <label for="forma_pagamento" title="Forma de Pagamento">Forma de Pagamento:</label>
	       </td>	
		   <td>
	      <?php echo $aluguel->getPagamento()->getTipoPagamento(); ?>
	        <span class="asterico">*</span>	
	      </td>
	      </tr>
	      <tr id="cmp_parcelas">
	      <td>
	        <label for="qtd_parcelas" title="Quantidade de Parcelas" >Parcelas:</label>
	      </td>	
		  <td> 
	        <?php  echo $aluguel->getPagamento()->getNumParcelas(); ?>     
	      </td>
	      <td>
	        <label for="valor_parcela" id="cmp_valor_parcela" title="Valor das Parcelas">Valor das Parcelas:</label>
	      </td>
	      <td>
	        <?php echo $aluguel->getPagamento()->getValorParcelas(); ?>
	      </td>
	      </tr>
	      <tr>
           <td>
	        <label for="valor_entrada" title="Valor da Entrada">Entrada (R$):</label>
	      </td>	
		  <td>  
	        <?php echo $aluguel->getPagamento()->getEntrada(); ?>
	      </td>
	      <td>
	        <label for="falta_pagar" title="Falta Pagar">Falta Pagar (R$):</label>
	      </td>	
		  <td>
	        <?php echo $aluguel->getPagamento()->getFaltaPagar(); ?>
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