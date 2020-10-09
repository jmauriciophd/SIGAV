<?php
/**
 * Esta classe representa uma fachada para tratar automaticamente
 * diversos tipos de Imagem. Passado um nome de uma arquivo de entrada
 * ele deverб ser identificado por meio de sua extensгo e serб instanciado um
 * objeto do tipo Image, a partir de agora um Builder (GOF) tratarб de gerenciar os
 * recursos apropriados.
 *@access public
 *@author Gedalias Freitas da Costa
 *@e-mail gedalfc@gmail.com
 *@date 2009-03-29
 */
class ImageManager{
	private $image ;
	private static $pngConverter=NULL;
	private static $jpgConverter=NULL;
	private static $gifConverter=NULL;
	private static $bmpConverter=NULL;
	/**
	 * Instancia um objeto Image automaticamente.
	 *
	 * @param string $in com um nome de arquivo de entrada
	 * @param string $out com um nome de arquivo de entrada
	 */
	public function __construct($in,$out=NULL){
		$file_info = pathinfo($in,PATHINFO_EXTENSION);
		$ext = strtoupper($file_info);
		if($ext =="JPG"){
			$this->image = new JPGImage($in,$out);
		}else if($ext == "PNG"){
			$this->image = new PNGImage($in,$out);
		}else if($ext == "GIF"){
			$this->image = new GIFImage($in,$out);
		}else if($ext == "BMP"){
			$this->image = new BMPImage($in,$out);
		}else{
			throw new ErrorException("Extensгo passada para esta imagem nгo й permitida.\n Imagens permitidas sгo: jpg,png,gif,bmp.");
		}
	}

	/**
	 * Adiociona uma sequencia de texto a posiзгo indicada.
	 * Se nada for dito, serб posicionado em 0,0.
	 *
	 * @param string $text
	 * @param integer $left
	 * @param integer $top
	 */
	public final function addText($text,$left = 10, $top=10){
		$this->image->addText($text, $left, $top);
	}

	public final function setTextRotation($rotation=0){
		$this->image->setTextRotation($rotation);
	}
	/**
	 * Configura um tamanho em pixels para a fonte de texto;
	 *
	 * @param integer $rotation
	 */

	public final function setTextFontSize($size=0){
		$this->image->setTextFontSize($size);
	}
	/**
	 * Descreve um nome diferente para as fontes da biblioteca.
	 *@param string $fontName
	 */
	public final function setTextFontName($fontName=null){
		$this->image->setTextFontName($fontName);
	}
	/**
	 * Descreve um caminho diferente para as fontes da biblioteca.
	 *@param string $fontPath
	 */
	public final function setTextFontPath($fontPath=null){
		$this->image->setTextFontPath($fontPath);
	}
	/** Configura a cor padrao do texto
	 * @return void
	 * @param integer
	 * @param integer
	 * @param integer
	 */
	public final function setTextColor($red=0,$green=0,$blue=0){
		$this->image->setTextColor($red,$green,$blue);
	}

	/**
	 * Retorna um objeto do tipo Image;
	 * @return Image
	 */
	public final function getImage(){
		return $this->image;
	}
	/**
	 * Converte o tipo de imagem passada para BMP
	 */
	public final function saveAsBmp(){
		if(is_null(self::$bmpConverter)){
			self::$bmpConverter = new BmpConverter($this->image);
		}
		$this->drawUsing(self::$bmpConverter);
	}
	/**
	 * Converte o tipo de imagem passada para PNG
	 */
	public final function saveAsPng(){
		if(!self::$pngConverter){
			self::$pngConverter = new PngConverter($this->image);
		}
		$this->drawUsing(self::$pngConverter);

	}
	/**
	 * Converte o tipo de imagem passada para JPG
	 */
	public final function saveAsJpg(){
		if(!self::$jpgConverter){
			self::$jpgConverter = new JpgConverter($this->image);
		}
		$this->drawUsing(self::$jpgConverter);
	}
	/**
	 * Converte o tipo de imagem passada para GIF
	 * @return boolean
	 */
	public final function saveAsGif(){
		if(!self::$gifConverter){
			self::$gifConverter = new GifConverter($this->image);
		}
		$this->drawUsing(self::$gifConverter);
	}
	/**
	 * Passa um oibjeto Image a fim de realizar uma conversao polimуrfica
	 *
	 * @param Image $image
	 */
	private function drawUsing(Image $image){
		$image->addImage($this->image);
		$image->draw();
	}
	/**
	 * Chama o metodo draw() de um objeto Image.
	 */
	public final function draw(){
		return $this->image->draw();
	}
	public final function setQuality($quality){
		$this->image->setQuality($quality);
	}
	/**
	 * Recupera a largura atual da imagem
	 * que serб redimensionada
	 * @return integer
	 */
	public final function getWidth(){
		return $this->image->getWidth();
	}
	/**
	 * O nome do arquivo de saнda.
	 *
	 * @return string
	 */
	public final function getOutputFile(){
		return $this->image->getOutputFile();
	}
	public final function setOutputFile($file){
		$this->image->setOutputFile($file);
	}
	public final function getInputFile(){
		return $this->image->getInputFile();
	}
	/**
	 *Recupera o valor da altura da imagem passada.
	 *@return integer
	 */
	public final function getHeight(){
		return $this->image->getHeight();
	}
	/**
	 *Configura o valor da largura do thumb,
	 *quando nao for especificado, o valor padrao da
	 *imagem serб de 128px;
	 *@return void
	 */
	public final function setNewWidth($width=128){
		$this->image->setNewWidth($width);
	}
	public final function getNewWidth(){
		return $this->image->getNewWidth();
	}
	/**
	 * Chama o metodo draw() de um objeto Image.
	 *
	 */
	public final function save(){
		return 	$this->image->draw();
	}
	/**
	 * Inverte horizontalmente a imagem lida, e somente uma vez.
	 *
	 */
	public final function flipHorizontal(){
		$this->image->flipHorizontal();
	}
	/**
	 * Inverte verticalmente a imagem lida, e somente uma vez.
	 *
	 */
	public final function flipVertical(){
		$this->image->flipVertical();
	}
	/**
	 * Inverte vertical e horizontalmente a imagem lida, e somente uma vez.
	 */
	public final function flipBothVH(){
		$this->image->flipBothVH();
	}
	/**
	 * Inverte vertical e horizontalmente a imagem lida, e somente uma vez.
	 */
	public final function rotationTo($angle){
		$this->image->rotationTo($angle);
	}
	/**
	 * Chama o metodo draw() de um objeto Image.
	 * Usado para uma questгo de compatiblidade com a interface geral de apresentacao;
	 */
	public final function printOut(){
		return $this->image->draw();
	}
	public final function negative(){
		$this->image->doNegative();
	}
	public final function desaturate(){
		$this->image->desaturate();
	}
	public final function setBrightTo($bright=0){
		$this->image->setBrightTo($bright);
	}
	public final function setContrast($contrast){
		$this->image->setContrast($contrast);
	}
	/**
	 *
	 * @param int $red
	 * @param int $green
	 * @param int $blue
	 * @param int $alfa
	 */
	public final function colorize($r=null,$g=null,$b=null,$alfa=null){
		$this->image->colorize($r,$g,$b,$alfa);
	}
	/**
	 * Faz efeito sйpia na imagem.
	 *
	 * @param int $red
	 * @param int $green
	 * @param int $blue
	 */
	public final function sepia($r=100,$g=50,$b=0){
		$this->image->sepia($r,$g,$b);
	}
	public final function detectEdge(){
		$this->image->detectEdge();
	}
	public final function emboss(){
		$this->image->emboss();
	}
	public final function gaussianBlur(){
		$this->image->gaussianBlur();
	}
	public final function blur(){
		$this->image->blur();
	}
	public final function sketch(){
		$this->image->sketch();
	}
	public final function setSmoothness($smooth){
		$this->image-> setSmoothness($smooth);
	}
}
?>