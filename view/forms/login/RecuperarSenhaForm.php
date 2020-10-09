
<script type="text/javascript">
$(document).ready(function(){
    $("a[rel=modal]").click( function(ev){
        ev.preventDefault();
        esconderMsg();
        var id = $(this).attr("href");
 
        var alturaTela = $(document).height();
        var larguraTela = $(window).width();
     
        //colocando o fundo preto
        $('#mascara').css({'width':larguraTela,'height':alturaTela});
        $('#mascara').fadeIn(1000); 
        $('#mascara').fadeTo("slow",0.8);
 
        var left = ($(window).width() /2) - ( $(id).width() / 2 );
        var top = ($(window).height() / 2) - ( $(id).height() / 2 );
     
        $(id).css({'top':top,'left':left});
        $(id).show();
        $("#cpf_usuario").focus();
    });

    $("#cpf_usuario").blur(function(){
    	$("#cpf").val($("#cpf_usuario").val());
    	$("#senha").val(" ");
    });

    $("#email").blur( function(){
    	$("#cpf").val($("#cpf_usuario").val());
    	$("#senha").val(" "); 
    });

    $("#mascara").click( function(){
        $(this).hide();
        $(".window").hide();
    });
 
    $('.fechar').click(function(ev){
        ev.preventDefault();
        $("#mascara").hide();
        $(".window").hide();
        $("#senha").val("");
    });
});
</script>
 
<div class="window" id="recuperarSenha">
    <form action="../../../controller/UsuarioController.class.php" method="post">
		<div id="recuperar_senha_form">
			<div class="top-left"></div>
			<div class="top-right">
				<div id="titulo_form">Recuperar Senha 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="#" class="fechar">[X] Fechar</a></div>
			</div>
			<div class="inside">
				<div class="campo">
					<input type="hidden" name="operacao" value="recuperarSenha"/>
			    	<label for="cpf_usuario" class="label_cpf">CPF:</label>&nbsp;
		        	<input type="text" name="cpf_usuario" id="cpf_usuario" style="width: 120px;" maxlength="11" title="Informe seu CPF" class="requerido"/><br/>
		        </div>
		        <div class="campo">
		        	<label for="email" class="label_email">E-mail:</label>
		        	<input type="text" name="email" id="email"  maxlength="100" title="Informe seu E-mail" class="requerido"/>
		    	</div>
		    </div>
			<div class="bottom-left"></div><div class="bottom-right" style="padding-left:35px;">
			<span class="button"><input type="submit" name="enviar" value="Enviar" title="Enviar"/></span>
			</div>
		</div>
 	</form>
</div>
 
<!-- mascara para cobrir a pagina -->  
<div id="mascara"></div>
