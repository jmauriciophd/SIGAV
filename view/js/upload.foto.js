/** Descri��o: Arquivo de script que faz o upload de fotos
 * 	Autor da Cria��o: Rafael Dias
 *  Data de Cria��o: 03/11/2012
 */

$(function(){
	$('#foto').live('change',function(){
		$('#operacao').val("upload");
		isSubmetido = true;
		 $('#visualizar').html('<img src="../../img/ajax-loader.gif" alt="Enviando foto..."/> Enviando foto...');
		 $('#progresso').show();
		 /* Efetua o Upload */
		 $('#funcionarioForm').ajaxForm({
			//target:'#visualizar', // o callback ser� no elemento com o id #visualizar
			uploadProgress: function(event, position, total, percentComplete) {
	             $('progress').attr('value',percentComplete);
	             $('progress').attr('title','Foto '+percentComplete+'% carregada.');
	             $('#porcentagem').html(percentComplete+'%');
		   },
		   success: function(data) {
		         $('progress').attr('value','100');
		         $('progress').attr('title','Foto carregada com sucesso.');
		         $('#porcentagem').html('100%');
		         $('#visualizar').html(data);
	        },
		    error: function(data) {
		         $('progress').attr('value','0');
		         $('progress').attr('title','Erro ao tentar carregar a foto.');
		         $('#porcentagem').html('0%');
		         $('#visualizar').html(data);
		         $('#progresso').hide();
	        }
		 }).submit();
		 isSubmetido = false;
	 });
	
});
