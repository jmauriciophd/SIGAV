        <?php
        require_once dirname(__FILE__) . "/../../../libloader.php";
        $listaArquivosCss = array("form.css");
		Util::includeArquivosCss($listaArquivosCss);
	
		$listaArquivosJs = array("jquery/jquery-1.8.1.min.js",
								"jquery/jquery.maskedinput-1.3.min.js", 
								"jquery/jquery.validacao.js",
								"jquery/jquery.printElement.js",
								"ajax/ajax.js", "mascaras.js", "funcoes.js", "validacao.campos.js"
						 );
	
		Util::includeArquivosJs($listaArquivosJs);
		
        ?> 
        <script type="text/javascript">
			var url = "../relatorios/RelatorioForm.php";
		
			$(function(){

				desabilitarBotao("gerar_relatorio");
				desabilitarBotao("imprimir");
				
				$("#tipo_relatorio").change(function() {
					$("#visualizarRelatorio").hide();
				    if($("#tipo_relatorio").val() != ""){
				    	mostrarFiltro($("#tipo_relatorio").val());
				    	habilitarBotao("gerar_relatorio");
				    	habilitarBotao("imprimir");
				    } else {
				    	$("#filtroRelatorio").hide();
				    	desabilitarBotao("gerar_relatorio");
				    	desabilitarBotao("imprimir");
				    }
				});

				$("#gerar_relatorio").click(function() {
					gerarRelatorio($("#tipo_relatorio").val());
				});

				$("#imprimir").click(function() {
						printDiv("visualizarRelatorio");
				});
			});

			function mostrarFiltro(filtro){
				//alert(filtro);
				$("#filtroRelatorio").hide();
				$.get("../relatorios/FiltroRelatorio"+filtro+".php", function(resultado){
					//alert(resultado);
					if(resultado != null && resultado != "")
						$("#filtroRelatorio").show().html(resultado);
					else 
						$("#filtroRelatorio").hide();
			    });
			}

			function gerarRelatorio(relatorio){
				//esconderMsg();
				var url = "../relatorios/VisualizacaoRelatorio"+relatorio+".php";
				var dados = getAllFormFieldsAsQueryString();
			    //alert(dados);
			    $("#visualizarRelatorio").show().load(url, dados);	
			}

			function printDiv(div){
				var cabecalho = $('#cabecalho').html();
				var conteudo = $('#'+div).html();
				var pagina = cabecalho + conteudo;
				var printPage = $('#'+div).html(pagina);
				printPage.printElement().html(conteudo);
			}

			function habilitarBotao(botao){
				$('#'+botao).removeAttr('disabled');
		    	$('#'+botao).attr('class', 'botao');
			}

			function desabilitarBotao(botao){
				$('#'+botao).attr('disabled', 'disabled');
				$('#'+botao).attr('class', 'botaoDesabilitado');
			}
		</script>
        <!-- Header --> 
        <div id="form" style="width: 1268px; left:1%; position:absolute; top:50px;">
            <div class="top-left"></div>
            <div class="top-right"><div id="titulo_form"> GERAR RELÁTORIO </div></div>
            <div class="inside">
                <form method="post" target="_self" action="../../../controller/RelatorioController.class.php">
                    <table id="tabela" class="tabela" style="width:100%" cellpadding="1" cellspacing="4">
                        <tr>
                            <td colspan="4" align="center"> 
                                <div id="msgCampoObrigatorio">Preencha os campos obrigatórios!</div>
                                <?php Util::exibirMsg("o", "Relatório"); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" align="left" class="cabecalho2"><strong title="Filtro do Relatório">Filtro do Relatório</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <label for="tipo_relatorio" title="Perfil de Relatorio">Gerar Relatório de:</label> &nbsp;
                                <select id='tipo_relatorio' name='tipo_relatorio' style="width: 240px;" title="Selecione o perfil do relatório">
                                    <option value="" >Selecione uma opção</option>
                                    <option value="Aluguel" >Aluguel de Vestuários</option>
                                    <option value="Vestuario" >Vestuários</option>
                                    <option value="Funcionario" >Funcionários</option>
                                    <option value="AcessoSistema" >Acesso ao Sistema</option>
                                    <option value="RegistrosEventos" >Registros de Eventos</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="2"><div id="filtroRelatorio"></div></td>
                        </tr>
                        <tr>
                            <td colspan="4">	
                                <input type="button" name="gerar_relatorio" id="gerar_relatorio" class="botao" style="width: 120px;" title="Gerar Relatório" value="Gerar Relatório" /> 
                                <input type="button" name="imprimir" id="imprimir" title="Imprimir" value="Imprimir" <?php PermissaoController::desabilitarBotao("RELATÓRIOS", "imprimir"); ?>/>
                                <input type="button" class="botao" name="cancelar" id="cancelar" title="Cancelar" value="Cancelar" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                            <div id="imprimiPagina"></div>
                            <div id="cabecalho" style="display: none; font-size: 12px;">
                            	<div style="float: left;"><img src='../../img/logo-rel2.jpg' align="left" width="80px" height="110px"/></div>
	                            <div style="float: left;text-align: center;">
	                            <h1 style="border-bottom: 1px solid blue;">JOVEM MARIA NOIVAS E NOIVOS</h1>
								<strong>Jovem Maria Vestidos de Noivas Ltda - ME</strong> <br/>
	                            CNPJ: 72.580.848/0001-48 CF/DF: 07.346.040/001-61 <br/>
	                            Confecção, Aluguel de Vestidos de Noivas e Ternos, Damas, 1ª Eucaristia, Debutantes e Festas. <br/>
	                            CNB 05 - Lote 04 - Loja 02 - Fone: 3352-2003 - Taguatinga - DF (Rua Riachuelo)
	                         	</div>
                            </div>
                            <div id="visualizarRelatorio"></div>
                            </td>
                        </tr>
                    </table>
                </form>
                <!-- Trailler -->
            </div>
            <div class="bottom-left"></div>
            <div class="bottom-right" style="padding-left:35px;"></div>
        </div>
