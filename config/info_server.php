<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Informações do Servidor</title>
</head>
<body>
<h1>Informações do Servidor</h1>
<?php
print_r(iconv_get_encoding());

foreach($_SERVER  as $indice => $valor){
echo $indice." = ".$valor."<br>";
}

echo "<hr>".$_SERVER["DOCUMENT_ROOT"]."seguranca.php";

?>
</body>
</html>
