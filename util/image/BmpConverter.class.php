<?php

class BmpConverter extends Image {
	/**
	 * Metodo construtor inicializa os atributos
	 * referentes ao redimensionamento da Imagem passada
	 */
	public function __construct(Image $image){
		$this->addImage($image);
	}
	/**
	 * Configurar o conversor com um objeto Image que deve representar um
	 * recurso de imagem para um tipo diferente
	 *
	 * @param Image $image
	 */
	public function addImage(Image $image){
		$this->recreateStruct($image);
	}

	/**
	 * Cria e exporta a imagem para o arquivo
	 *solicitado
	 * @return boolean
	 */
	public function draw(){
		$this->doOutputResource();
		$defExt="bmp";
		$out =$this->outputFilename;
		$ext = ($out && strtolower(substr($out,-3))=="$defExt") ? substr($out,-4) :".$defExt";
		$out = $this->outputFilename.$ext;
		if(!$this->outputFilename){
			header("Content-Type: image/vnd.wap.wbmp");
			$out = null;
		}
		$this->outputFilename = $out;
		return image2wbmp($this->outImage, $this->outputFilename);
	}
}

?>