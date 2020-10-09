<table class="tabelaInterna" cellpadding="0" cellspacing="4">
      <tr>
   		<td colspan="6" align="left" class="cabecalho2">
   			<strong title="Cadastro de Usuário">CADASTRO DE USUARIO</strong>
   		</td>
	  </tr>
      <tr>
	       <td>
		      <label for="perfil" title="Perfil">Perfil:</label>
		   </td>	
		   <td>   
		      <select name="perfil" id="perfil" class="requerSelecao" title="Selecione um Perfil">
		      		<option value="">Selecione um Perfil</option>
		      		<option value="undefined" style="display: none;"></option>
		      		<?php 
		      			$perfilController = new PerfilController();
		      			echo $perfilController->carregarComboPerfil(); 
		      		?> 
		      </select>
	       	  <span class="asterico">*</span>	
	       </td>
	      <td>
	        <label for="senha" title="Senha">Senha:</label>
	      </td>	
		  <td>  
	        <input type="password" name="senha" id="senha" class="requerido" title="Informe a Senha" maxlength="20" />
	      	<span class="asterico">*</span>
	      </td>
	      <td>
	        <label for="confirme_senha" title="Confirme a Senha">Confirmar Senha:</label>
	      </td>	
		  <td>  
	        <input type="password" name="confirme_senha" id="confirme_senha" class="requerido" title="Confirme a Senha" maxlength="20" />
	      	<span class="asterico">*</span>
	      </td>
      </tr>
</table>