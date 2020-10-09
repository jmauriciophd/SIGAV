/** Descrição: Arquivo de script das função de mascaras dos campos de formulario
 * 	Autor da Criação: Rafael Dias
 *  Data de Criação: 03/11/2012
 */

$(function(){
	//coloca mascara nos campos dos formularios
	$("#cnpj").mask("99.999.999/9999-99");
	$("#tel_residencial").mask("(99) 9999-9999");
	$("#tel_celular").mask("(99) 9999-9999");
	$("#tel_celular2").mask("(99) 9999-9999");
	$("#tel_comercial").mask("(99) 9999-9999");
	$("#cpf").mask("999.999.999-99");
	$("#cpf_usuario").mask("999.999.999-99");
	$("#cpf_cliente").mask("999.999.999-99");
	$("#cpf_funcionario").mask("999.999.999-99");
	$("#cep").mask("99999-999");
	$("#data_nascimento").mask("99/99/9999");
	$("#data_locacao").mask("99/99/9999");
	$("#data_devolucao").mask("99/99/9999");
	$("#data_entrega").mask("99/99/9999");
	$("#data_previa").mask("99/99/9999");
	$("#data_prevista_devolucao").mask("99/99/9999");
	$("#data_prova").mask("99/99/9999");
	$("#data_inicial").mask("99/99/9999");
	$("#data_final").mask("99/99/9999");
	$("#data_admissao").mask("99/99/9999");	
});
