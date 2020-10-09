<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";
   
$cliente = new Cliente();
$cliente->setContato(new Contato());
$cliente->setEndereco(new Endereco());

if(isset($_GET['cpf'])){
   $clienteController = new ClienteController();
   $cliente = $clienteController->consultarClientePorCpf($_GET['cpf']);    	
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
       <div class="top-left"><div id="titulo_form">DETALHAMENTO DO CLIENTE
       <a href="#" class="close" onclick="fecharModal();">X Fechar</a>
       </div></div>
	    <div class="top-right"></div>
		 <div class="inside">
		 <form id="cliente" method="post" action="../../../cliente/ClienteController.class.php" enctype="multipart/form-data">
			<table class="" width="100%" cellpadding="0" cellspacing="4">
		          <tr>
				 	<td colspan="10" align="left" class="cabecalho2"><strong title="Dados Pessoais">DADOS PESSOAIS</strong></td>
					 </tr>
					 <tr>
					 <td> 
					   <label  title="CPF">CPF:</label>
					  </td>
					   <td>
					    <?php echo $cliente->getCpf(); ?>
					    </td>
					    <td>
					    <label  title="Nome">Nome:</label>
					    </td>						   
					   <td>     
						<?php Util::exibirValor($cliente->getNome()); ?>
					 </td>
					 </tr>
					 <tr>
					 <td>
					     <label title="rg">RG:</label>
					 </td>	
					 <td>   
					    <?php Util::exibirValor($cliente->getRg()); ?>
					 </td>
					 <td>
					     <label  title="Orgão Expeditor/UF">Orgão Expeditor/UF:</label>
					 </td>	
					 <td>   
						<?php 
					       	echo $cliente->getEndereco()->getEstado();
						    ?>
					 </td>
					 </tr>
					 <tr>
				     <td>
					     <label  title="Data de Nascimento">Data de Nascimento:</label>
					  </td>	
					  <td>   
						<?php Util::exibirValor(Util::formataDataPtBr($cliente->getDataNascimento())); ?>
					  </td>
				      <td>
				          <label title="Estado Civil">Estado Civil:</label>
				      </td>
				      <td>
				         <?php 
						     echo  $cliente->getEstadoCivil();
					     ?>
				       </td>
				       </tr>
				       <tr>
				  	   <td>
					      <label  title="Sexo">Sexo:</label>
					   </td>	
					   <td>     
					       <?php echo  $cliente->getSexo(); ?> 
					    </td>
					    </tr>
					   <tr>
				      <td colspan="6" align="left" class="cabecalho2"><strong title="Dados do Endereço">DADOS DO ENDEREÇO</strong></td>
				      </tr>
				      <tr>
				      <td>
				        <label title="CEP">CEP:</label>
				      </td>	
					  <td>   
				        <?php Util::exibirValor($cliente->getEndereco()->getCep()); ?>
				      </td>
				      </tr>
				      <tr>
			          <td>
				        <label title="Endereço">Endereço:</label>
				      </td>	
					  <td >
				       <?php Util::exibirValor($cliente->getEndereco()->getLogradouro()); ?>
				      </td>
				      <td>
				        <label title="Número">Número:</label>
				      </td>	
					  <td>
				       <?php Util::exibirValor($cliente->getEndereco()->getNumero()); ?>
				      </td>
				      </tr>
				      <tr>
				     <td>
				        <label  title="Bairro">Bairro:</label>
				      </td>	
					  <td>
				        <?php Util::exibirValor($cliente->getEndereco()->getBairro()); ?>
				      </td>
		             <td>
			            <label  title="Cidade">Cidade:</label>
			        </td>	
				    <td>
			            <?php Util::exibirValor($cliente->getEndereco()->getCidade()); ?>
		    	    </td>
		    	    </tr>
		    	    <tr>
				    <td>
			           <label  title="Estado">Estado:</label>
			        </td>	
				    <td>
			   		    <?php 
					      echo $cliente->getEndereco()->getEstado();
				        ?>
			       </td>
			       <td>
			          <label  title="Complemento">Complemento:</label>
			       </td>	
				   <td>
			            <?php Util::exibirValor($cliente->getEndereco()->getComplemento()); ?>
			       </td>
			       </tr>
			       <tr>
			  	   <td colspan="6" align="left" class="cabecalho2"><strong title="Dados de Contato">DADOS DO CONTATO</strong></td>
				   </tr>
				   <tr>
				   <td>
					   <label title="E-mail">E-mail:</label>
				   </td>	
				   <td>   
					    <?php Util::exibirValor($cliente->getContato()->getEmail()); ?>
				   </td>
				   <td>
				       <label  title="Telefone Residencial">Tel. Residencial:</label>
				   </td>	
				   <td>  
				       <?php Util::exibirValor($cliente->getContato()->getTelResidencial()); ?>
				   </td>
				   </tr>
				   <tr>
			       <td>
				       <label  title="Telefone Celular">Telefone Celular:</label>
				   </td>	
				  <td>  
				        <?php Util::exibirValor($cliente->getContato()->getTelCelular()); ?>
				      </td>
			       <td>
			        <label title="Twitter">Twitter:</label>
			      </td>	
				  <td> 
			        <?php Util::exibirValor($cliente->getContato()->getTwitter()); ?>
			      </td>
			      </tr>
			      <tr>
		          <td>
			        <label title="Facebook">Facebook:</label>
			      </td>
				  <td>
			        <?php 	Util::exibirValor($cliente->getContato()->getFacebook()); ?>
			      </td>
		         </tr>
			 </table>
			</form>
  	 <!-- Trailler -->
     </div>
	<div class="bottom-left"></div>
	<div class="bottom-right" style="padding-left:35px;"></div>
 </div>