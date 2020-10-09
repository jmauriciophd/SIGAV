/** Descrição: Arquivo de script das funções javascripts usadas nos formularios
 * 	Autor da Criação: Rafael Dias
 *  Data de Criação: 31/08/2012
 */

var isSubmetido = false;
var listaCamposObrigatorios = null;

$(function(){
	
	//valida os campos do formulario
	$('form').submit(function(e){
		if(!isSubmetido){
			$('#operacao').val("cadastrar");
			return validarCampos();
		}
	});
	
	$(".requerido").blur(function(){
		this.value = this.value.toUpperCase();
		return isPreenchido(this);
	});
	
	$(".requerSelecao").blur(function(){
		return isSelecionado(this);
	});
	
	//valida o cnpj
	$("#cnpj").blur(function(){
		esconderMsg();
		if(!validaCnpj($("#cnpj").mask())){
			this.className = "dataFieldError";
			$('#msgCampoObrigatorio').html("Informe um CNPJ v&aacute;lido!");
			$('#msgCampoObrigatorio').show();
			$("#cnpj").focus();
			return false;
		} else{
			this.className = "";
			$('#msgCampoObrigatorio').hide();
			return true;
		}
	});
	
	//valida o cpf
	$("#cpf").blur(function(){
		esconderMsg();
		if(!validaCpf($("#cpf").mask())){
			//alert("CPF inválido! Preencha corretamente o campo CPF.");
			this.className = "dataFieldError";
			$('#msgCampoObrigatorio').html("Informe um CPF v&aacute;lido!");
			$('#msgCampoObrigatorio').show();
			$("#cpf").focus();
			return false;
		} else{
			this.className = "";
			$('#msgCampoObrigatorio').hide();
			return true;
		}
	});
	
	if($("#email").val() != undefined){
		$("#email").validaEmail();
	}
	
	$("#numero").apenasNumeros();
	
	$("#tamanho_medidas").apenasNumeros();
	$("#busto_torax").apenasNumeros();
	$("#cintura").apenasNumeros();
	$("#quadril").apenasNumeros();
	$("#altura_frente").apenasNumeros();
	$("#ombro").apenasNumeros();
	$("#costas").apenasNumeros();
	$("#braco").apenasNumeros();
	
	$("#comissao").apenasNumeros();
	$("#ctps").apenasNumeros();
	$("#num_serie").apenasNumeros();
	$("#quantidade").apenasNumeros();
});

function validarCampos(){
	var temErro = true;
	var campoFocus = null;
	esconderMsg();
	//insira o campo obrigatorio sempre no final da lista
	listaCamposObrigatorios = new Array('cnpj', 'razao_social', 'nome_fantasia','codigoestuario','cor','medidas',
			'nome', 'rg', 'orgao_expeditor', 'uf_orgao_expeditor', 'inscricao_estadual', 'perfil', 'senha', 'confirme_senha',
			'cep', 'bairro', 'endereco', 'cidade', 'estado', 'tel_residencial', 'estado_civil',
			'sexo', 'data_nascimento', 'numero', 'codigo_categoria', 'categoria', 'valor_vestuario',
			'valor_entrada', 'forma_pagamento', 'ctps', 'num_serie', 'cargo', 'comissao', 'salario', 
			'data_admissao', 'data_entrega', 'cpf_cliente', 'data_prevista_devolucao', 'valor_aluguel',
			'descricao', 'tel_comercial', 'email');
	
	for(var i = 0; i < listaCamposObrigatorios.length; i++){
		if(document.getElementById(listaCamposObrigatorios[i]) != null && !isPreenchido(document.getElementById(listaCamposObrigatorios[i]))){
			if(campoFocus == null){
				campoFocus = document.getElementById(listaCamposObrigatorios[i]);
				//alert(listaCamposObrigatorios[i]);
			}
			temErro = false;
		}
	}

	if(!temErro){
		var msgError = document.getElementById('msgCampoObrigatorio');
		msgError.style.display = "block";
		campoFocus.focus();
	}
	
	return temErro;
}

function isPreenchido(campo){
	if(campo.value == ""){
		exibirMsgCampoObrigatorio(campo, true);
		return false;
	} else{
		exibirMsgCampoObrigatorio(campo, false);
		return true;
	}
}

function isSelecionado(campo){
	if(campo.selectedIndex != undefined && campo.selectedIndex == 0){
		exibirMsgCampoObrigatorio(campo, true);
		return false;
	} else{
		exibirMsgCampoObrigatorio(campo, false);
		return true;
	}
}

function exibirMsgCampoObrigatorio(campo, exibir){
	esconderMsg();
	if(exibir){
		campo.className = "dataFieldError";
		$('#msgCampoObrigatorio').html("Preencha os campos obrigat&oacute;rios!");
		$('#msgCampoObrigatorio').show();
	} else{
		campo.className = "requerido";
	}
}

function validaCnpj(cnpj){
	var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
	digitos_iguais = 1;
	if (cnpj.length < 14 && cnpj.length < 15)
	      return false;
	for (i = 0; i < cnpj.length - 1; i++)
	      if (cnpj.charAt(i) != cnpj.charAt(i + 1))
	            {
	            digitos_iguais = 0;
	            break;
	            }
	if (!digitos_iguais){
	      tamanho = cnpj.length - 2;
	      numeros = cnpj.substring(0,tamanho);
	      digitos = cnpj.substring(tamanho);
	      soma = 0;
	      pos = tamanho - 7;
	      for (i = tamanho; i >= 1; i--)
	            {
	            soma += numeros.charAt(tamanho - i) * pos--;
	            if (pos < 2)
	                  pos = 9;
	            }
	      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	      if (resultado != digitos.charAt(0))
	            return false;
	      tamanho = tamanho + 1;
	      numeros = cnpj.substring(0,tamanho);
	      soma = 0;
	      pos = tamanho - 7;
	      for (i = tamanho; i >= 1; i--)
	            {
	            soma += numeros.charAt(tamanho - i) * pos--;
	            if (pos < 2)
	                  pos = 9;
	            }
	      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	      if (resultado != digitos.charAt(1))
	            return false;
	      return true;
	      }
	else
	      return false;
} 

function validaCpf(cpf){
	var numeros, digitos, soma, i, resultado, digitos_iguais;
	digitos_iguais = 1;
	if (cpf.length < 11)
	      return false;
	for (i = 0; i < cpf.length - 1; i++)
	      if (cpf.charAt(i) != cpf.charAt(i + 1))
	            {
	            digitos_iguais = 0;
	            break;
	            }
	if (!digitos_iguais)
	      {
	      numeros = cpf.substring(0,9);
	      digitos = cpf.substring(9);
	      soma = 0;
	      for (i = 10; i > 1; i--)
	            soma += numeros.charAt(10 - i) * i;
	      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	      if (resultado != digitos.charAt(0))
	            return false;
	      numeros = cpf.substring(0,10);
	      soma = 0;
	      for (i = 11; i > 1; i--)
	            soma += numeros.charAt(11 - i) * i;
	      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	      if (resultado != digitos.charAt(1))
	            return false;
	      return true;
	      }
	else
	      return false;
}

function esconderMsg(){
	$('#msgCampoObrigatorio').hide();
	$('#dataFieldError').hide();
	$('#msgSucess').hide();
	$('#msgError').hide();
}

function validarTamanhoSenha(){
	if($('#senha').val().length < 6){
		esconderMsg();
		$('#senha').className = "dataFieldError";
		$('#msgCampoObrigatorio').show().html("A senha deve possuir no m&iacute;nimo 6 (seis) caracteres!");
		$("#confirma_senha").val("");
		$('#senha').val("").focus();
		return false;
	} else {
		$('#senha').className = "requerido";
		return true;
	}
}

function validarConfirmarSenha(){
	if($('#senha').val() != $("#confirma_senha").val()){
		esconderMsg();
		$('#msgCampoObrigatorio').show().html("A confirma&ccedil;&atilde;o da senha n&atilde;o confere com a senha digitada!");
		$("#confirma_senha").val("");
		$('#senha').val("").focus();
		return false;
	} else {
		return true;
	}
}