<?php
class BMPImage extends Image{
    /**
     * Metodo construtor inicializa os atributos
     * referentes ao redimensionamento da Imagem passada
     *
     */
	public function __construct($in=NULL,$out=NULL){
        $this->inputFilename  = $in;
        $this->outputFilename = $out;
        parent::__construct();
    }

    protected function createImage(){
        $this->image= imagecreatefromwbmp($this->inputFilename);
    }
    /**
     * Cria e exporta a imagem para o arquivo
     *solicitado
     * @return boolean
     */
    public function draw(){
        $this->doOutputResource();
        if(!$this->outputFilename){
            header("Content-Type: image/vnd.wap.wbmp");
        }
        return image2wbmp($this->outImage,$this->outputFilename);
    }
}
?>