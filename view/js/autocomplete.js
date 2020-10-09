/** Descri��o: Arquivo de script das fun��es de autocomplete
 * 	Autor da Cria��o: Rafael Dias
 *  Data de Cria��o: 03/11/2012
 */


$(function(){
	
	$("#cpf_cliente").autocomplete("../../../controller/ClienteController.class.php?operacao=buscarCpfCliente", {
		width:140,
		selectFirst: false
	});
	
	$("#codigo_vestuario").autocomplete("../../../controller/VestuarioController.class.php?operacao=buscarCodigoVestuario", {
		width:140,
		selectFirst: false
	});
	
	$("#nome_vestuario").autocomplete("../../../controller/VestuarioController.class.php?operacao=buscarNomeVestuario", {
		width:140,
		selectFirst: false
	});
	
});