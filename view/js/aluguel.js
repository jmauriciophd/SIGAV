/** Descrição: Arquivo de script das funções javascripts usadas no aluguel de vestuario
 * 	Autor da Criação: Rafael Dias
 *  Data de Criação: 02/11/2012
 */
var cont = 0;
var listaVestuarios = new Array();
var valorTotal = 0.00;
var url = "../aluguel/AluguelFormCadastrar.php";
var qtdeVestuarios = 0;
var opcoesRemovidas = false;

$(document).ready(function(){
	$("#qtdVest").val(cont);
	$('#data_entrega').datepicker({minDate:'+0Y'}).change( function (){
		$('#data_nascimento').focus();
	});
	$('#data_prevista_devolucao').datepicker({minDate:'+0Y'}).change( function (){
		$('#data_nascimento').focus();
	});
	$('#data_previa').datepicker({minDate:'+0Y'});
	$('#data_prova').datepicker({minDate:'+0Y'});

	$('#data_entrega').validaData();
	$('#data_prevista_devolucao').validaData();
	$('#data_previa').validaData();
	$('#data_prova').validaData();
	
	$("#cadastrar").click(function(event) {
	    event.preventDefault();
	    if(validarCampos()){
	    	url = trim(url);
	    	alugar("cadastrar&url=../aluguel/AluguelFormCadastrar.php", false); 
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
		event.preventDefault();
	    if(confirm("Deseja excluir o registro?")){
	   	 	executarAcao("excluir&url="+url, true);
	    }  else {
			return false;
		}
	});
	
	$("#novoCadastro").click(function(event) {
		event.preventDefault();
	    abrirPag(url, true);
	});
	
	$("#cpf_cliente").change(function(){
		var cpf = $("#cpf_cliente").mask();
		
		if(!validaCpf(cpf) && cpf.length >= 11){
			//alert("CPF inválido! Preencha corretamente o campo CPF.");
			this.className = "dataFieldError";
			$('#msgCampoObrigatorio').show().text("Informe um CPF válido!");
			$("#status").slideUp();
			$("#cpf_cliente").focus();
			return false;
		} else{
			this.className = "";
			$('#msgCampoObrigatorio').hide();
			buscaCliente();
			return true;
		}
	});
	
    $("#addVestuario").click(function(){
    	var codigo_vestuario = $("#codigo_vestuario").val();
    	$.post("../../../controller/VestuarioController.class.php", {operacao: "addVestuario", id: ""+codigo_vestuario}, function(data) {
    		if(data != ""){
    			var dados = data.split(",");
    			if(!vestuarioDuplicado(dados[0])){
    				  cont++;
    				  msgListaVazia();
    			  	  var tbl = document.getElementById("tabelaAddVestuario");
    			  	  var codigo = "<input type='hidden' name='codigo[]' value='"+dados[0]+"'/>";
    			  	  var btnRemover = "<a href='#' onClick='removerVestuario("+qtdeVestuarios+", \""+dados[0]+"\")' title='Remover Vestuario'><img src='../../img/deletar.gif' border='0' /></a>";
    			  	  
    			  	  listaVestuarios[qtdeVestuarios] = dados[0];
    			  	 
    			      var novaLinha = tbl.insertRow(-1);
    			      novaLinha.setAttribute("id","vestuario"+qtdeVestuarios);
    			      
    			      var novaCelula;
    			     
    			      dados[0] = codigo + dados[0];
    			      calcularValorTotal("somar", dados[6]);
    			      dados[6] = "<input type='hidden' name='valor' id='valor" + qtdeVestuarios + "' value='"+ dados[6] +"' />" + dados[6];
    			      dados[7] = btnRemover;
    			      
    			      for(var i = 0; i < 8; i++){
	    			      novaCelula = novaLinha.insertCell(i);
	    			      novaCelula.innerHTML = dados[i];
    			      }
    			      
    			      $("#qtdVest").val(cont);
    			      $("#codigo_vestuario").val("");
    			      qtdeVestuarios++;
    			      calculaValorFaltaPagar();
    			} else{
    				$("#codigo_vestuario").focus();
    				alert("O vestuário já foi adicionado a lista.");
    			}
    		} else {
    			$("#codigo_vestuario").focus();
    			alert("Código inválido.");
    		}
    	});		    
	});

    $("#forma_pagamento").change(function(){
    	if($("#forma_pagamento").val() == "C" || $("#forma_pagamento").val() == "CC"){
    		$("#cmp_parcelas").show();
    		$("#qtd_parcelas").show();
    		if($("#forma_pagamento").val() == "C" ){
    			$("#qtd_parcelas option[value='7']").remove();
    			$("#qtd_parcelas option[value='8']").remove(); 
    			$("#qtd_parcelas option[value='9']").remove();
    			$("#qtd_parcelas option[value='10']").remove(); 
    			$("#qtd_parcelas option[value='11']").remove();
    			$("#qtd_parcelas option[value='12']").remove();
    			opcoesRemovidas = true;
    		} else if(opcoesRemovidas){
    			$("#qtd_parcelas").append('<option value="7">7</option>');
    			$("#qtd_parcelas").append('<option value="8">8</option>');
    			$("#qtd_parcelas").append('<option value="9">9</option>');
    			$("#qtd_parcelas").append('<option value="10">10</option>');
    			$("#qtd_parcelas").append('<option value="11">11</option>');
    			$("#qtd_parcelas").append('<option value="12">12</option>');
    			opcoesRemovidas = false;
    		}
    	} else {
    		$("#cmp_parcelas").hide();
    		$("#qtd_parcelas").hide();
    	}
	});
    
    $("#valor_entrada").priceFormat({
        prefix: '',
        clearPrefix: true,
        centsSeparator: '.',
        thousandsSeparator: '.'
	});
	
    $("#valor_parcela").priceFormat({
        prefix: '',
        clearPrefix: true,
        centsSeparator: '.',
        thousandsSeparator: '.'
	});
    
    $("#valor_entrada").blur(function(){
    	calculaValorFaltaPagar();
    });
});

function vestuarioDuplicado(elemento){
	tamLista = listaVestuarios.length;
	for(var i = 0; i < tamLista; i++){
		if(listaVestuarios[i] == elemento.toString()){
			return true;
		}
	}
	return false;
}

function removerVestuario(id, elemento) {
	calcularValorTotal("subtrair", $("#valor"+id).val());
	$("#vestuario"+id).remove();
	cont--;
	$("#qtdVest").val(cont);
	msgListaVazia();
	listaVestuarios[id] = null;
	listaVestuarios = ordenarArray(listaVestuarios);
}

function msgListaVazia() {
	if(cont == 0){
		var tbl = document.getElementById("tabelaAddVestuario");
		var novaLinha = tbl.insertRow(-1);
		novaLinha.setAttribute("id","msgListaVestuario");
		novaCelula = novaLinha.insertCell(0);
		novaCelula.setAttribute("colspan","8");
		novaCelula.setAttribute("align", "center");
		novaCelula.innerHTML = "<div id='msgAviso'>Nenhum vestu&aacute;rio adicionado a lista de aluguel</div>";
	} else {
		$("#msgListaVestuario").remove();
	}
}

//Função que ordena um array, de acordo com o tamanho dos seus elementos. Ordenação Ascendente.
function ordenarArray(array){
	var temp1;
	var temp2;
	if(array != null){
		for(var i=0; i<array.length-1; i++){
			temp1 = array[i];
			for(var j=i+1; j<array.length; j++){
				temp2 = array[j];
				if(temp2 != null && temp2.length < temp1.length){				
					array[i] = temp2;
					array[j] = temp1;
					temp1= temp2;
					temp2= array[j]; 
				}
			}
		}	
	}
	return array;
}

function calcularValorTotal(operacao, valor){
	if(operacao == "somar"){
		valorTotal += parseFloat(valor);
	} else if(operacao == "subtrair"){
		if(valor > valorTotal){
			valorTotal = parseFloat(valor) - valorTotal;
		} else {
			valorTotal -= parseFloat(valor);
		}
	}
	
	$("#valor_total").html(" R$ " + valorTotal.toFixed(2));
	$("#valor_total_aluguel").val(valorTotal);
	calculaValorFaltaPagar();
}

function calculaValorFaltaPagar(){
	if($("#valor_total_aluguel").val() != null && $("#valor_total_aluguel").val() != ""){
		if($("#valor_entrada").val() != null && $("#valor_entrada").val() != ""){
			faltaPagar = parseFloat($("#valor_total_aluguel").val()) - parseFloat($("#valor_entrada").val());
		} else {
			faltaPagar = parseFloat($("#valor_total_aluguel").val());
		}
		$("#falta_pagar").val(parseFloat(faltaPagar).toFixed(2));
	} else {
		$("#falta_pagar").val("0.00");
	}
}

function buscaCliente(){
	var cpf = $("#cpf_cliente").mask();
	
	if(cpf.length >= 11){
		// Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
		$.post("../../../controller/ClienteController.class.php", {operacao: "exibirDadosCliente", cpf: ""+cpf+""}, function(data) {
			var result = data.split(",");	
			if(data.length > 12){
				$("#status").slideDown();
				$("#nome_cliente").html(result[0]);
				$("#rg_cliente").html(result[1]);
				$("#orgao_expedicao_cliente").html(result[2]);
				$("#endereco_cliente").html(result[3]);
				$("#tel_residencial_cliente").html(result[4]);
				$("#email_cliente").html(result[5]);
			} else {
				$("#status").slideUp();
				$("#msgCampoObrigatorio").show().html("Cliente n&atilde;o encontrado.");
			}
		});
	} else{
		$("#status").slideUp();
	}
}

function alugar(acao, redirecionar){
	esconderMsg();
	var action = $("form").attr("action");
	var dados = getAllFormFieldsAsQueryString() + "operacao="+acao;
    //alert(dados);
    
	$.ajax({
	    //pegando a url apartir da action do form
	    url: action,
	    type: "POST",
        data: dados,
        async: true,
        contentType: "application/x-www-form-urlencoded; charset=iso-8859-1",
	    beforeSend: function(xhr){
	    	
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
			
			$('#opacidade').show();
	    	$("#carregando").show();
	    	
			$('#opacidade').css({'width':maskWidth,'height':maskHeight});
			$("#opacidade").css({"opacity": "0.7"});		
			$('#opacidade').fadeIn("slow");	
			
	    },
	    complete: function(){
	    	$('#opacidade').hide();
	    	$("#carregando").hide();
	    },
	    context: jQuery('#msgCampoObrigatorio'),
	    success: function(data){
	    	//alert(data);
		    if(data != null && data != ""){
		    	if(redirecionar){
		    		abrirPag(data); 
		    	} else {
		    		$("#divCorpoPrincipal").show().html(data);
		    	}
            } else {
            	$("#carregando").hide();
        	    alert("Ocorreu um erro durante a requisição enviada ao servidor! Por favor, entre em contato com o Administrador do Sistema."); 
        	    return false;
            }
	    }
	});
}