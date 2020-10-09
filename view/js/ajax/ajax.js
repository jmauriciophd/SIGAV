/** Fun��es para trabalhar com Ajax
 * @author Rafael Dias
 * Data Criacao: 19/10/2012
 */
// Esta fun��o instancia o objeto XMLHttpRequest
function getXmlHttpRequest() {
	var xmlHttpRequest;
	try {
		xmlHttpRequest = new XMLHttpRequest();
	} catch(ee) {
		try {
			xmlHttpRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e) {
			try {
				xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch(E) {
				xmlHttpRequest = false;
			}
		}
	}
	return xmlHttpRequest;
}

function abrirPag(url){
	var xmlRequest = getXmlHttpRequest();
	xmlRequest.open("GET", url, false);
	xmlRequest.setRequestHeader("encoding", "ISO-8859-1");
	xmlRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=iso-8859-1");
	xmlRequest.onreadystatechange = function() {
		if (xmlRequest.readyState == 1) {
			//esconde a div 'divCorpoPrincipal' e mostra a div 'carrengando'
			$("#divCorpoPrincipal").hide();
			$("#carregando").show();
		}
		if (xmlRequest.readyState == 4) {
			if (xmlRequest.status == 200) {
				//esconde a div carrengando
				$("#carregando").hide();
				// Pega o conte�do - HTML - da p�gina requisitada e coloca dentro da div 'divCorpoPrincipal'
				$("#divCorpoPrincipal").show().html(xmlRequest.responseText);
				resetarVar();
			}
		}
	};
	
	xmlRequest.send(null);
}

