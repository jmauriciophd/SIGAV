<?php
require_once "../libloader.php";

$loginController = new LoginController();
$loginController->logout(true);
?>