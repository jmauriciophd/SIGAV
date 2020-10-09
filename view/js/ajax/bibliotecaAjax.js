/** Funções para trabalhar com Ajax
 * @author Rafael Dias
 * Data Criacao: 19/10/2012
 */
var ajax;
var dadosUsuario;
var dadosAtuais; //Array que guarda os dados atuais da linha antes de editá-la
var linhaEmEdicao = null; //Guarda o ID da linha a ser editada, incluída ou excluída
var linhasNovas = 0; //Variável auxiliar

//----- Obtém o objeto ajax -----
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

// ----- Faz a requisição http -----
function requisicaoHTTP(tipo,url,assinc,funcaoResposta){
	ajax = getXmlHttpRequest();
	//ajax é a variável que vai armanezar o objeto que será utilizado baseado no navegador usado pelo usuário
	if (ajax){
		iniciaRequisicao(tipo,url+"&nome_arquivo=ManterCategoriaVestuario.php",assinc,funcaoResposta); // Iniciou com sucesso
	}else{
		alert("Seu navegador não possui suporte a essa aplicação"); // Mensagem que será exibida caso não seja possível iniciar a requisição
	}
}

// ----- Inicia o objeto criado e envia os dados (se existirem) -----
function iniciaRequisicao(tipo, url, bool, funcaoResposta){
	ajax.onreadystatechange = funcaoResposta; //Atribui ao objeto a resposta da função trataResposta
	ajax.open(tipo, url, bool); //Informa os parâmetros do objeto: tipo de envio, url e se a comunicação será assíncrona ou não
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");//Recupera as informações do cabeçalho
	ajax.send(dadosUsuario);// Envia os dados processados para o navegador
}

// ----- Inicia requisição com envio de dados -----
function enviaDados(url, trataResposta){
	criaQueryString(); //Chama a função que transformará os dados enviados em uma string
	requisicaoHTTP("POST", url, true, trataResposta); //Chama a função que fará a requisição de dados ao servidor
}

// ----- Cria a string a ser enviada, formato campo1=valor&campo2=valor2... -----
function criaQueryString(){
	dadosUsuario = "";
	var frm = document.forms[0]; //Identifica o formulário
	var numElementos = frm.elements.length;// Informa o número de elementos
	for(var i = 0; i < numElementos; i++){//Monta a querystring
		if(i < numElementos-1){ //Se i for menor que o número de elementos (menos 1)
			dadosUsuario += frm.elements[i].name+"="+encodeURIComponent(frm.elements[i].value)+"&"; //recupera os valores que comporão a url se houver mais elementos a serem incluídos;
		}
		else{
			dadosUsuario += frm.elements[i].name+"="+encodeURIComponent(frm.elements[i].value); //recupera os valores que comporão a url se houver mais elementos a serem incluídos;
		}
	}
}

/*
requisicaoHTTP = tenta  instanciar o objeto XMLHttpRequest e, se conseguir, chama a função que fará a requisição, passando a ela os dados fornecidos pelo usuário.

iniciaRequisição = recebe os dados da função requisiçãoHTTP e processa a requisição, além de definir a função que irá tratar a resposta do servidor.

enviaDados = faz uma requisição definindo antes os dados a serem enviados, que, no caso, são obtidos de um formulário HTML. Caso não haja dados a seresm enviados, podemos chamar diretamente a função requisicaoHTTP.

criaQueryString = coloca os dados do firmulário no formato de uma QueryString, para que o servidor possa identificar os pares nome/valor.

trataResposta = verifica se a requisição foi conluída e inicia o tratamento dos dados. Há diferença desta função para a função trataDados(), que você deverá criar em seu programa para realizar o tratamento desejado sobre os dados retornados pelo servidor.

Possíveis valores do readyState
0(Não Iniciado): O Objeto foi criado mas o método open() não foi chamado ainda. 
1(Carregando): O método open() foi chamado mas a requisição não foi enviada ainda. 
2(Carregado): A requisição foi enviada. 
3(Incompleto): Uma parte da resposta do servidor foi recebida. 
4(Completo): Todos as informações foram recebidas e a conexão foi fechada com sucesso. 
*/