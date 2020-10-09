<?php
class PNGImage extends Image{
    /**
     * Metodo construtor inicializa os atributos
     * referentes ao redimensionamento da Imagem passada
     */
	public function __construct($in=NULL,$out=NULL){
        $this->inputFilename  = $in;
        $this->outputFilename = $out;
        parent::__construct();
         
    }
    protected function createImage(){
        $this->image= imagecreatefrompng($this->inputFilename);
    }
    /**
     * Cria e exporta a imagem para o arquivo
     *solicitado
     * @return boolean
     */
    public function draw(){
        $this->doOutputResource();
        if(!$this->outputFilename){
            header("Content-Type: image/png");
        }    
         return imagepng($this->outImage,$this->outputFilename);
    }
}
?>