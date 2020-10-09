<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";
   
$funcionario = new Funcionario();
$funcionario->setContato(new Contato());
$funcionario->setEndereco(new Endereco());

if(isset($_GET['cpf'])){
   $funcionarioController = new FuncionarioController();
   $funcionario = $funcionarioController->consultarFuncionarioPorCpf(($_GET['cpf']));    	
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
       <div class="top-left"><div id="titulo_form">DETALHAMENTO DO FUCIONÁRIO
       <a href="#" class="close" onclick="fecharModal();">X Fechar</a>
       </div></div>
	    <div class="top-right"></div>
		 <div class="inside">
  	<form id="funcionarioForm" method="post" action="../../../controller/FuncionarioController.class.php" enctype="multipart/form-data">
		<table class="tabela" style="width: 100%;" cellpadding="0" cellspacing="4">
          <tr>
          <td>
          <table class="tabelaInterna">
			    <tr>
		   			<td colspan="10" align="left" class="cabecalho2">
		   				<strong title="Dados Pessoais">DADOS PESSOAIS</strong>
		   			</td>
				</tr>
				<tr>
					<td align="center" >
						<?php echo $funcionario->getFoto()?>
			      	</td>
		      	  </tr>
		      	<tr>
		      		<td> 
				        <label for="cpf" title="CPF">CPF:</label>
				    </td>
				    <td>
				       <?php echo $funcionario->getCpf(); ?>
			      	</td>
				    <td>
				        <label for="rg" title="rg">RG:</label>
				     </td>	
					 <td>   
				       <?php Util::exibirValor($funcionario->getRg()); ?>
				     
				     </td>
		      	</tr>
		        <tr>
				     <td>
				        <label for="nome" title="Nome">Nome:</label>
				  	 </td>	
				     <td>     
				        <?php Util::exibirValor($funcionario->getNome()); ?>
			      	 </td>
				     <td>
				        <label for="orgao_expeditor" title="Orgão Expeditor/UF">Orgão Expeditor/UF:</label>
				     </td>	
					 <td>   
		        		<?php 
						      echo  $funcionario->getEndereco()->getEstado();
						    ?>
				     </td>
		        </tr>
		      	<tr>
		      	   <td>
		      	   		<label for="estado_civil" title="Estado Civil">Estado Civil:</label>
		      	   </td>
		      	   <td>
		     	   		<?php 
			      	   		 echo  $funcionario->getEstadoCivil();
		      	   		?>
		      	   </td>
		      	   <td>
				        <label for="data_nascimento" title="Data de Nascimento">Data de Nascimento:</label>
				     </td>	
					 <td>   
				        <?php Util::exibirValor($funcionario->getDataNascimento()); ?>
				    </td>
		      	  </tr>
		      	  <tr>
		      	   <td>
				        <label for="sexo" title="Sexo">Sexo:</label>
				   </td>	
				   <td>     
				      <?php echo $funcionario->getSexo(); ?> 
			       </td>
		      	   <td>
		      	   		<label for="grau_instrucao" title="Grau de Instrunção">Grau de Instrunção:</label>
		      	   </td>
		      	   <td>
	      	   		<?php echo $funcionario->getGrauInstrucao(); ?>
		      	   </td>
		      </tr>
     	    </table>
	       </td>
	       </tr>
	      <tr>
	      <td>
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
			  <td>   
                <?php Util::exibirValor($funcionario->getEndereco()->getCep()); ?>
		      </td>
	      </tr>
	      <tr>
		      <td >
		        <label for="endereco" title="Endereço">Endereço:</label>
		      </td>	
			  <td >
		        <?php Util::exibirValor($funcionario->getEndereco()->getLogradouro()); ?>
		      </td>
		      <td>
		        <label for="numero" title="Número">Número:</label>
		      </td>	
			  <td>
		        <?php Util::exibirValor($funcionario->getEndereco()->getNumero()); ?>
		      </td>
		      <td>
		        <label for="bairro" title="Bairro">Bairro:</label>
		      </td>	
			  <td >
		        <?php Util::exibirValor($funcionario->getEndereco()->getBairro()); ?>
		      </td>
           </tr>
           <tr>
	       <td>
	        <label for="cidade" title="Cidade">Cidade:</label>
	       </td>	
		    <td>
		        <?php Util::exibirValor($funcionario->getEndereco()->getCidade()); ?>
	        </td>
	        <td>
	        	<label for="estado" title="Estado">Estado:</label>
	        </td>	
		    <td>
			    <?php echo  $funcionario->getEndereco()->getEstado(); ?>
	      </td>
	      <td>
	        <label for="complemento" title="Complemento">Complemento:</label>
	      </td>	
		  <td>
	       <?php Util::exibirValor($funcionario->getEndereco()->getComplemento()); ?>
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
		        <?php Util::exibirValor($funcionario->getContato()->getTelResidencial()); ?>
		      </td>
		      <td>
		        <label for="tel_celular" title="Telefone Celular 1">Telefone Celular 1:</label>
		      </td>	
			  <td>  
		        <?php Util::exibirValor($funcionario->getContato()->getTelCelular()); ?>
		      <td>
		        <label for="tel_celular2" title="Telefone Celular 2">Telefone Celular 2:</label>
		      </td>	
			  <td> 
		        <?php Util::exibirValor($funcionario->getContato()->getTelComercial()); ?>
		        </td>
	          </tr>
	        <tr>
		      <td>
			      <label for="email" title="E-mail">E-mail:</label>
			   </td>	
			   <td>   
			     <?php Util::exibirValor($funcionario->getContato()->getEmail()); ?>
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
			      <?php Util::exibirValor($funcionario->getCtps()); ?>
		       </td>
		      <td>
		        <label for="num_serie" title="Número de Série da CTPS">Nº. Série:</label>
		      </td>	
			  <td>  
		        <?php Util::exibirValor($funcionario->getNumeroSerie()); ?>
		      </td>
		      <td>
		        <label for="cargo" title="Cargo">Cargo:</label>
		      </td>	
			  <td>  
		        <?php Util::exibirValor($funcionario->getCargo()); ?>
		      </td>
	      </tr>
	      <tr>
		      <td>
		        <label for="salario" title="Sálario">Sálario:</label>
		      </td>	
		      <td> 
		        <?php Util::exibirValor($funcionario->getSalarioLiquido()); ?>
		      </td>
			  <td>
		        <label for="comissao" title="Comissão (%)">Comissão (%):</label>
		      </td>	
		      <td> 
		       <?php Util::exibirValor($funcionario->getComissao()); ?>
		      </td>
		      <td>
		        <label for="data_admissao" title="Data de Admissão">Data de Admissão:</label>
		      </td>	
			  <td> 
		        <?php Util::exibirValor($funcionario->getDataAdmissao()); ?>
		      </td>
	      </tr>
	         <tr>
	      	  <td>
		        <label for="data_demissao" title="Data de Demissão">Data de Demissão:</label>
		      </td>	
			  <td> 
                <?php Util::exibirValor($funcionario->getDataDemissao()); ?>
		      </td>
	      </tr>
        </table>
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