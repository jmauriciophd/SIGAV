/** Fun��es javascript de oper��es do manter categoria
 * @author Rafael Dias
 * Data Criacao: 05/11/2012
 */

//Prepara uma linha para edi��o
function EditarLinha(idLinha, codigoAntigo){
	if(linhaEmEdicao == null){//Se linhaEmEdicao n�o for nulo...
		//Obt�m a linha a ser editada e altera a sua cor
		var linha = document.getElementById(idLinha);//Obt�m o id da linha que ser� editada
		linha.className = 'linhaSelecionada';//Altera a cor da linha que ser� editada
		var celulas = linha.cells;//Aramazena a c�lula que ser� editada
		
		//salva os dados atuais para o caso de cancelamento
		SalvaDados(idLinha);//Chama a fun��o que salv�ra os dados atuais da linha antes de edit�-la
		linhaEmEdicao = idLinha; //Armazena o id da linha que ser� editada
		
		//Cria os campo de texto edit�veis
		//celulas[0].innerHTML = '<input type="hidden" name="cod" value="'+celulas[0].innerHTML+'">';//Armazena o c�digo do produto num campo oculto de formul�rio
		//celulas[0].innerHTML = '<input type="text" name="codigo_categoria" id="codigo_categoria" onblur="return isPreenchido(this);" onkeyup="this.value = this.value.toUpperCase();" style="width:100px" value="'+celulas[0].innerHTML+'">';//Mostrar o campo texto permitindo a edi��o do nome do produto
		celulas[1].innerHTML = '<input type="text" name="categoria" id="categoria" onblur="return isPreenchido(this);" onkeyup="this.value = this.value.toUpperCase();" style="width:100%" value="'+celulas[1].innerHTML+'">';//Mostrar o campo texto permitindo a edi��o do nome do produto
		celulas[2].innerHTML = '<a href="#" onclick="Atualizar(document.forms[0].categoria.value, \''+codigoAntigo+'\');"><img src="../../img/atualizar.gif" alt="Atualizar" /></a>' +
		'  <a href="#" onclick="Cancelar();"><img src="../../img/cancelar.gif" alt="Cancelar" /></a>';
	}
	else {alert("Voc� j� est� digitando um registro.");}
}

//Exclui uma linha da tabela
function ExcluirLinha(idLinha, codigo){
	if(!linhaEmEdicao){
		var linha = document.getElementById(idLinha);//Armazena o id da linha que ser� exclu�da
		linha.className = 'linhaSelecionada';// define a classe de estilos que ser� usada na linha
		if(confirm("Tem certeza que deseja excluir este registro?")){//Pergunta se a linha realmente deve ser exclu�da
			Aviso(1); // Exibe o aviso: Aguarde...
			var url = "../../../controller/CategoriaController.class.php?operacao=excluir&codigo="+codigo;//Url que ser� enviada
			requisicaoHTTP("GET", url, true, trataResposta);//Fun��o que far� a requisi��o
		} else{
			linha.className = 'linha';//Define a classe de estilo que ser� usada se a linha n�o estiver maracada para exclus�o
		}
	} else{
		alert("Voc� est� com um registro aberto. Feche-o antes de prosseguir.");
	}
}

//Cria um novo registro
function NovoRegistro(){
	
	//Se houver linha sendo editada, cancela edi��o
	if(linhaEmEdicao){// Se linhas em edi��o for nulo...
		alert("Voc� est� com um registro aberto. Feche-o antes de prosseguir");
	}else{
		//Insere uma nova linha na tabela
		proxIndice = document.getElementById('tabela').rows.length-1;//Armazena o �ndice a linha que ser� inserida
		var novaLinha = document.getElementById('tabela').insertRow(proxIndice);//Insere uma nova linha na tabela
		novaLinha.className = 'linhaSelecionada';//Define a classe de estilos que ser� usada na n ova linha
	
		//Define o id da nova linha (que ser� usado em caso de edi��o/exclus�o
		novoId = "nova"+linhasNovas;//Armazena o id da linha
		novaLinha.setAttribute('id', novoId);//Define que o nome do id ser� o valor da vari�vel novoId
		linhasNovas++; //Incrementa o valor da vari�vel
		linhaEmEdicao = novoId;// Aramazena o valor da vari�vel novoId
		
		//Insere as c�lulas na linha criada
		var novasCelulas = new Array(3); //Cria um array
		for(var i=0; i<4; i++){
			novasCelulas[i] = novaLinha.insertCell(i); //Preenche o array
		}
		//Cria os campos dos formul�rios
		//novasCelulas[0].innerHTML = '*'; //c�digo do produto
		novasCelulas[0].innerHTML = '<input type="text" name="codigo_categoria" id="codigo_categoria" onblur="isPreenchido(this);" onkeyup="this.value = this.value.toString().toUpperCase();" class="requerido, caixaAlta" style="width:80px">'; //insere o campo nome
		novasCelulas[1].innerHTML = '<input type="text" name="categoria" id="categoria" onblur="isPreenchido(this);" onkeyup="this.value = this.value.toString().toUpperCase();" class="requerido, caixaAlta">'; //insere o campo nome
		novasCelulas[2].innerHTML = '<div style="text-align: center;"><a href="#" onclick="Cadastrar(document.forms[0].codigo_categoria.value, document.forms[0].categoria.value);" title="Cadastrar">Cadastrar</a> &nbsp; <a href="#" onclick="CancelarInclusao();" title="Cancelar">Cancelar</a></div>';
	}
}

//Salva os dados atuais num array
function SalvaDados(idLinha){
	var celulas = document.getElementById(idLinha).cells;//Armazena o id  da c�lula
	dadosAtuais = new Array(celulas.length);//Armazena num array os dados atuais da linha
	for(var i=0; i<celulas.length; i++){
		dadosAtuais[i] = celulas[i].innerHTML; //Preenche o array
	}
	linhaEmEdicao = null;
}

//Cancela a edi��o de uma linha
function Cancelar(){
	abrirPag('../categoria/ManterCategoriaVestuario.php'); //Carrega a p�gina
}

//Cancela a inclus�o de uma linha, excluindo-a
function CancelarInclusao(){
	var linha = document.getElementById(linhaEmEdicao);//Armazena o id da linha em edi��o
	linha.parentNode.removeChild(linha);// Remove a linha que seria inclu�da
	linhasNovas--;//Decrementa o n�mero de linhas
	linhaEmEdicao = null;
}

//Atualiza o conte�do da linha
function Atualizar(novaDescricao, codigo){
	Aviso(1); //Exibe o aviso aguarde...
	var url = "../../../controller/CategoriaController.class.php?operacao=alterar&codigo='"+codigo+"'&descricao='"+novaDescricao+"'"; //Monta a url
	requisicaoHTTP("GET", url, true, trataResposta);//Inicia a requisi��o
}

//Chamada do programa em PHP que cadastra no banco de dados
function Cadastrar(codigo, descricao){
	Aviso(1);//Chama a fun��o aviso
	var url = "../../../controller/CategoriaController.class.php?operacao=cadastrar&codigo="+codigo+"&descricao="+descricao;//Url que ser� enviada
	requisicaoHTTP("GET", url, true, trataResposta);//Inicia a requisi��o
}

//----- Trata a resposta do servidor -----
function trataResposta(){
	if(ajax.readyState == 4){// Se todas as informa��es e a conex�o foi fechada...
		if(ajax.status == 200){// Se o status da conex�o for 200
			trataDados(); // Chama a fun��o trataDAdos
		}
		else{
			alert("Problema na comunica��o com o objeto XMLHttpRequest.");
		}
	}
}

//Exibe ou oculta a mensagem de espera
function Aviso(exibir){
	var saida = document.getElementById("avisos");//Armazena a chamada da div avisos
	if(exibir){// Se exibir for verdadeio...
		saida.className = "aviso";//Define que a classe a ser usada ser� avisos
		saida.innerHTML = "Aguarde... Processando!";// Exibe o aviso: Aguarde... Processando!
	}else{
		saida.className = "";//Elimina a classe se exibir for falso
		saida.innerHTML = "";//N�o exibe nenhum aviso
	}
}

//Trata a  resposta do servidor, de acordo com a opera��o realizada
function trataDados(){
	var resposta = ajax.responseText; //armazena a resposta do servidor
	
	if(resposta != null && resposta != ""){
		Aviso(0);
		//window.location.reload();
		alert(resposta);
	}
	
	abrirPag('../categoria/ManterCategoriaVestuario.php');
	
}