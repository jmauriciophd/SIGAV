/** Descrição: Arquivo de script das funções javascripts usadas nos popup modal
 * 	Autor da Criação: Rafael Dias
 *  Data de Criação: 15/09/2012
 */

 $(document).ready(function() {
 
    //Change these values to style your modal popup
    var source = "../categoria/ManterCategoriaVestuario.php";
    var width = 1104;
    var align = "center";
    var top = 150;
    var padding = 40;
    var backgroundColor = "#FFFFFF";
    var borderColor = "#FFFFFF";
    var borderWeight = 4;
    var borderRadius = 5;
    var fadeOutTime = 300;
    var disableColor = "black";
    var disableOpacity = 70;
    var loadingImage = "../../img/ajax-loader.gif";
 
    //This method initialises the modal popup
    $(".modal").click(function() {
 
        modalPopup( align,
		    top,
		    width,
		    padding,
		    disableColor,
		    disableOpacity,
		    backgroundColor,
		    borderColor,
		    borderWeight,
		    borderRadius,
		    fadeOutTime,
		    source,
		    loadingImage );
 
    });	
 
    //This method hides the popup when the escape key is pressed
    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            closePopup(fadeOutTime);
        }
    });
    
    $("#popup_ajuda").click(function() {
    	abrirPopup("../ajuda/manual_mp.html", 1200, 500);
    });	
 
    
    $('a[name=modal]').click(function(e) {
		e.preventDefault();
		
		var id = $(this).attr('href');
	
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		$('#mask').css({'width':maskWidth,'height':maskHeight});

		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		$(id).fadeIn(2000); 
	
	});
	
	$('window.close').click(function (e) {
		e.preventDefault();		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});		
    
  });
 
 
 function abrirPopup(pagina,largura,altura) {

	//pega a resolução do visitante
	w = screen.width;
	h = screen.height;

	//divide a resolução por 2, obtendo o centro do monitor
	meio_w = w/2;
	meio_h = h/2;

	//diminui o valor da metade da resolução pelo tamanho da janela, fazendo com q ela fique centralizada
	altura2 = altura/2;
	largura2 = largura/2;
	meio1 = meio_h-altura2;
	meio2 = meio_w-largura2;

	//abre a nova janela, já com a sua devida posição
	window.open(pagina,'','height=' + altura + ', width=' + largura + ', top='+meio1+', left='+meio2+''); 
	
 }
 
 function fecharModal(){
		$("#opacidadeTela").hide();
 }