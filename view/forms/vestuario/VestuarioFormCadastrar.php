<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";

$vestuario = new Vestuario();
$vestuario->setFornecedor(new Fornecedor());
$vestuario->setCategoria(new Categoria());
$categoriaController = new CategoriaController();
$fornecedorController = new FornecedorController();

if(Util::editarDadosFormulario('id')) {
	$vestuarioController = new VestuarioController();
	$vestuario = $vestuarioController->consultarVestuarioPorId($_GET['id']);
}

function isEditavel(){
	global $vestuario;
	return (Util::editarDadosFormulario('id') && $vestuario != null && $vestuario->getId() != null);
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
<script type="text/javascript">
	var url = "../vestuario/VestuarioFormCadastrar.php";

	$(function(){
		$(document).ready(function(){
		    $('#tabelaEstoque').dataTable({
		    	"bJQueryUI": true, //muda o tema da pagina
		    	"bProcessing": true,
		        "sPaginationType": "full_numbers", //muda o tipo da paginacao
		        "oLanguage": {"sUrl": "../../js/jquery/datatables.Portuguese.txt"}, //traduz os textos da biblioteca para portugues
		    	"aaSorting": [[ 0, "asc" ]] //ordenacao inicial
		    });
		});
		
		$("#nome").blur(function(event){
	  		verificarNome("Vestuario");
		});
		
		$("#cadastrar").click(function(event) {
		    event.preventDefault();
		    if(validarCampos()){
		    	executarAcao("cadastrar&url="+url, true); 
		    } else {
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
		    } else {
				return false;
			}
		});
		
		$("#novoCadastro").click(function(event) {
		    abrirPag(url);
		});
		
		$("#imprimirEtquetas").click(function(event) {
			window.open("../vestuario/ImprimirTodasEtiquetas.php?id_vestuario="+$("#id").val());
		});

		$("#valor_vestuario").priceFormat({
		        prefix: 'R$ ',
		        centsSeparator: ',',
		        thousandsSeparator: '.'
		 });

		$("#valor_aluguel").priceFormat({
		        prefix: 'R$ ',
		        centsSeparator: ',',
		        thousandsSeparator: '.'
		});
		
	});

	function gerarEtiqueta(cod){
		var nome = document.getElementById("nome").value;
		window.open("../vestuario/ImprimirEtiqueta.php?codigo="+cod+"&vestuario="+nome);
	}
</script>
 	<!-- popup modal -->
		<div id="boxes">
			<div id="divFormCategoria" class="window">
				<?php require_once '../categoria/CategoriaFormCadastrar.php'; ?>
			</div>
			<!-- Máscara para cobrir a tela -->
	  		<div id="mask">
	  		</div>
  		</div>
     <!-- Header --> 
      <div id="form" style="width: 950px; position:absolute; top:50px;">
          <div class="top-left"></div>
	      <div class="top-right">
       		<div id="titulo_form">
            	<?php echo (isEditavel()) ? "ATUALIZAÇÃO DO VESTUÁRIO" : "CADASTRO DE VESTUÁRIO"; ?>
		    </div>
		 </div>
		 <div class="inside">
		 <form id="vestuario" method="post" action="../../../controller/VestuarioController.class.php" enctype="multipart/form-data">
			<table class="tabela" width="100%" cellpadding="0" cellspacing="4">
    		 <tr>
			  <td colspan="6" align="center"> 
			       <input type="hidden" name="nome_arquivo" value="<?php echo Util::getNomeArquivo(); ?>"/>
		   			<div id="msgCampoObrigatorio">Preencha os campos obrigatórios!</div>
		   			<?php Util::exibirMsg("o", "Vestuario"); ?>
		   	  </td>
		   </tr>
           <tr>
   		     <td colspan="4" align="left" class="cabecalho2"><strong title="Dados do Vestuário">Dados do Vestuário</strong></td>
	       </tr>
	       <tr>
	       	 <td>
		      <label for="cnpj_fornecedor" title="Fornecedor">Fornecedor:</label>
		     </td>	
		     <td>   
		       <select id="cnpj_fornecedor" name="cnpj_fornecedor" style="width: 240px;" class="requerSelecao" title="Selecione um Fornecedor">
		        <?php echo $fornecedorController->carregarComboFornecedor($vestuario->getFornecedor()->getCnpj()); ?> 
		       </select>
		       <span class="asterico">*</span>	
		       <!-- <a href="#divFormFornecedor" name="modal" >Novo Fornecedor</a>  -->
	         </td>
	         <td>
		      <label for="codigo_categoria" title="Categoria">Categoria:</label>
		     </td>	
		     <td>   
		       <select id="codigo_categoria" name="codigo_categoria" style="width: 240px;" class="requerSelecao" title="Selecione uma Categoria">
		        <?php echo $categoriaController->carregarComboCategoria($vestuario->getCategoria()->getCodigo()); ?> 
		       </select>
		       <span class="asterico">*</span>	
		       <!-- <a href="#divFormCategoria" name="modal" >Nova Categoria</a>  -->
	         </td>
	       </tr>
           <tr>
	         <td>
		       <label for="nome" title="Nome">Nome:</label>
		     </td>	
		     <td>   
		        <input type="text" name="nome" id="nome" title="Informe o Nome do Vestuário" class="requerido" maxlength="25" value="<?php Util::exibirValor($vestuario->getNome()); ?>"/>
	       	    <span class="asterico">*</span>	
	         </td>
	         <td valign="top" rowspan="3">
	            <label for="medidas" title="Medidas">Medidas:</label>
	         </td>	
		     <td rowspan="3">
			    <textarea rows="5" cols="36"  name="medidas" id="medidas"  class="requerido" title="Informe a Descrição"><?php Util::exibirValor($vestuario->getMedidas()); ?></textarea> 
	         	<span class="asterico">*</span>
	         </td>
           </tr>
           <tr>
	          <td>
	          <label for="cor" title="Cor">Cor:</label>
	          </td>	
		      <td> 
	            <input type="text" name="cor" id="cor" title="Informe a Cor do Vestuário" style="width: 240px;" class="requerido" maxlength="100" value="<?php Util::exibirValor($vestuario->getCor()); ?>"/>
	            <span class="asterico">*</span>	
	          </td>
           </tr>
           <tr>
	          <td>
		        <label for="tamanho" title="Tamanho do Vestuario">Tamanho:</label>
		      </td>	
		      <td>   
		        <input type="text" name="tamanho" id="tamanho" title="Informe o Tamanho do Vestuário" style="width: 240px;"  class="requerido" maxlength="100" value="<?php Util::exibirValor($vestuario->getTamanho()); ?>"/>
	       	    <span class="asterico">*</span>	
	          </td>
           </tr>
           <tr>
		      <td>
	           <label for="valor_vestuario" title="Valor do Vestuário">Valor do Vestuário:</label>
	          </td>	
		      <td>
	           <input type="text" name="valor_vestuario" id="valor_vestuario" title="Informe o Valor do Vestuário" style="width: 240px;" class="requerido" maxlength="15" value="<?php Util::exibirValor($vestuario->getValorVestuario()); ?>"/>
	           <span class="asterico">*</span>	
	          </td>
	          <td valign="top" rowspan="3">
	            <label for="observacao" title="Observação">Observação:</label>
	          </td>	
		      <td rowspan="3">
		     	<textarea rows="5" cols="36"  name="observacao" id="observacao" title="Informe a Observação"><?php Util::exibirValor($vestuario->getObservacao()); ?></textarea> 
	          </td>
            </tr>
           <tr>
		     <td>
	           <label for="valor_aluguel" title="Valor do Aluguel">Valor do Aluguel:</label>
	         </td>	
		     <td>
	           <input type="text" name="valor_aluguel" id="valor_aluguel" title="Informe o Valor do Aluguel" style="width: 240px;" class="requerido" maxlength="15" value="<?php Util::exibirValor($vestuario->getValorAluguel()); ?>"/>
	           <span class="asterico">*</span>	
	         </td>
          </tr>
          <tr>
		     <td colspan="4">
	           <label for="quantidade" title="Quantidade de Vestuários em Estoque">Quantidade de Vestuários em Estoque:</label> &nbsp;
	           <input type="text" name="quantidade" id="quantidade" title="Informe a Quantidade de Vestuários em Estoque" style="width: 126px;" maxlength="7" value="<?php Util::exibirValor($vestuario->getQuantidade()); ?>"/>
	         </td>
          </tr>
          <tr>
          	<td colspan="4">
          	<?php if(isEditavel()){  ?>
	            <table cellpadding="0" cellspacing="0" border="0" class="display" id="tabelaEstoque">
	            	<thead>
		            	<tr class='even gradeC'>
			            	<th>Código Vestuário</th>
			            	<th>Status</th>
			            	<th>Opções</th>
			            </tr>
	            	</thead>
	            	<tbody>
	            	<?php 
			    		foreach ($vestuario->getListaEstoque()->getElements() as $indice => $estoque){
						  echo "<tr class='even gradeC'>"
							  	 ."<td align='center'>" . $estoque->getCodigoVestuario() . "</td>"
							  	 ."<td align='center'>" . Util::exibirStatusVestuario($estoque->getStatus()) . "</td>"
								 ."<td align='center'>
							 		<span class='button'><input type='button' name='excluirEstoque' value='Excluir' onclick=\"executarAcao('excluirEstoque&codigo={$estoque->getCodigoVestuario()}')\" /></span> 
							 		<span class='button'><input type='button' name='imprimirEtiqueta' value='Imprimir Etiqueta' style='width: 130px;' onclick=\"gerarEtiqueta('{$estoque->getCodigoVestuario()}')\" /></span>"
								 ."</td>"
								 ."</tr>";
					    }
			    	?>
			    	</tbody>
	            </table>
	         <?php } ?>
	         </td>
          <tr>
			<td colspan="4">	
			 	<span class="asterico" title="* Campos obrigatórios!">* Campos obrigatórios!</span><p/>
			 	<div id="botoes" style="margin-left:5px;">
		  	 <?php if(isEditavel()){  ?>
		   			<input type="button" class="botao" name="novoCadastro" id="novoCadastro" style="width: 120px;" title="Novo Cadastro" value="Novo Cadastro" /> &nbsp;
		 		  	<input type="submit" name="atualizar" id="atualizar" title="Atualizar" value="Atualizar" <?php PermissaoController::desabilitarBotao("VESTUÁRIO", "atualizar"); ?>/> &nbsp;
				  	<input type="button" name="excluir" id="excluir" title="Excluir" value="Excluir" <?php PermissaoController::desabilitarBotao("VESTUÁRIO", "excluir"); ?>/> &nbsp;
				  	<input type="button" name="imprimirEtquetas" id="imprimirEtquetas" style="width: 130px;" title="Imprimir Todas as Etiquetas" value="Imprimir Etiquetas" <?php PermissaoController::desabilitarBotao("VESTUÁRIO", "imprimir"); ?>/> &nbsp;
		  			<input type="button" class="botao" name="cancelar" id="cancelar" title="Cancelar" value="Cancelar" />
		   	 		<input type="hidden" name="id" id="id" value="<?php Util::exibirValor($vestuario->getId()); ?>" />
		  	 <?php } else { ?>
			   	 	<input type="submit" name="cadastrar" id="cadastrar" title="Cadastrar" value="Cadastrar" <?php PermissaoController::desabilitarBotao("VESTUÁRIO", "cadastrar"); ?>/> &nbsp;
				  	<input type="button" class="botao" name="cancelar" id="cancelar" title="Cancelar" value="Cancelar" />
		   	 <?php } ?>
	   	   </div>
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
     