<?php

class PngConverter extends Image {

	/**
	 * Metodo construtor inicializa os atributos
	 * referentes ao redimensionamento da Imagem passada
	 */
	public function __construct(Image $image){
		$this->addImage($image);		
	}
	/**
	 * Enter description here...
	 *
	 * @param Image $image
	 */
	public function addImage(Image $image){
		$this->recreateStruct($image);		
	}
	public function setQuality($quality){
		if(preg_match("/[0-9]/",$quality)){
			$this->quality = $quality;
		}
	}
	/**
	 * Cria e exporta a imagem para o arquivo
	 *solicitado
	 * @return boolean
	 */
	public function draw(){
		$this->doOutputResource();
		$defExt="png";
		$ext = ($this->outputFilename &&  strtolower(substr($this->outputFilename,-3))=="$defExt") ? substr($this->outputFilename,-4) :".$defExt";
		$out = $this->outputFilename.$ext;
		if(!$this->outputFilename){
			header("Content-Type: image/png");
			$out = NULL;
		}
		$this->outputFilename=$out;
		return imagepng($this->outImage,$this->outputFilename,$this->quality,PNG_ALL_FILTERS);
	}
}
?>