<?php

class JpgConverter extends Image {
	/**
	 * Metodo construtor inicializa os atributos
	 * referentes ao redimensionamento da Imagem passada
	 */
	public function __construct(Image $image){
		$this->addImage($image); 
	}
	/**
	 * TODO Documentar
	 *
	 * @param Image $image
	 */
	public function addImage(Image $image){
		$this->recreateStruct($image);
		$this->quality=100;
	}
	/**
	 * TODO documentar
	 *
	 * @param integer $quality
	 */
	public function setQuality($quality){
		if(is_integer($quality) && $quality>0 && $quality <=100){
			$this->quality=$quality;
		}
	}
	/**
	 * Cria e exporta a imagem para o arquivo solicitado
	 * @return boolean
	 */
	public function draw(){
		$this->doOutputResource();
		$defExt="jpg";
		$ext = ($this->outputFilename &&  strtolower(substr($this->outputFilename,-3))=="$defExt") ? substr($this->outputFilename,-4) :".$defExt"; 
		$out = $this->outputFilename.$ext;
		if(!$this->outputFilename){
			header("Content-Type: image/jpeg");
			$out = null;
		}
		$this->outputFilename =$out;
		return imagejpeg($this->outImage,$this->outputFilename,$this->quality);
	}
}

?>