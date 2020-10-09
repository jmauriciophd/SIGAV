/** Descrição: Arquivo de script das funções javascripts de calendario e validação de data
 * 	Autor da Criação: Rafael Dias
 *  Data de Criação: 14/11/2012
 */

$(function(){
	$('#data_nascimento').datepicker({maxDate:'-10Y', yearRange:'-100:+10'}).change( function (){
		$('#data_nascimento').focus();
	});
	$('#data_nascimento').validaData();
	$('#data_admissao').datepicker({maxDate:'0Y', yearRange:'-100:+10'}).change( function (){
		$('#data_admissao').focus();
	});
	$('#data_admissao').validaData();
	$('#data_demissao').datepicker({maxDate:'-10Y', yearRange:'-100:+10'}).change( function (){
		$('#data_demissao').focus();
	});
	$('#data_demissao').validaData();
	$('#data_inicial').datepicker({maxDate:'-10Y', yearRange:'-100:+10'}).change( function (){
		$('#data_inicial').focus();
	});
	$('#data_inicial').validaData();
	$('#data_final').datepicker({maxDate:'-10Y', yearRange:'-100:+10'}).change( function (){
		$('#data_final').focus();
	});
	$('#data_final').validaData();
	$('#data_pagamento').datepicker({maxDate:'-10Y', yearRange:'-100:+10'}).change( function (){
		$('#data_pagamento').focus();
	});
	$('#data_pagamento').validaData();
	$('#data_vencimento').datepicker({maxDate:'-10Y', yearRange:'-100:+10'}).change( function (){
		$('#data_vencimento').focus();
	});
	$('#data_vencimento').validaData();
});

