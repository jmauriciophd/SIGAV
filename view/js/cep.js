/** Descri��o: Arquivo de script do webservice que busca o endereco pelo cep
 * 	Autor da Cria��o: Rafael Dias
 *  Data de Cria��o: 03/11/2012
 */

$(function(){
	//localiza o endereco pelo cep no site 
	//http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep=
	$('#buscarEnderecoPorCep').click(function () {
		if($('#cep').val() == "") $('#cep').focus();
			buscaEnderecoPorCEP();
    });
	
});

function buscaEnderecoPorCEP(){
	$('#cep').cep({
        load: function () {
			$('#loading').show();
		},
		complete: function () {
			$('#loading').hide();
		},
		error: function (msg) {
			alert(msg);
			$('#cep').focus();
		},
		success: function (data) {
            $('#endereco').val(data.tipoLogradouro + ' ' + data.logradouro);
            $('#bairro').val(data.bairro);
            $('#cidade').val(data.cidade);
            $('#estado').val(data.estado);
            $('#numero').focus();
        }
    });

}

function carregaEstado(sigla){
    var listaSiglas = new Array('AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SP', 'SC', 'SE', 'TO');
	var listaEstados = new Array("Acre", "Alagoas", "Amap�", "Amazonas", "Bahia", "Cear�", "Distrito Federal", "Esp�rito Santos", "Goi�s", "Maranh�o", "Mato Grosso", "Mato Grosso do Sul", "Minas Gerais", "Paran�", "Para�ba", "Par�", "Pernambuco", "Piau�", "Rio de Janeiro", "Rio Grande do Norte", "Rio Grande do Sul", "Rond�nia", "Roraima", "Santa Catarina", "Sergipe", "S�o Paulo", "Tocantins");
	for(var i = 0; listaSiglas.length; i++){
     if(sigla == listaSiglas[i])
        return listaEstados[i];
	}
}
