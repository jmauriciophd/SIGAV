/**
*	Biblioteca de Funcoes JS
*/

function funcionalidadeNaoImplementada() {
	alert('Funcionalidade não implementada.');
	return false;
}

function mostrarEsconderElemento(id) {
	if (document.getElementById(id).style.display == 'none') {
		document.getElementById(id).style.display = '';
	} else {
		document.getElementById(id).style.display = 'none';
	}
}

/**
*   Funcoes de Mascara
*/
function initDateFieldMask(elm) {
	jQuery(function($){
		$('#' + elm.id).mask('99/99/9999');			
	});
}

function initOABFieldMask(elm){
	jQuery(function($){
		$('#' + elm.id).mask('********');			
	});
}

function initCPFFieldMask(elm) {
	jQuery(function($){
		$('#' + elm.id).mask('999.999.999-99');			
	});
}

function initCNPJFieldMask(elm) {
	jQuery(function($){
		$('#' + elm.id).mask('99.999.999/9999-99');			
	});
}

function initCurrencyFieldMask(elm) {
	jQuery(function($){
		$('#' + elm.id).mask('9.999.999,99');			
	});
}

function removeMask(elm) {
	jQuery(function($){
		$('#' + elm.id).unmask();			
	});
}

/**
* Funcoes para tratamento de Formularios e submissoes 
*/

function submeter(action, metodo) {
	document.getElementById('btnSubmeter').name = 'action:' + action +  '!' + metodo;
	document.forms[0].submit(); 
}

function submeterFormAtual(metodo) {
	document.getElementById('btnSubmeter').name = 'action:' + document.forms[0].name +  '!' + metodo;
	document.forms[0].submit(); 
}

/**
* Submete uma requisicao com AJAX atualizando o conteudo da DIV informada.
*/
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

 /**
  * Obtem os valores de todos os campos de todos os formulariospara utiliza-los como parametros de requisicao.
  */
  function getAllFormFieldsAsQueryString(paramsArray) {
  	var params = '[{';

 	params = params + '"teste":"1"';
 	
  	if (paramsArray) {
 		for (key in paramsArray) {
 			params = params + ',"' + key + '":"' + paramsArray[key] + '"';
 		}
  		
  	}
  	
  	var forms = document.forms;
  	var elementName;
  	var elementValue;

  	for (k=0; k < forms.length; k++) {
  		for (i=0; i < forms[k].elements.length; i++) {
  			var element = forms[k].elements[i];
  					
  			if (isFormElement(element)) {				
  				// nao envia o parametro referente ao formulario a ser validado
  				// para enviar o parametro 'validationKey' referente ao 
  				if (element.name == 'validationKey') {
  					continue;
  				}
  				
  				elementName =  element.name;
  				elementValue = replaceAll(element.value, "\"", "'");
  				  				
  				if (element.type == 'select-multiple' || element.type == 'select-one') {
  					var options = element.options;
  					for (j = 0;j < options.length;j++) {
  						if (options[j].selected) {
  							params = params + ',"' + element.name + '":' + '"' + options[j].value + '"';	
  						}
  					}
  				} else {				
  					if ((element.type == 'radio' || element.type == 'checkbox') && element.checked) {
  						params = params + ',"' + element.name + '":' + '"' + elementValue + '"';	
  					} else if (element.type != 'radio' && element.type != 'checkbox' && element.tagName != 'textarea') {
  						var elValue = elementValue;
  						
  						if (elValue.indexOf('&') != -1) {
  							elValue = elValue.replace(/&/g,'%26');
  						}
  						
  						if (elValue.indexOf('\n') != -1)
  							continue;
  						
  						params = params + ',"' + element.name + '":' + '"' + elValue + '"';	
  					}
  				}
  			}
  		}
  	}
  	params += '}]';

  	return eval(params)[0];
  }

function replaceAll(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
 		string = string.replace(token, newtoken);
	}
	return string;
}


 function verificarSelecao(check) {
 	if (!check.checked) {
 		for (i = 0;i < document.forms[0].elements.length; i++) {
 			var elm = document.forms[0].elements[i];
 			if ((elm.name == check.name) && (check.value == elm.value) && elm.type && elm.type.toLowerCase() == 'hidden') {
 				elm.parentNode.removeChild(elm);
 			}
 		}
 	}
 }

 function selecionarTudo(checkboxes){
 	if (!checkboxes.length) {
 		checkboxes.checked = true;
 	} else {
 		for (i = 0; i < checkboxes.length; i++){
 			checkboxes[i].checked = true;
 			verificarSelecao(checkboxes[i]);
 		}
 	}
 }

 function selecionarNenhum(checkboxes){
 	if (!checkboxes.length) {
 		checkboxes.checked = false;
 	} else {
 		for(i = 0; i < checkboxes.length; i++){
 			var check = checkboxes[i];
 			
 			for (j = 0;j < document.forms[0].elements.length; j++) {
 				var elm = document.forms[0].elements[j];
 				if ((elm.name == check.name) && (check.value == elm.value) && elm.type && elm.type.toLowerCase() == 'hidden') {
 					elm.parentNode.removeChild(elm);
 				}
 			}		
 			checkboxes[i].checked = false;
 		}
 	}
 }
 
 
/** function sendDivRequest(action, method, div, params) {
	var acao = ParametrosContexto.getContexto() + action + '!' + method + '.action';
	
	dojo.io.bind({
		url: acao,
		method: "POST",
		content: getAllFormFieldsAsQueryString(params),		
		load: function(type, data, evt) {
			
			if (dojo.byId('divMensagemErroFormPrincipal'+ action)) 
				dojo.byId('divMensagemErroFormPrincipal'+ action).style.display = 'none';
			if (dojo.byId('divMensagemFormPrincipal'+ action))
				dojo.byId('divMensagemFormPrincipal'+ action).style.display = 'none';
			if (dojo.byId('divMensagemSucessoFormPrincipal'+ action))
				dojo.byId('divMensagemSucessoFormPrincipal'+ action).style.display = 'none';
			
			var divDisplay = dojo.byId(div);
			
			if (data.indexOf('tela_login') != -1) {
				window.location = ParametrosContexto.getContexto();
				return;
			}

			divDisplay.innerHTML=data;
		    		    
		    if (dojo.byId('divMensagemErroAJAX' + action)) {
		    	dojo.byId('divMensagemErroForm' + action).innerHTML = dojo.byId('divMensagemErroAJAX' + action).innerHTML;
		    	dojo.byId('divMensagemErroFormPrincipal' + action).style.display = '';
		    } else if (dojo.byId('divMensagemAJAX' + action)) {
		    	dojo.byId('divMensagemForm' + action).innerHTML = dojo.byId('divMensagemAJAX' + action).innerHTML;
		    	dojo.byId('divMensagemFormPrincipal' + action).style.display = '';
		    } else if (dojo.byId('divMensagemSucessoAJAX' + action)) {
		    	dojo.byId('divMensagemSucessoFormPrincipal' + action).style.display = '';
		    }
		    
		    },mimeType: "text/html",
		    error: function(type, error, httpObj) {
				alert('Não foi possível enviar a requisição para o servidor.' + error.message);
			}
	});
}	**/