/** Descrição: Arquivo de script das funções javascripts usadas nos formularios
 * 	Autor da Criação: Rafael Dias
 *  Data de Criação: 31/08/2012
 */

var ultimaPaginaAcessada;

$(function(){
	$('#opacidade').hide();
	
	if($("#criar_usuarioN").is(":checked") == true){
		ocultarCadastroUsuario();
	} else if($("#criar_usuarioS").is(":checked") == true){
		exibirCadastroUsuario();
	}
	
	//transforma a letra digitada em maiscula nos campos
	$(".caixaAlta").keyup(function(){
        this.value = this.value.toUpperCase();
    });

	//cancela a operação voltando para pagina anterior
	$("#cancelar").click( function (){
		cancelar();
	});

	$("#criar_usuarioS").click(function () {
		exibirCadastroUsuario();
    });
	
	$("#criar_usuarioN").click(function () {
		ocultarCadastroUsuario();
    });
	
	$("#selecionarTodos").click(function(){
		check = this;
		jQuery.each($("input:checkbox"), function(){
			this.checked = (check.checked) ? true : false;
		});
	});
	
});

function cancelar(){
	abrirPag("../inicio/pagina_inicial.php");
}

function mostrarEsconderElemento(id) {
	if (document.getElementById(id).style.display == 'none') {
		document.getElementById(id).style.display = '';
	} else {
		document.getElementById(id).style.display = 'none';
	}
}

function buscarPermissaoAcesso(){
	var perfil_permissao = $("#perfil_permissao").val();
	
	if(perfil_permissao != ""){
		// Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
		$.post("../../../controller/PermissaoController.class.php", {operacao: "exibirDadosPermissao", id_perfil: ""+perfil_permissao+""}, function(data) {
			var result = data.split(",");	
			 for(var i = 0; i<result; i++){
				   alert(result);
				    $("#status").slideDown();
					$("#acesso").html(result[0]);
					$("#aplicacao").html(result[1]);
					$("#consulta1").html(result[2]);
					$("#cadastra1").html(result[3]);
					$("#altera1").html(result[4]);
					$("#consulta1").html(result[5]);
					$("#exclui1").html(result[6]);
					$("#imprimi1").html(result[7]);
			}
		  });
	} else{
		$("#status").slideUp();
	}
}

function verificarCpf(entidade){
	var cpf = $("#cpf").mask();
	if(cpf != ""){
		jQuery.ajax({
	        url: '../../../controller/'+entidade+'Controller.class.php?operacao=verificarCpf&cpf='+cpf,
	        async: false,
	        success: function(data) {
	           if(data != 0 && data != ""){
	        	   abrirPag(data);
	           }
		 }});
	}
}

function verificarCnpj(entidade){
	var cnpj = $("#cnpj").mask();
	jQuery.ajax({
        url: '../../../controller/'+entidade+'Controller.class.php?operacao=verificarCnpj&cnpj='+cnpj,
        async: false,
        success: function(data) {
           if(data != 0 && data != ""){
        	   abrirPag(data);
           }
	 }});
}

function verificarNome(entidade){
	var nome = trim($("#nome").val());
	jQuery.ajax({
        url: '../../../controller/'+entidade+'Controller.class.php?operacao=verificarNome&nome='+nome,
        async: false,
        success: function(data) {
           if(data != 0 && data != ""){
        	   abrirPag(data);
           }
        }
	});
}

function executarAcao(acao, redirecionar){
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
	    	//alert(encodeURIComponent(data));
		    if(data != null && data != ""){
		    	if(redirecionar){
		    		abrirPag(data); 
		    	} else {
		    		exibirMsg(data);
		    	}
            } else {
            	$("#carregando").hide();
        	    alert("Ocorreu um erro durante a requisição enviada ao servidor! Por favor, entre em contato com o Administrador do Sistema."); 
        	    return false;
            }
	    }
	});
}

function exibirMsg(msg){
		$("#msg").show().html(msg);
}

function desabilitarCntrlV() {
	  // current pressed key
	  var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();

	  if (event.ctrlKey && (pressedKey == "c" || 
	                        pressedKey == "v")) {
	    // disable key press porcessing
	    event.returnValue = false;
	 }
}

function abrirPopUpManual(url) {
	var janela = window.open(url,null,"height=1000,width=2000,status=no,toolbar=no,menubar=no,location=no");
	janela.opener = window;
	janela.focus();		
}

function loadPopupModal(div){
	popupStatus = 0;
	document.getElementById(div).style.marginTop="450px";
	document.getElementById(div).style.marginLeft="-70px";
	//loads popup only if it is disabled
	if(popupStatus==0){
		jQuery(function($){
			$("#backgroundPopup").css({
				"opacity": "0.7"
			});		
			$("#backgroundPopup").fadeIn("slow");
			$("#" + div).fadeIn("slow");
			popupStatus = 1;
		});	
	}	
}

//----- Cria a string a ser enviada, formato campo1=valor&campo2=valor2... -----
function getDadosForm(){
	var dados = "";
	var frm = document.forms[0]; //Identifica o formulário
	var numElementos = frm.elements.length;// Informa o número de elementos
	for(var i = 0; i < numElementos; i++){//Monta a querystring
		if(i < numElementos-1){ //Se i for menor que o número de elementos (menos 1) encodeURIComponent()
			dados += frm.elements[i].name+"="+frm.elements[i].value+"&"; //recupera os valores que comporão a url se houver mais elementos a serem incluídos;
		}
		else{
			dados += frm.elements[i].name+"="+frm.elements[i].value; //recupera os valores que comporao a url se houver mais elementos a serem incluídos;
		}
	}
	return dados;
}

/**
* Obtem os valores de todos os campos de todos os formulariospara utiliza-los como parametros de requisicao.
*/
function getAllFormFieldsAsQueryString() {
	var params = '';
	
	var forms = document.forms;
	
	for (var k=0; k < forms.length; k++) {
		for (var i=0; i < forms[k].elements.length; i++) {
			var element = forms[k].elements[i];
					
			if (isFormElement(element)) {				
				// nao envia o parametro referente ao formulario a ser validado
				// para enviar o parametro 'validationKey' referente ao 
				if (element.name == 'validationKey') {
					continue;
				}
				
				
				if (element.type == 'select-multiple' || element.type == 'select-one') {
					var options = element.options;
					for (var j = 0;j < options.length;j++) {
						if (options[j].selected) {
							params = params + element.name + '=' + options[j].value + '&';	
						}
					}
				} else {				
					if ((element.type == 'radio' || element.type == 'checkbox') && element.checked) {
						params = params + element.name + '=' + element.value + '&';	
					} else if (element.tagName == 'textarea' || element.tagName == 'TEXTAREA') {
						params = params + element.name + '=' + encodeURIComponent(element.value) + '&';
					} else if (element.type != 'radio' && element.type != 'checkbox' && element.tagName != 'textarea') {
						var elValue = element.value;
						
						if (elValue.indexOf('&') != -1) {
							elValue = elValue.replace(/&/g,'%26');
						}
						
						params = params + element.name + '=' + elValue + '&';	
					}
				}
			}
		}
	}
	return params;
}

/**
* Verifica se o elemento informado e um elemento de formulario (text, select, hidden, etc).
*/
function isFormElement(element) {
	if (!element) {
		alert('Elemento nao informado.');
		return false;
	}
	
	if (element.type && (element.type == 'text' 
		|| element.type == 'textarea' 
		|| element.type == 'select'
		|| element.type == 'select-one'
		|| element.type == 'select-multiple' 
		|| element.type == 'submit' 
		|| element.type == 'radio'
		|| element.type == 'hidden'
		|| element.type == 'checkbox')) {
		
		return true;
	}
	
	return false;
}

function exibirCadastroUsuario(){
	alert("exibir");
	if($("#senha").val() == "undefined"){
		$("#senha").val("");
	}
	if($("#confirme_senha").val() == "undefined"){
		$("#confirme_senha").val("");
	}
	if($("#perfil").val() == "undefined"){
		$("#perfil").val("");
	}
	$("#cadUsuario").show();
}

function ocultarCadastroUsuario(){
	alert("ocultar");
	$("#cadUsuario").hide();
	$("#perfil").className = "requerido";
	$("#senha").className = "requerido";
	$("#confirme_senha").className = "requerido";
	$("#senha").val("undefined");
	$("#confirme_senha").val("undefined");
	$("#perfil").val("undefined");
}

function trim(str){
	return str.replace(/^\s+|\s+$/g,"");
}