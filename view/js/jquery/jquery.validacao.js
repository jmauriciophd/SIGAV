/** Plugin Jquery criado para validar campos do tipo data, cpf, cnpj, email, etc. 
 * 	Autor da Criação: Rafael Dias
 *  Data de Criação: 01/11/2012
 */
/* Função jquery que valida data */
jQuery.fn.validaData = function(){    
  $(this).change(function(event){
    $valor = $(this).val();
    if($valor){
      $erro = "";
      var expReg = /^((0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/[1-2][0-9]\d{2})$/;
      if($valor.match(expReg)){
        var $dia  = parseFloat($valor.substring(0,2));
        var $mes  = parseFloat($valor.substring(3,5));
        var $ano  = parseFloat($valor.substring(6,10));        

        if(($mes==4 && $dia>30) || ($mes==6 && $dia>30) || ($mes==9 && $dia>30) || ($mes==11 && $dia>30)){
          $erro = "Data incorreta! O mês especificado na data "+$valor+" contém 30 dias.";
        }else{
          if($ano%4!=0 && $mes==2 && $dia>28){
            $erro = "Data incorreta!! O mês especificado na data "+$valor+" contém 28 dias.";
          }else{
            if($ano%4==0 && $mes==2 && $dia>29){
              $erro = "Data incorreta!! O mês especificado na data "+$valor+" contém 29 dias.";
            }
          }
        }
      }else{
        $erro = "Formato de Data para "+$valor+" é inválido";
      }
      if($erro){
        $(this).val('');
        alert($erro);
        $(this).focus();                   
      }else{
        return $(this);
      }      
    }else{
      return $(this);
    }
  });
};
/* Compara data inical e data final
$(function(){ 
 var data_inicio = $("#data_inicial").val(); 
 var data_fim = $("#data_final").val();  
 var compara1 = parseInt(data_inicio.split("/")[2].toString() + data_inicio.split("/")[1].toString() + data_inicio.split("/")[0].toString()); 
 var compara2 = parseInt(data_fim.split("/")[2].toString() + data_fim.split("/")[1].toString() + data_fim.split("/")[0].toString());  
 if (compara1 < compara2) {
	 $('#resultado').html("Tudo certo"); 
	 }
 else{
	 $('#resultado').html("Data final não pode ser menor ou igual a data inicial"); 
  } return false;
});
 */
/* Função jquery que valida cpf */
jQuery.fn.validaCpf = function(){ 
    this.change(function(){
        CPF = $(this).val();
        if(!CPF){ return false;}
        erro  = new String;
        cpfv  = CPF;
        if(cpfv.length == 14 || cpfv.length == 11){
            cpfv = cpfv.replace('.', '');
            cpfv = cpfv.replace('.', '');
            cpfv = cpfv.replace('-', '');
  
            var nonNumbers = /\D/;
    
            if(nonNumbers.test(cpfv)){
                erro = "A verificacao de CPF suporta apenas números!";
            }else{
                if (cpfv == "00000000000" ||
                    cpfv == "11111111111" ||
                    cpfv == "22222222222" ||
                    cpfv == "33333333333" ||
                    cpfv == "44444444444" ||
                    cpfv == "55555555555" ||
                    cpfv == "66666666666" ||
                    cpfv == "77777777777" ||
                    cpfv == "88888888888" ||
                    cpfv == "99999999999") {
                            
                    erro = "Número de CPF inválido!";
                }
                var a = [];
                var b = new Number;
                var c = 11;
  
                for(var i=0; i<11; i++){
                    a[i] = cpfv.charAt(i);
                    if (i < 9) b += (a[i] * --c);
                }
                if((x = b % 11) < 2){
                    a[9] = 0;
                }else{
                    a[9] = 11-x;
                }
                b = 0;
                c = 11;
                for (var y=0; y<10; y++) b += (a[y] * c--);
    
                if((x = b % 11) < 2){
                    a[10] = 0;
                }else{
                    a[10] = 11-x;
                }
                if((cpfv.charAt(9) != a[9]) || (cpfv.charAt(10) != a[10])){
                    erro = "Número de CPF inválido.";
                }
            }
        }else{
            if(cpfv.length == 0){
                return false;
            }else{
                erro = "Número de CPF inválido.";
            }
        }
        if (erro.length > 0){
            $(this).val('');
            alert(erro);
            setTimeout(function(){$(this).focus();},100);
            return false;
        }
        return $(this);
    });
};

/* Função jquery que valida cnpj */
jQuery.fn.validaCnpj = function(){
	  this.change(function(){
	    CNPJ = $(this).val();
	    if(!CNPJ){ return false;}
	    erro = new String;
	    if(CNPJ == "00.000.000/0000-00"){ erro += "CNPJ inválido\n\n";}
	    CNPJ = CNPJ.replace(".","");
	    CNPJ = CNPJ.replace(".","");
	    CNPJ = CNPJ.replace("-","");
	    CNPJ = CNPJ.replace("/","");

	    var a = [];
	    var b = new Number;
	    var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
	    for(var i=0; i<12; i++){
	      a[i] = CNPJ.charAt(i);
	      b += a[i] * c[i+1];
	    }
	    if((x = b % 11) < 2){
	      a[12] = 0;
	    }else{
	      a[12] = 11-x;
	    }
	    b = 0;
	    for(var y=0; y<13; y++){
	      b += (a[y] * c[y]);
	    }
	    if((x = b % 11) < 2){
	      a[13] = 0;
	    }else{
	      a[13] = 11-x;
	    }
	    if((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){ erro +="Dígito verificador com problema!";}
	    if (erro.length > 0){
	      $(this).val('');
	      alert(erro);
	      setTimeout(function(){ $(this).focus();},50);        
	    }
	    return $(this);
	  });
};

/* Função jquery que valida email */
jQuery.fn.validaEmail = function(){ 
    this.change(function(){
        var email = $(this).val();
        if(!email){ return false;}
        var regra = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
        if(regra.test(email)){
            return true;
        }else{
            $(this).val('');
            alert('E-mail incorreto!');
            $(this).focus();
        }
        return $(this);
    });
};

/* Função jquery que permite digitar apenas numeros em campos */
jQuery.fn.apenasNumeros = function(){
    var $teclas = {8:'backspace',9:'tab',13:'enter',48:0,49:1,50:2,51:3,52:4,53:5,54:6,55:7,56:8,57:9};    
    $(this).keypress(function(e){
      var keyCode = e.keyCode?e.keyCode:e.which?e.which:e.charCode;
      if(keyCode in $teclas){
        return true;
      }else{
        return false;
      }
    });
    return $(this);
 };