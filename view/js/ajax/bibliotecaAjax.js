/** Fun��es para trabalhar com Ajax
 * @author Rafael Dias
 * Data Criacao: 19/10/2012
 */
var ajax;
var dadosUsuario;
var dadosAtuais; //Array que guarda os dados atuais da linha antes de edit�-la
var linhaEmEdicao = null; //Guarda o ID da linha a ser editada, inclu�da ou exclu�da
var linhasNovas = 0; //Vari�vel auxiliar

//----- Obt�m o objeto ajax -----
function getXmlHttpRequest() {
	var xmlHttpRequest;
	try {
		xmlHttpRequest = new XMLHttpRequest(); // Objeto usado no Mozila, Safari...
	} catch(ee) {
		try {
			xmlHttpRequest = new ActiveXObject("Msxml2.XMLHTTP"); // Objeto usado pelo Internet Explorer
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

// ----- Faz a requisi��o http -----
function requisicaoHTTP(tipo,url,assinc,funcaoResposta){
	ajax = getXmlHttpRequest();
	//ajax � a vari�vel que vai armanezar o objeto que ser� utilizado baseado no navegador usado pelo usu�rio
	if (ajax){
		iniciaRequisicao(tipo,url+"&nome_arquivo=ManterCategoriaVestuario.php",assinc,funcaoResposta); // Iniciou com sucesso
	}else{
		alert("Seu navegador n�o possui suporte a essa aplica��o"); // Mensagem que ser� exibida caso n�o seja poss�vel iniciar a requisi��o
	}
}

// ----- Inicia o objeto criado e envia os dados (se existirem) -----
function iniciaRequisicao(tipo, url, bool, funcaoResposta){
	ajax.onreadystatechange = funcaoResposta; //Atribui ao objeto a resposta da fun��o trataResposta
	ajax.open(tipo, url, bool); //Informa os par�metros do objeto: tipo de envio, url e se a comunica��o ser� ass�ncrona ou n�o
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");//Recupera as informa��es do cabe�alho
	ajax.send(dadosUsuario);// Envia os dados processados para o navegador
}

// ----- Inicia requisi��o com envio de dados -----
function enviaDados(url, trataResposta){
	criaQueryString(); //Chama a fun��o que transformar� os dados enviados em uma string
	requisicaoHTTP("POST", url, true, trataResposta); //Chama a fun��o que far� a requisi��o de dados ao servidor
}

// ----- Cria a string a ser enviada, formato campo1=valor&campo2=valor2... -----
function criaQueryString(){
	dadosUsuario = "";
	var frm = document.forms[0]; //Identifica o formul�rio
	var numElementos = frm.elements.length;// Informa o n�mero de elementos
	for(var i = 0; i < numElementos; i++){//Monta a querystring
		if(i < numElementos-1){ //Se i for menor que o n�mero de elementos (menos 1)
			dadosUsuario += frm.elements[i].name+"="+encodeURIComponent(frm.elements[i].value)+"&"; //recupera os valores que compor�o a url se houver mais elementos a serem inclu�dos;
		}
		else{
			dadosUsuario += frm.elements[i].name+"="+encodeURIComponent(frm.elements[i].value); //recupera os valores que compor�o a url se houver mais elementos a serem inclu�dos;
		}
	}
}

/*
requisicaoHTTP = tenta  instanciar o objeto XMLHttpRequest e, se conseguir, chama a fun��o que far� a requisi��o, passando a ela os dados fornecidos pelo usu�rio.

iniciaRequisi��o = recebe os dados da fun��o requisi��oHTTP e processa a requisi��o, al�m de definir a fun��o que ir� tratar a resposta do servidor.

enviaDados = faz uma requisi��o definindo antes os dados a serem enviados, que, no caso, s�o obtidos de um formul�rio HTML. Caso n�o haja dados a seresm enviados, podemos chamar diretamente a fun��o requisicaoHTTP.

criaQueryString = coloca os dados do firmul�rio no formato de uma QueryString, para que o servidor possa identificar os pares nome/valor.

trataResposta = verifica se a requisi��o foi conlu�da e inicia o tratamento dos dados. H� diferen�a desta fun��o para a fun��o trataDados(), que voc� dever� criar em seu programa para realizar o tratamento desejado sobre os dados retornados pelo servidor.

Poss�veis valores do readyState
0(N�o Iniciado): O Objeto foi criado mas o m�todo open() n�o foi chamado ainda. 
1(Carregando): O m�todo open() foi chamado mas a requisi��o n�o foi enviada ainda. 
2(Carregado): A requisi��o foi enviada. 
3(Incompleto): Uma parte da resposta do servidor foi recebida. 
4(Completo): Todos as informa��es foram recebidas e a conex�o foi fechada com sucesso. 
*/