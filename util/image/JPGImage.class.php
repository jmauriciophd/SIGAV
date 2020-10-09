<?php
class JPGImage extends Image{    
    /**
     * Metodo construtor inicializa os atributos
     * referentes ao redimensionamento da Imagem passada
     *
     */
    public function __construct($in=NULL,$out=NULL){
        $this->inputFilename  = $in;
        $this->outputFilename = $out;        
        parent::__construct();
        $this->quality = 100;
    }
    protected function createImage(){        
        $this->image = imagecreatefromjpeg($this->inputFilename);                
    }
    /**
     * Recebe um valor inteiro como parametro que deve variar entre
     * 1 e 100
     *
     * @param integer $quality
     * @return void
     */
    public function setQuality($quality){
        if(is_integer($quality) && $quality>0 && $quality <=100){
            $this->quality=$quality;
        }
    }
    /**
     * Cria e exporta a imagem para o arquivo
     *solicitado
     * @return blob
     */
    public function draw(){
        $this->doOutputResource();
        if(!$this->outputFilename){
            header("Content-Type: image/jpeg");
        }
         return imagejpeg($this->outImage,$this->outputFilename,$this->quality);
    }    
}
?>