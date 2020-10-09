<div id="inicial">
<?php
require_once "../../../libloader.php";
LoginController::verficaAutenticidadeUsuario();
$nome = (isset($_SESSION["NOME_USUARIO"])) ? $_SESSION["NOME_USUARIO"] : "";
?>
<p><br/></p><p></p>
<div id="logo_sigav">
<img src="../../img/banners/LogoInicial.png" alt="Logo Sigav" class="logosigav" />
</div>
</div>