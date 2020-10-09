<?php
class Upload
{
	
	public function salvar($imagem, $largura, $pasta){
		if($imagem['type']=="image/jpeg" || $imagem['type']=="image/gif" || $imagem['type']=="image/png"){
			$name = $imagem['name']; //md5(uniqid(rand(),true));
			echo $name;
			if ($imagem['type']=="image/jpeg"){
				$img = imagecreatefromjpeg($imagem['tmp_name']);
			}else if ($imagem['type']=="image/gif"){
				$img = imagecreatefromgif($imagem['tmp_name']);
			}else if ($imagem['type']=="image/png"){
				$img = imagecreatefrompng($imagem['tmp_name']);
			}else {
				$img = imagecreatefromjpeg($imagem['tmp_name']);
			}
			$x   = imagesx($img);
			$y   = imagesy($img);
			$autura = ($largura * $y)/$x;
			
			$nova = imagecreatetruecolor($largura, $autura);
			imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $autura, $x, $y);
			
			$local="$pasta/$name";
			imagejpeg($nova, $local);
			
			imagedestroy($img);
			imagedestroy($nova);	
			
			return true;
		} else{
			echo "Formato de arquivo inválido!";
			return false;
		}
		
	}
}
?>