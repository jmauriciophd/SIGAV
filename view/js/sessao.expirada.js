/** Descrição: Arquivo de script das funções javascripts usadas nos formularios
 * 	Autor da Criação: Rafael Dias
 *  Data de Criação: 31/08/2012
 */

var minutos = 30;
var segundos = 0;
var pararChamada = false;

if(window.tempo_max_sessao != undefined){
	minutos = tempo_max_sessao;
}

function abrirPag(valor){
	var xmlRequest = getXmlHttpRequest();
	var url = valor;
	
	xmlRequest.open("POST", url, true);
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
				// Pega o conteúdo - HTML - da página requisitada e coloca dentro da div 'divCorpoPrincipal'
				$("#divCorpoPrincipal").show().html(xmlRequest.responseText);
				
				resetarVar();
			}
		}
	};
	
	xmlRequest.send(null);
}

function apresentaHoras(){
	if(minutos <= 0 && segundos <= 0){
		document.getElementById("horas").innerHTML = "Sessão expirada.";
		document.getElementById("horas").style.color = "red";
		pararChamada = true;
	} else{
		var txtM = "";
		var txtS = "min:";

		if(segundos == 0){
			minutos--;
			segundos = 59;
		}
		
		if(minutos < 10) 
			txtM = "0";	
		if(segundos < 10)
			txtS = "min:0";
		
		var horas = txtM + minutos + txtS + segundos-- + "seg";
		document.getElementById("horas").innerHTML = "<strong>"+horas+"</strong>";
		document.getElementById("horas").style.color = "#045B90";
	}
}

function resetarVar(){
	if(window.tempo_max_sessao != undefined){
		minutos = tempo_max_sessao;
	} else{
		minutos = 30;
	}
	segundos = 0;
	pararChamada = false;
}