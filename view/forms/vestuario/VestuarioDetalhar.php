<?php 
require_once dirname(__FILE__) . "/../../../libloader.php";

$vestuario = new Vestuario();
$vestuario->setFornecedor(new Fornecedor());
$vestuario->setCategoria(new Categoria());
$categoriaController = new CategoriaController();
$fornecedorController = new FornecedorController();

if(isset($_GET['id'])) {
	$vestuarioController = new VestuarioController();
	$vestuario = $vestuarioController->consultarVestuarioPorId($_GET['id']);
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
		
		$("#imprimirEtquetas").click(function(event) {
			window.open("../vestuario/ImprimirTodasEtiquetas.php?id_vestuario="+$("#id").val());
		});
	});

	function gerarEtiqueta(cod){
		var nome = document.getElementById("nome").value;
		window.open("../vestuario/ImprimirEtiqueta.php?codigo="+cod+"&vestuario="+nome);
	}
</script>
     <!-- Header --> 
      <div id="form" style="position:absolute;">
          <div class="top-left"><div id="titulo_form">DETALHAMENTO DO VESTUÁRIO
           <a href="#" class="close" onclick="fecharModal();">X Fechar</a>
          </div>
          </div>
	      <div class="top-right"></div>
		 <div class="inside">
		 <form id="vestuario" method="post" action="../../../controller/VestuarioController.class.php" enctype="multipart/form-data">
			<table class="tabela" width="100%" cellpadding="2" cellspacing="2">
    		 <tr>
			  <td colspan="6" align="center"> 
			       <input type="hidden" name="nome_arquivo" value="<?php echo Util::getNomeArquivo(); ?>"/>
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
		        <?php echo $vestuario->getFornecedor()->getNomeFantasia(); ?> 
	         </td>
	         <td>
		      <label for="codigo_categoria" title="Categoria">Categoria:</label>
		     </td>	
		     <td>   
		       <?php echo $vestuario->getCategoria()->getDescricao(); ?>
	         </td>
	       </tr>
           <tr>
	         <td>
		       <label for="nome" title="Nome">Nome:</label>
		     </td>	
		     <td>   
		        <?php Util::exibirValor($vestuario->getNome()); ?>
	         </td>
	         <td valign="top" rowspan="3">
	            <label for="medidas" title="Medidas">Medidas:</label>
	         </td>	
		     <td rowspan="3">
			    <?php Util::exibirValor($vestuario->getMedidas()); ?> 
	         </td>
           </tr>
           <tr>
	          <td>
	          <label for="cor" title="Cor">Cor:</label>
	          </td>	
		      <td> 
	           <?php Util::exibirValor($vestuario->getCor()); ?>
	          </td>
           </tr>
           <tr>
	          <td>
		        <label for="tamanho" title="Tamanho do Vestuario">Tamanho:</label>
		      </td>	
		      <td>   
		        <?php Util::exibirValor($vestuario->getTamanho()); ?>
	          </td>
           </tr>
           <tr>
		      <td>
	           <label for="valor_vestuario" title="Valor do Vestuário">Valor do Vestuário:</label>
	          </td>	
		      <td>
	          <?php Util::exibirValor($vestuario->getValorVestuario()); ?>
	          </td>
	          <td valign="top" rowspan="3">
	            <label for="observacao" title="Observação">Observação:</label>
	          </td>	
		      <td rowspan="3">
		     	<?php Util::exibirValor($vestuario->getObservacao()); ?>
	          </td>
            </tr>
           <tr>
		     <td>
	           <label for="valor_aluguel" title="Valor do Aluguel">Valor do Aluguel:</label>
	         </td>	
		     <td>
	           <?php Util::exibirValor($vestuario->getValorAluguel()); ?>
	         </td>
          </tr>
          <tr>
		     <td colspan="4">
	           <label for="quantidade" title="Quantidade de Vestuários em Estoque">Quantidade de Vestuários em Estoque:</label> &nbsp;
	           <?php Util::exibirValor($vestuario->getQuantidade()); ?>
	         </td>
          </tr>
          <tr>
          	<td colspan="4">
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
							 		<input type='button' name='excluirEstoque' value='Excluir' onclick=\"executarAcao('excluirEstoque&codigo={$estoque->getCodigoVestuario()}')\" />
							 		<input type='button' name='imprimirEtiqueta' value='Imprimir Etiqueta' style='width: 130px;' onclick=\"gerarEtiqueta('{$estoque->getCodigoVestuario()}')\" />"
								 ."</td>"
								 ."</tr>";
					    }
			    	?>
			    	</tbody>
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
 