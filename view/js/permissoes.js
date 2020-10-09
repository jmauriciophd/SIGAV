/** Descrição: Arquivo de script das funções javascripts para as permissoes de acesso
 * 	Autor da Criação: Rafael Dias
 *  Data de Criação: 05/11/2012
 */

$(function(){
	 $('#tabelaAplicacao').dataTable({
	    	"bJQueryUI": true, //muda o tema da pagina
	    	"bProcessing": true,
	        "sPaginationType": "full_numbers", //muda o tipo da paginacao
	        "aoColumnDefs": [{"bSortable": false, "aTargets": [ 0 , 2, 3, 4, 5, 6 ]}],
	        "oLanguage": {"sUrl": "../../js/jquery/datatables.Portuguese.txt"}, //traduz os textos da biblioteca para portugues
	    	"aaSorting": [[ 1, "asc" ]] //ordenacao inicial
	});
	
	 $("#cadastrar").click(function(event) {
	    event.preventDefault();
	    executarAcao("cadastrar", false); 
	 });
	 
	$("#perfil").change(function(){
	    buscarPermissaoAcesso();
	});
	
	//campos do checkbox do formulario permissaoFormCadastrar
	$("#marcarTodosCBAcesso").click(function(){
		selecionarTodosCheckBox(".checkAcesso", this);
	});
	
	$("#marcarTodosCBCadastro").click(function(){
		selecionarTodosCheckBox(".checkCadastra", this);
	});
	
	$("#marcarTodosCBAltera").click(function(){
		selecionarTodosCheckBox(".checkAltera", this);
    });
	
	$("#marcarTodosCBExclui").click(function(){
		selecionarTodosCheckBox(".checkExclui", this);
    });
	
    $("#marcarTodosCBConsulta").click(function(){
    	selecionarTodosCheckBox(".checkConsulta", this);
    });
    
    $("#marcarTodosCBImprimi").click(function(){
    	selecionarTodosCheckBox(".checkImprimi", this);
    });

});

function selecionarTodosCheckBox(classe, check){
	jQuery.each($(classe), function(){
		this.checked = (check.checked) ? true : false;
	});
}

function desmacarTodosCheckBox(classe, check){
	jQuery.each($(classe), function(){
		this.checked = false;
	});
}

function macarTodosCheckBox(classe, check){
	jQuery.each($(classe), function(){
		this.checked = true;
	});
}

function buscarPermissaoAcesso(){
	var perfil_permissao = $("#perfil").val();
	if(perfil_permissao != ""){
	    $.ajax({
	        url : "../../../controller/PermissaoController.class.php?operacao=exibirDadosPermissao&id_perfil="+perfil_permissao,
	        dataType : "json",
	        success : function(data){
	        	if(data != null && data.length > 0){
		            for(var i=0; i < data.length; i++){
		            	$("#perfilNome").html(data[i].perfil.nome);
		            	$("#descricao").html(data[i].perfil.descricao);
		            	$("#id_permissao").val(data[i].id_permissao);
		            	selecionarCheckBox("#acesso"+i, data[i].acessa);
		            	selecionarCheckBox("#cadastra"+i, data[i].cadastra);
		            	selecionarCheckBox("#altera"+i, data[i].altera);
		            	selecionarCheckBox("#exclui"+i, data[i].exclui);
		            	selecionarCheckBox("#consulta"+i, data[i].consulta);
		            	selecionarCheckBox("#imprimi"+i, data[i].imprimi);
		            }
	        	} else{
	        		$("#perfilNome").html("Este perfil ainda n&atilde;o possui nenhuma permiss&atilde;o");
	            	$("#descricao").html("Este perfil ainda n&atilde;o possui nenhuma permiss&atilde;o");
	            	$("#id_permissao").val("");
	        		desmacarTodosCheckBox(".checkAcesso", this);
	        		desmacarTodosCheckBox(".checkCadastra", this);
	        		desmacarTodosCheckBox(".checkAltera", this);
	        		desmacarTodosCheckBox(".checkExclui", this);
	        		desmacarTodosCheckBox(".checkConsulta", this);
	        		desmacarTodosCheckBox(".checkImprimi", this);
	        	}
	        }
	    });
	} else{
		$("#perfilNome").html("Selecione um perfil");
    	$("#descricao").html("Selecione um perfil");
		desmacarTodosCheckBox(".checkAcesso", this);
		desmacarTodosCheckBox(".checkCadastra", this);
		desmacarTodosCheckBox(".checkAltera", this);
		desmacarTodosCheckBox(".checkExclui", this);
		desmacarTodosCheckBox(".checkConsulta", this);
		desmacarTodosCheckBox(".checkImprimi", this);
	}
}

function selecionarCheckBox(id, valor){
	checked = (valor == 'S') ? true : false;
	$(id).attr("checked", checked);
}