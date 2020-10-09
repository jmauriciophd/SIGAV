<!-- Header -->
 <div id="form" style="width: 386px;">
 	<div class="top-left"></div>
	<div class="top-right">
		<div id="titulo_form">CADASTRO DE CATEGORIA</div>
	</div>
	<div class="inside"> 
  <!-- Content -->   
<form method="post" action="../../../controller/CategoriaController.class.php">
      <table style="width: 356px;" cellpadding="0" cellspacing="4">
         <tr>
	   		<td colspan="2" align="center"> 
	   			<div id="msgCampoObrigatorio">Preencha os campos obrigatorios!</div>
	   		</td>
	    </tr>
      	<tr>
	      	<td>
		        <label for="codigo" title="Código">Código:</label>
		    </td>	
		    <td>		        		
		        <input type="text" name="codigo" id="codigo" style="width: 200px;" class="requerido" title="Informe o Código da Categoria" maxlength="20"/>
	      	    <span class="asterico">*</span>
	      	</td>
      	</tr>
        <tr>
	     	 <td valign="top">
		        <label id="categoria" title="Categoria">Categoria:</label>
		     </td>	
			 <td>   
		        <input type="text" name="categoria" id="categoria" style="width: 200px;" class="requerido" title="Informe a Categoria" maxlength="100"/>
		      	<span class="asterico">*</span>
		     </td>
        </tr>
        <tr><td colspan="2"><p></p></td></tr>
        <tr>
		  <td colspan="2" align="center">
		  	<input name="cadastrar" type="submit" id="cadastrar" title="Cadastrar" value="Cadastrar" <?php PermissaoController::desabilitarBotao("CATEGORIA", "cadastrar"); ?>/> 
		  	<input name="cancelar" type="button" id="cancelar" class="botao" title="Cancelar" value="Cancelar" />
	   	  </td>
      </tr>
      </table>
    </form>
   <!-- Trailler -->
 </div>
	<div class="bottom-left"></div>
	<div class="bottom-right" style="padding-left:35px;"></div>
</div>