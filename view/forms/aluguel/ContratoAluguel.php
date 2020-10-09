<?php
require_once dirname(__FILE__) . "/../../../libloader.php";

if(isset($_GET["id_aluguel"])){
	$id_contrato = $_GET["id_aluguel"];
}
if(isset($id_contrato)) {
$aluguelVestuarioController = new AluguelVestuarioController();
$aluguel = $aluguelVestuarioController->consultarAluguelPorId($id_contrato);
$listaAlugueisVestuarios = $aluguel->getListaAluguelVestuarios()->getElements();

$listaArquivosCss = array("demo_page.css", "demo_table.css", "form.css", "calendario/smoothness/ui.all.css", "jquery.autocomplete.css");
Util::includeArquivosCss($listaArquivosCss);

$listaArquivosJs = array("jquery/jquery-1.8.1.min.js", "jquery/jquery.printElement.js",);
				 
Util::includeArquivosJs($listaArquivosJs);
?>
 <script type="text/javascript">
			$(function(){
				$("#imprimir").click(function() {
						printDiv("imprimirContrato");
				});
			});

			function printDiv(div){
				$('#'+div).printElement();
			}
</script>
<div id="imprimirContrato" style="width: 780px; margin-top:40px; margin-left: 250px; ">
		<table width="100%" style="border: 1px solid #387AC8;" cellpadding="0" cellspacing="0">
		     <tr>
			   <td colspan="6" align="center"> 
					<div id="cabecalho" style="font-size: 12px;">
                            <div style="float: left;"><img src='../../img/logo-rel2.jpg' align="left" width="80px" height="110px"/></div>
                            <div style="float: left; text-align: center;">
                            <h1 style="border-bottom: 1px solid blue;">JOVEM MARIA NOIVAS E NOIVOS</h1>
							<strong>Jovem Maria Vestidos de Noivas Ltda - ME</strong> <br/>
                            CNPJ: 72.580.848/0001-48 CF/DF: 07.346.040/001-61 <br/>
                            Confecção, Aluguel de Vestidos de Noivas e Ternos, Damas, 1ª Eucaristia, Debutantes e Festas. <br/>
                            CNB 05 - Lote 04 - Loja 02 - Fone: 3352-2003 - Taguatinga - DF (Rua Riachuelo)
                         	</div>
                    </div>
			   </td>
			 </tr>
			 <tr>
			 <td colspan="6">
				 <table id="teste" class="tabelaInterna" width="100%" cellpadding="0" cellspacing="4">
				 <tr>
				    <td colspan="2" align="left" class="cabecalho2">
				    	<strong title="Dados Pessoais">DADOS DA LOCAÇÃO</strong>
				    </td>
				 </tr>
				 <tr>
				 	<td><label for="contrato" title="Nº do Contrato">Contrato:</label> &nbsp; <span id="contrato"><?php Util::exibirValor($aluguel->getId()); ?></span></td>
				 </tr>
				 <tr>
				   	<td> 
				      <label for="funcionario" title="Funcionário">Funcionário:</label> &nbsp; <?php Util::exibirValor($aluguel->getUsuario()->getNome()) ?>
				    </td>
				    <td> 
				      <label for="data_locacao" title="Data da Locação">Data/Hora da Locação:</label> &nbsp; <?php Util::exibirValor($aluguel->getDataLocacao()) ?>
				    </td>
	      	    </tr>
		        </table>
			 </td>
		  </tr>
		  <tr>
			 <td colspan="6">
				 <table class="tabelaInterna" width="100%" cellpadding="4" cellspacing="2">
				 <tr>
				    <td colspan="2" align="left" class="cabecalho2">
				    	<strong title="Dados Pessoais">DADOS DO CLIENTE</strong>
				    </td>
				 </tr>
		         <tr>
		           <td>
		             	<label for="cpf_cliente" title="CPF">CPF:</label> &nbsp; <span id="cpf_cliente"><?php Util::exibirValor($aluguel->getCliente()->getCpf()); ?></span>
			            <label for="rg_cliente" title="Rg">RG:</label> <span id="rg_cliente"><?php Util::exibirValor($aluguel->getCliente()->getRg()); ?></span>
			            <label for="orgao_expedicao_cliente" title="Orgão Expedição">Orgão Expedição/UF:</label> <span id="orgao_expedicao_cliente"><?php Util::exibirValor($aluguel->getCliente()->getOrgaoExpedicao()."/".$aluguel->getCliente()->getUfExpedicao()); ?></span>
			       </td>
			       <tr>
			       <td>
			            <label for="nome_cliente" title="Nome">Nome:</label> <span id="nome_cliente"><?php Util::exibirValor($aluguel->getCliente()->getNome()); ?></span>
			      </td>
			      </tr>
		          <tr>
			       <td>
			            <label for="cep_cliente" title="CEP">CEP:</label> <span id="cep_cliente"><?php Util::exibirValor($aluguel->getCliente()->getEndereco()->getCep()); ?></span>
				        <label for="endereco_cliente" title="Endereço">Endereço:</label> <span id="endereco_cliente"><?php Util::exibirValor($aluguel->getCliente()->getEndereco()->getLogradouro()); ?></span> 
				        <label for="cidade_cliente" title="Cidade">Cidade:</label> <span id="cidade_cliente"><?php Util::exibirValor($aluguel->getCliente()->getEndereco()->getCidade()." - ".$aluguel->getCliente()->getEndereco()->getEstado()); ?></span>
				   </td>
				   </tr>
		           <tr>
			       <td>
				        <label for="tel_residencial_cliente" title="Telefone Residencial">Fone:</label> <span id="tel_residencial_cliente"><?php Util::exibirValor($aluguel->getCliente()->getContato()->getTelResidencial()); ?></span>
				        <label for="email_cliente" title="E-mail">E-mail:</label> <span id="email_cliente"><?php Util::exibirValor($aluguel->getCliente()->getContato()->getEmail()); ?></span>
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
		            	 <strong title="Dados do Vestuário">DADOS DO VESTUÁRIO</strong>
		             </td>
			      </tr>
			      <tr>
				    <td colspan="4" class="ex_highlight">
			        <table style="width: 100%; font-size: 11px;" cellpadding="2" cellspacing="2" border="0" >
						<thead>
							<tr class='cabecalho2'>
								<td>Código</td>
								<td>Vestuário</td>
								<td>Categoria</td>
								<td>Cor</td>
								<td>Medidas</td>
								<td>Tamanho</td>
								<td>Valor do Aluguel</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($listaAlugueisVestuarios as $indice => $aluguelVestuario) { 
								$estoque = $aluguelVestuario->getEstoque();
								$vestuario = $estoque->getVestuario();
								$categoria = $vestuario->getCategoria();
							?>
								<tr>
									<td><?php echo $estoque->getCodigoVestuario(); ?></td>
									<td><?php echo $vestuario->getNome(); ?></td>
									<td><?php echo $categoria->getDescricao(); ?></td>
									<td><?php echo $vestuario->getCor(); ?></td>
									<td><?php echo $vestuario->getMedidas(); ?></td>
									<td><?php echo $vestuario->getTamanho(); ?></td>
									<td><?php echo $vestuario->getValorAluguel(); ?></td>
								</tr>
							<?php } ?>
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
					        <?php Util::exibirValor($aluguel->getDataEntrega()); ?>
						  </td>
						  <td>
					        <label for="data_prevista_devolucao" title="Data de Devolução">Data Prevista de Devolução:</label> &nbsp;
						 	<?php Util::exibirValor($aluguel->getDataPrevistaDevolucao()); ?>
						  </td>
					  </tr>
					  <tr>
						  <td>
						    <label for="data_previa" title="Data da Prévia">Data da Prévia:</label> &nbsp;
						 	<?php Util::exibirValor($aluguel->getDataPrevia()); ?>
						  </td>
						  <td>
						    <label for="data_prova" title="Data da Prova">Data da Prova:</label> &nbsp;
						 	<?php Util::exibirValor($aluguel->getDataProva()); ?>
						  </td>
				      </tr>
			       </table>
			 </td>
	   </tr>
	   <tr>
       <td colspan="6">
	    <table class="tabelaInterna" width="100%" align="center" cellpadding="0" cellspacing="4">
	        <tr>
	   			<td colspan="20" align="left" class="cabecalho2">
	   				<strong title="Dados do Pagamento">DADOS DO PAGAMENTO</strong>
	   			</td>
		    </tr>
	       <tr>
	       <td colspan="2">
 	  	   	<label for="valor_total" title="Valor Total">Valor Total á Pagar:</label> 
 	  	   	<span id="valor_total"><?php Util::exibirValor($aluguel->getValorTotalAluguel()); ?></span>
	 	   </td>
	       <td>
	        <label for="forma_pagamento" title="Forma de Pagamento">Forma de Pagamento:</label>
	       </td>	
		   <td>
	        <span id="forma_pagamento"><?php Util::exibirValor($aluguel->getPagamento()->getTipoPagamento()); ?></span>
	      </td>
	      </tr>
	      <tr id="cmp_parcelas">
	      <td>
	        <label for="qtd_parcelas" title="Quantidade de Parcelas" >Parcelas:</label>
	      </td>	
		  <td> 
	        <span id="qtd_parcelas"><?php Util::exibirValor($aluguel->getPagamento()->getNumParcelas()); ?></span>
	      </td>
	      <td>
	        <label for="valor_parcela" id="cmp_valor_parcela" title="Valor das Parcelas">Valor das Parcelas:</label>
	      </td>
	      <td>
	        <span id="valor_parcela"><?php Util::exibirValor($aluguel->getPagamento()->getValorParcelas()); ?></span>
	      </td>
	      </tr>
	      <tr>
           <td>
	        <label for="valor_entrada" title="Valor da Entrada">Entrada (R$):</label>
	      </td>	
		  <td>  
	        <span id="valor_entrada"><?php Util::exibirValor($aluguel->getPagamento()->getEntrada()); ?></span>
	      </td>
	      <td>
	        <label for="falta_pagar" title="Falta Pagar">Falta Pagar (R$):</label>
	      </td>	
		  <td>
		    <span id="falta_pagar"><?php Util::exibirValor($aluguel->getPagamento()->getFaltaPagar()); ?></span>
	      </td>
        </tr>
	   </table>
	   	</td>
	   </tr>
	   <tr>
			 <td colspan="6">
				 <table class="tabelaInterna" width="100%" cellpadding="4" cellspacing="2">
					 <tr>
					    <td colspan="2" align="left" class="cabecalho2">
					    	<strong title="Cláusulas">CLÁUSULAS</strong>
					    </td>
					 </tr>
			         <tr>
			           <td>Cláusula Primeira: Deixar um caução no valor de R$ (&nbsp;&nbsp;&nbsp;) em via promissoria 
			           correspondente á roupa solicitada, que será restituído mediante devolução da mesma.</td>
			         </tr>
			         <tr>
			           <td>Cláusula Segunda: Devolver a roupa após o prazo estipulado, estará sujeito ao pagamento de 02 (dois) ou mais 
			           o valor do aluguel.</td>
			         </tr>
			         <tr>
			           <td>Cláusula Terceira: Devolver a roupa em perfeito estado de conservação.</td>
				     </tr>
				     <tr>
			           <td>Cláusula Quarta: É de inteira responsabilidade do(a) cliente, todos os danos que forem 
			           causados à roupa, que será cobrado no valor de mercado.</td>
				     </tr>
				     <tr>
			           <td>Cláusula Quinta: A loja só fará a entrega das roupas após o recebimento integral do aluguel ou 
			           negociação que garanta o pagamento de acordo com as normas da empresa.</td>
				     </tr>
				     <tr>
			           <td>Parágrafo Único - ATENÇÃO: A roupa somente será alugada mediante o pagamento da entrada.
			           Em caso de desistência posterior a assinatura deste contrato, o valor já recebido não será devolvido,
			           ficando o mesmo para ressacir a loja o direito de reserva imposto pelo (a) cliente no ato da encomenda. </td>
				     </tr>
		        </table>
		        <p></p>
     			<div style="text-align: right; margin: 32px; margin-bottom: 50px;">Brasília - DF, <?php Util::dataPorExtenso(); ?></div>
     			<div style="text-align:center; width:40%; border-top-width:100%; border-top:1px solid; float: left; margin-left: 40px;">
     				Assinatura do Contratante
     			</div>
     			<div style="text-align:center; width:40%; border-top-width:100%; border-top:1px solid; float: right; margin-right: 40px;">
     				Assinatura do Contratado
     			</div>
			 </td>
		  </tr>
     </table>
 </div>
 <p><br/></p>
 <span class="button" style="margin-left: 40%;">
 	<input type="button" name="imprimir" id="imprimir" title="Imprimir Contrato" value="Imprimir Contrato" />
 </span>
 <p><br/></p>
 <?php 
} else {
	Util::alert("Informe o número do contrato!");
}
?>