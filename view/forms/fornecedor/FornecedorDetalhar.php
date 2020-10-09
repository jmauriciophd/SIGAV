<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";
   
    $fornecedor = new Fornecedor();
	$fornecedor->setContato(new Contato());
	$fornecedor->setEndereco(new Endereco());
	
if(isset($_GET['cnpj'])) {
   $fornecedorController = new FornecedorController();
   $fornecedor = $fornecedorController->consultarFornecedorPorCnpj($_GET['cnpj']);
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
       <div class="top-left"><div id="titulo_form">DETALHAMENTO DO FORNECEDOR
       <a href="#" class="close" onclick="fecharModal();" >X Fechar</a>
       </div></div>
	    <div class="top-right"></div>
		 <div class="inside">
		 <form id="fornecedor" method="post" action="../../../controller/FornecedorController.class.php" enctype="multipart/form-data">
			<table class="tabela" width="100%" cellpadding="0" cellspacing="4">
    		 <tr>
			  <td colspan="6" align="center"> 
			       <input type="hidden" name="nome_arquivo" value="<?php echo Util::getNomeArquivo(); ?>"/>
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
			  <?php	echo $fornecedor->getCnpj(); ?>
		     </td>
		     <td>
		        <label for="razao_social" title="Razão Social">Razão Social:</label>
		     </td>	
			 <td>   
		        <?php Util::exibirValor($fornecedor->getRazaoSocial()); ?>
		     </td>
           </tr>
           <tr>
	        <td>
		        <label for="nome_fantasia" title="Nome Fantasia">Nome Fantasia:</label>
		    </td>	
		    <td>     
		        <?php Util::exibirValor($fornecedor->getNomeFantasia()); ?>
	        </td> 
	        <td>
	        <label for="inscricao_estadual" title="Inscrição Estadual">Inscrição Estadual:</label>
	        </td>	
		    <td>  
	       <?php Util::exibirValor($fornecedor->getInscricaoEstadual()); ?>
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
		        <?php Util::exibirValor($fornecedor->getEndereco()->getCep()); ?>
		      </td>
	      </tr>
	      <tr>
		      <td >
		        <label for="endereco" title="Endereço">Endereço:</label>
		      </td>	
			  <td >
		       <?php  Util::exibirValor($fornecedor->getEndereco()->getLogradouro()); ?>
		      </td>
		      <td>
		        <label for="numero" title="Número">Número:</label>
		      </td>	
			  <td>
		        <?php   Util::exibirValor($fornecedor->getEndereco()->getNumero()); ?>
		      </td>
		     </tr>
		     <tr> 
		      <td>
		        <label for="bairro" title="Bairro">Bairro:</label>
		      </td>	
			  <td>
		         <?php Util::exibirValor($fornecedor->getEndereco()->getBairro()); ?>
		      </td>
             <td>
	        <label for="cidade" title="Cidade">Cidade:</label>
	       </td>	
		    <td>
	            <?php  Util::exibirValor($fornecedor->getEndereco()->getCidade()); ?>
	        </td>
	       </tr>
	       <tr>
	        <td>
	        <label for="estado" title="Estado">Estado:</label>
	        </td>	
		    <td>
	        	<?php 
			      echo  $fornecedor->getEndereco()->getEstado();
			    ?>
			</td>
	      <td>
	        <label for="complemento" title="Complemento">Complemento:</label>
	      </td>	
		  <td>
	           <?php  Util::exibirValor($fornecedor->getEndereco()->getComplemento()); ?>
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
			    <?php Util::exibirValor($fornecedor->getContato()->getEmail()); ?>

		       </td>
		      <td width="10%">
		        <label for="tel_comercial" title="Telefone Comercial">Tel. Comercial:</label>
		      </td>	
			  <td width="20%">  
		        <?php Util::exibirValor($fornecedor->getContato()->getTelComercial()); ?>
		      </td>
	       </tr>
		 </table>
		</form>
	   <!-- Trailler -->
        </div>
	   <div class="bottom-left">
	  </div>
	 <div class="bottom-right" style="padding-left:35px;"></div>
   </div>