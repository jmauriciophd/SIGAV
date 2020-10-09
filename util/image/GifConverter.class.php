<?php
class GifConverter extends Image {
	/**
	 * Metodo construtor inicializa os atributos
	 * referentes ao redimensionamento da Imagem passada
	 */
	public function __construct(Image $image){
		$this->addImage($image);
	}
	public function addImage(Image $image){
		$this->recreateStruct($image);
	}
	/**
	 * Cria e exporta a imagem para o arquivo solicitado
	 * @return boolean
	 */
	public function draw(){
		$this->doOutputResource();
		$defExt="gif";
		$ext = ($this->outputFilename &&  strtolower(substr($this->outputFilename,-3))=="$defExt") ? substr($this->outputFilename,-4) :".$defExt";
		$out = $this->outputFilename.$ext;
		if(!$this->outputFilename){
			header("Content-Type: image/gif");
			$out=null;
		}
		$this->outputFilename = $out;
		return imagegif($this->outImage,$this->outputFilename);
	}
}

?>