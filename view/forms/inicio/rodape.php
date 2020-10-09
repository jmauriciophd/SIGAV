<?php require_once dirname(__FILE__) . "/../../../config/config.sys.php"; 
$nomeUsuario = (isset($_SESSION["NOME_USUARIO"])) ? $_SESSION["NOME_USUARIO"] : "Não autenticado";
$perfilUsuario = (isset($_SESSION['NOME_PERFIL_USUARIO'])) ? $_SESSION['NOME_PERFIL_USUARIO'] : "Não autenticado";
?>

<script>
var tempo_max_sessao = <?php echo TEMPO_SESSAO; ?>;
var minutos = tempo_max_sessao;
var segundos = 0;
var pararChamada = false;

window.onload = function() {
	setInterval(apresentaHoras, 1000);
}

function apresentaHoras(){
	if(minutos <= 0 && segundos <= 0){
		document.getElementById("horas").innerHTML = "Sessão expirada.";
		document.getElementById("horas").style.color = "red";
		pararChamada = true;
	} else{
		var txtM = "";
		var txtS = "min:";

		if(segundos == 0){
			minutos--;
			segundos = 59;
		}
		
		if(minutos < 10) 
			txtM = "0";	
		if(segundos < 10)
			txtS = "min:0";
		
		var horas = txtM + minutos + txtS + segundos-- + "seg";
		document.getElementById("horas").innerHTML = horas;
	}
}
</script>

<label><strong>Usuário:</strong></label> <span style="color:red;"><?php echo $nomeUsuario; ?></span>
<label><strong>Perfil:</strong></label> <span style="color:red;"><?php echo $perfilUsuario; ?></span>
<label><strong>Último Acesso:</strong></label> <span style="color:red;"><?php echo date('d/m/Y H:m:s'); ?></span>
<label><strong>Versão:</strong></label> <span style="color:red;">1.0.1 <i>beta</i></span>&nbsp;
<label><strong>Sua sessão expira em:</strong></label> <label id="horas"><?php echo TEMPO_SESSAO; ?>min:00seg</label>
