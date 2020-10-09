<?php
ini_set("default_charset","iso-8859-1");
header("Content-Type: text/html; charset=iso-8859-1", true);
$diretorio = getDiretorio();
$pathSeparator = getPathSeparator();
$base_dir = get_include_path();

//ler os diretorios do sistema
lerDiretorio($diretorio, $pathSeparator);

$diretorio->close();

//set_include_path("$base_dir");//5.1
ini_set("include_path","$base_dir"); //****
ini_set("default_charset","iso-8859-1"); //****

function getDiretorio(){
	return dir(dirname(__FILE__)."/");
}

function getPathSeparator(){
	return (PHP_OS=="Linux") ? ":" : ";";
}

function lerDiretorio($diretorio, $pathSeparator){
	global $base_dir;
	while (false !== ($entry = $diretorio->read())) {
		if(strpos($entry, ".")===false && strpos($entry, "_")===false){
			$base_dir .= $pathSeparator.$diretorio->path.$entry;
			$subdiretorio = dir($diretorio->path.$entry."/");
			lerDiretorio($subdiretorio, $pathSeparator);
		}
	}
}

function __autoload($classname){
	require_once( $classname . ".class.php");
}

require_once 'config/erros/unhandledException.php';


?>