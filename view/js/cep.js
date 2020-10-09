/** Descrição: Arquivo de script do webservice que busca o endereco pelo cep
 * 	Autor da Criação: Rafael Dias
 *  Data de Criação: 03/11/2012
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
	var listaEstados = new Array("Acre", "Alagoas", "Amapá", "Amazonas", "Bahia", "Ceará", "Distrito Federal", "Espírito Santos", "Goiás", "Maranhão", "Mato Grosso", "Mato Grosso do Sul", "Minas Gerais", "Paraná", "Paraíba", "Pará", "Pernambuco", "Piauí", "Rio de Janeiro", "Rio Grande do Norte", "Rio Grande do Sul", "Rondônia", "Roraima", "Santa Catarina", "Sergipe", "São Paulo", "Tocantins");
	for(var i = 0; listaSiglas.length; i++){
     if(sigla == listaSiglas[i])
        return listaEstados[i];
	}
}
