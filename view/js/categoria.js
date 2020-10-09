/** Funções javascript de operções do manter categoria
 * @author Rafael Dias
 * Data Criacao: 05/11/2012
 */

//Prepara uma linha para edição
function EditarLinha(idLinha, codigoAntigo){
	if(linhaEmEdicao == null){//Se linhaEmEdicao não for nulo...
		//Obtém a linha a ser editada e altera a sua cor
		var linha = document.getElementById(idLinha);//Obtém o id da linha que será editada
		linha.className = 'linhaSelecionada';//Altera a cor da linha que será editada
		var celulas = linha.cells;//Aramazena a célula que será editada
		
		//salva os dados atuais para o caso de cancelamento
		SalvaDados(idLinha);//Chama a função que salvára os dados atuais da linha antes de editá-la
		linhaEmEdicao = idLinha; //Armazena o id da linha que será editada
		
		//Cria os campo de texto editáveis
		//celulas[0].innerHTML = '<input type="hidden" name="cod" value="'+celulas[0].innerHTML+'">';//Armazena o código do produto num campo oculto de formulário
		//celulas[0].innerHTML = '<input type="text" name="codigo_categoria" id="codigo_categoria" onblur="return isPreenchido(this);" onkeyup="this.value = this.value.toUpperCase();" style="width:100px" value="'+celulas[0].innerHTML+'">';//Mostrar o campo texto permitindo a edição do nome do produto
		celulas[1].innerHTML = '<input type="text" name="categoria" id="categoria" onblur="return isPreenchido(this);" onkeyup="this.value = this.value.toUpperCase();" style="width:100%" value="'+celulas[1].innerHTML+'">';//Mostrar o campo texto permitindo a edição do nome do produto
		celulas[2].innerHTML = '<a href="#" onclick="Atualizar(document.forms[0].categoria.value, \''+codigoAntigo+'\');"><img src="../../img/atualizar.gif" alt="Atualizar" /></a>' +
		'  <a href="#" onclick="Cancelar();"><img src="../../img/cancelar.gif" alt="Cancelar" /></a>';
	}
	else {alert("Você já está digitando um registro.");}
}

//Exclui uma linha da tabela
function ExcluirLinha(idLinha, codigo){
	if(!linhaEmEdicao){
		var linha = document.getElementById(idLinha);//Armazena o id da linha que será excluída
		linha.className = 'linhaSelecionada';// define a classe de estilos que será usada na linha
		if(confirm("Tem certeza que deseja excluir este registro?")){//Pergunta se a linha realmente deve ser excluída
			Aviso(1); // Exibe o aviso: Aguarde...
			var url = "../../../controller/CategoriaController.class.php?operacao=excluir&codigo="+codigo;//Url que será enviada
			requisicaoHTTP("GET", url, true, trataResposta);//Função que fará a requisição
		} else{
			linha.className = 'linha';//Define a classe de estilo que será usada se a linha não estiver maracada para exclusão
		}
	} else{
		alert("Você está com um registro aberto. Feche-o antes de prosseguir.");
	}
}

//Cria um novo registro
function NovoRegistro(){
	
	//Se houver linha sendo editada, cancela edição
	if(linhaEmEdicao){// Se linhas em edição for nulo...
		alert("Você está com um registro aberto. Feche-o antes de prosseguir");
	}else{
		//Insere uma nova linha na tabela
		proxIndice = document.getElementById('tabela').rows.length-1;//Armazena o índice a linha que será inserida
		var novaLinha = document.getElementById('tabela').insertRow(proxIndice);//Insere uma nova linha na tabela
		novaLinha.className = 'linhaSelecionada';//Define a classe de estilos que será usada na n ova linha
	
		//Define o id da nova linha (que será usado em caso de edição/exclusão
		novoId = "nova"+linhasNovas;//Armazena o id da linha
		novaLinha.setAttribute('id', novoId);//Define que o nome do id será o valor da variável novoId
		linhasNovas++; //Incrementa o valor da variável
		linhaEmEdicao = novoId;// Aramazena o valor da variável novoId
		
		//Insere as células na linha criada
		var novasCelulas = new Array(3); //Cria um array
		for(var i=0; i<4; i++){
			novasCelulas[i] = novaLinha.insertCell(i); //Preenche o array
		}
		//Cria os campos dos formulários
		//novasCelulas[0].innerHTML = '*'; //código do produto
		novasCelulas[0].innerHTML = '<input type="text" name="codigo_categoria" id="codigo_categoria" onblur="isPreenchido(this);" onkeyup="this.value = this.value.toString().toUpperCase();" class="requerido, caixaAlta" style="width:80px">'; //insere o campo nome
		novasCelulas[1].innerHTML = '<input type="text" name="categoria" id="categoria" onblur="isPreenchido(this);" onkeyup="this.value = this.value.toString().toUpperCase();" class="requerido, caixaAlta">'; //insere o campo nome
		novasCelulas[2].innerHTML = '<div style="text-align: center;"><a href="#" onclick="Cadastrar(document.forms[0].codigo_categoria.value, document.forms[0].categoria.value);" title="Cadastrar">Cadastrar</a> &nbsp; <a href="#" onclick="CancelarInclusao();" title="Cancelar">Cancelar</a></div>';
	}
}

//Salva os dados atuais num array
function SalvaDados(idLinha){
	var celulas = document.getElementById(idLinha).cells;//Armazena o id  da célula
	dadosAtuais = new Array(celulas.length);//Armazena num array os dados atuais da linha
	for(var i=0; i<celulas.length; i++){
		dadosAtuais[i] = celulas[i].innerHTML; //Preenche o array
	}
	linhaEmEdicao = null;
}

//Cancela a edição de uma linha
function Cancelar(){
	abrirPag('../categoria/ManterCategoriaVestuario.php'); //Carrega a página
}

//Cancela a inclusão de uma linha, excluindo-a
function CancelarInclusao(){
	var linha = document.getElementById(linhaEmEdicao);//Armazena o id da linha em edição
	linha.parentNode.removeChild(linha);// Remove a linha que seria incluída
	linhasNovas--;//Decrementa o número de linhas
	linhaEmEdicao = null;
}

//Atualiza o conteúdo da linha
function Atualizar(novaDescricao, codigo){
	Aviso(1); //Exibe o aviso aguarde...
	var url = "../../../controller/CategoriaController.class.php?operacao=alterar&codigo='"+codigo+"'&descricao='"+novaDescricao+"'"; //Monta a url
	requisicaoHTTP("GET", url, true, trataResposta);//Inicia a requisição
}

//Chamada do programa em PHP que cadastra no banco de dados
function Cadastrar(codigo, descricao){
	Aviso(1);//Chama a função aviso
	var url = "../../../controller/CategoriaController.class.php?operacao=cadastrar&codigo="+codigo+"&descricao="+descricao;//Url que será enviada
	requisicaoHTTP("GET", url, true, trataResposta);//Inicia a requisição
}

//----- Trata a resposta do servidor -----
function trataResposta(){
	if(ajax.readyState == 4){// Se todas as informações e a conexão foi fechada...
		if(ajax.status == 200){// Se o status da conexão for 200
			trataDados(); // Chama a função trataDAdos
		}
		else{
			alert("Problema na comunicação com o objeto XMLHttpRequest.");
		}
	}
}

//Exibe ou oculta a mensagem de espera
function Aviso(exibir){
	var saida = document.getElementById("avisos");//Armazena a chamada da div avisos
	if(exibir){// Se exibir for verdadeio...
		saida.className = "aviso";//Define que a classe a ser usada será avisos
		saida.innerHTML = "Aguarde... Processando!";// Exibe o aviso: Aguarde... Processando!
	}else{
		saida.className = "";//Elimina a classe se exibir for falso
		saida.innerHTML = "";//Não exibe nenhum aviso
	}
}

//Trata a  resposta do servidor, de acordo com a operação realizada
function trataDados(){
	var resposta = ajax.responseText; //armazena a resposta do servidor
	
	if(resposta != null && resposta != ""){
		Aviso(0);
		//window.location.reload();
		alert(resposta);
	}
	
	abrirPag('../categoria/ManterCategoriaVestuario.php');
	
}