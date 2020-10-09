<?php
abstract class Image{
	protected $addedText;
	protected $fontPath;
	protected $fontSize;
	protected $fontRotation;
	protected $fontColor=NULL;
	protected $fontName;
	protected $fontConfig=true;
	protected $image ;
	protected $outImage ;
	protected $width;
	protected $height;
	protected $newWidth=null ;
	protected $ratioHeight=null;
	protected $outputFilename;
	protected $inputFilename;
	protected $flip=0;
	protected $quality;

	public function __construct(){
		$this->createImage();
	}
	/**
	 * Recupera a largura atual da imagem
	 * que serс redimensionada
	 * @return integer
	 */
	public final function getWidth(){
		$this->width = imagesx($this->image);
		return $this->width;
	}
	public final function getOutputFile(){
		return $this->outputFilename;
	}
	/**
	 * Enter description here...
	 *
	 * @param string $file
	 */
	public final function setOutputFile($file){
		$this->outputFilename = $file;
	}
	public final function getInputFile(){
		return $this->inputFilename;
	}

	public final function getImage(){
		return $this->image;
	}

	/**
	 *Recupera o valor da altura da imagem passada.
	 *@return integer
	 */
	public final function getHeight(){
		$this->height = imagesy($this->image);
		return $this->height;
	}
	/**
	 *Configura o valor da largura do thumb,
	 *quando nao for especificado, o valor padrao da
	 *imagem serс de 128px;
	 *@return void
	 */
	public final function setNewWidth($width=128){
		$this->newWidth = $width;
	}
	public final function getNewWidth(){
		return $this->newWidth;
	}

	/**
	 *Calcula o valor da razao entre a altura e a largura
	 *da imagem, assim, somente щ necessсrio informar a largura
	 *e calcula-se a altura proporcional.
	 *O objetivo disto щ evitar que haja distorчуo na imagem do thumb
	 *@return float
	 */
	protected final function getRatio(){
		$this->newWidth = (is_null($this->newWidth)) ? $this->getWidth() : $this->newWidth;
		$ratio = ($this->getWidth()/$this->getHeight());
		$this->ratioHeight = $this->newWidth/$ratio;
		return $this->ratioHeight;
	}
	/**
	 * Inverte horizontalmente a imagem lida, e somente uma vez.
	 *
	 */
	public final function flipHorizontal(){
		$this->flip = 1;
	}
	/**
	 * Inverte verticalmente a imagem lida, e somente uma vez.
	 *
	 */
	public final function flipVertical(){
		$this->flip = 2;
	}
	/**
	 * Inverte vertical e horizontalmente a imagem lida, e somente uma vez.
	 */
	public final function flipBothVH(){
		$this->flip = 3;
	}
	/**
	 * Inverte vertical e horizontalmente a imagem lida, e somente uma vez.
	 */
	public final function rotationTo($angle){
		$angle = ($angle > 360) ? 0: $angle;
		imagerotate($this->image,$angle,0,-1);
	}
	//Este metodo prepara as classes concretas derivadas com as informacoes de
	//saida da imagem final.
	protected final function doOutputResource(){
		$yOrigin= $xOrigin = 0;
		$height = $this->getHeight();
		$width  = $this->getWidth();
		switch ($this->flip) {
			case 1:
				$xOrigin= $this->getWidth();
				$width  = -($this->getWidth());
				break;
			case 2:
				$yOrigin= $this->getHeight();
				$height = -($this->getHeight());
				break;
			case 3:
				$yOrigin= $this->getHeight();
				$height = -($this->getHeight());
				$xOrigin= $this->getWidth();
				$width  = -($this->getWidth());
				break;
			default:
				break;
		}

		$this->getRatio();
		$this->outImage = imagecreatetruecolor($this->newWidth,$this->ratioHeight);
		$this->doOutputText();
		imagecopyresampled($this->outImage,$this->image,0,0,$xOrigin,$yOrigin,$this->newWidth,$this->ratioHeight,$width,$height);
		imagecolorallocatealpha($this->outImage,0,0,0,127);

		// imagealphablending($this->outImage, false);
		// imagesavealpha($this->outImage, true);
	}
	/**
	 * Formata o texto de saida
	 *@return void;
	 */
	protected function doOutputText(){
		$this->fontPath = dirname(__FILE__);
		$this->fontPath = substr($this->fontPath,0,strrpos($this->fontPath,"/"));
		if(PHP_OS =="Linux" && $this->fontConfig==true){
			$this->fontPath = $this->fontPath."/ttflinux/";
			$this->fontName = "dejavusansmono.ttf";
		}else if(PHP_OS =="Windows" && $this->fontConfig==true){
			$this->fontPath = $this->fontPath."/ttfwindows/";
			$this->fontName = "arial.ttf";
		}
		$this->fontSize=(!$this->fontSize) ? 22 : $this->fontSize;
		$this->fontRotation=(!$this->fontRotation) ? 0 : $this->fontRotation;
		if(!$this->fontColor){
			$this->fontColor = imagecolorallocate($this->image,0,0,0);
		}
		$this->fontName = $this->fontPath . $this->fontName;
		if(is_array($this->addedText)){
			foreach ($this->addedText as $doSomething){
				$x = $doSomething["x"];
				$y = $doSomething["y"];
				$t = $doSomething["text"];
				imagettftext($this->image,$this->fontSize,$this->fontRotation,$x,$y,$this->fontColor,$this->fontName,$t);
			}
		}
	}
	/**
	 * TODO Documentar
	 *
	 */
	public final function doNegative(){
		imagefilter($this->image, IMG_FILTER_NEGATE);
	}
	public final function desaturate(){
		imagefilter($this->image, IMG_FILTER_GRAYSCALE);
	}
	public final function sepia($r=100,$g=50,$b=0){
		$r=($r>255)?100:$r;
		$g=($g>255)?50:$g;
		$b=($b>255)?0:$b;
		imagefilter($this->image, IMG_FILTER_GRAYSCALE);
		imagefilter($this->image,IMG_FILTER_COLORIZE,$r,$g,$b);
	}
	public final function setBrightTo($bright=0){
		$bright=($bright>255)?255:$bright;
		imagefilter($this->image, IMG_FILTER_BRIGHTNESS,$bright);
	}
	public final function setContrast($contrast){
		imagefilter($this->image,IMG_FILTER_CONTRAST,$contrast);
	}
	public final function colorize($r=null,$g=null,$b=null,$alfa=null){
		$r=($r>255)?255:$r;
		$g=($g>255)?255:$g;
		$b=($b>255)?255:$b;
		$alfa=($alfa>127)?127:$alfa;
		imagefilter($this->image,IMG_FILTER_COLORIZE,$r,$g,$b,$alfa);
	}
	public final function detectEdge(){
		imagefilter($this->image,IMG_FILTER_EDGEDETECT);
	}
	public final function emboss(){
		imagefilter($this->image,IMG_FILTER_EMBOSS);
	}
	public final function gaussianBlur(){
		imagefilter($this->image,IMG_FILTER_GAUSSIAN_BLUR);
	}
	public final function blur(){
		imagefilter($this->image,IMG_FILTER_SELECTIVE_BLUR);
	}
	public final function sketch(){
		imagefilter($this->image,IMG_FILTER_MEAN_REMOVAL);
	}
	public final function setSmoothness($smooth){
		imagefilter($this->image,IMG_FILTER_SMOOTH, $smooth);
	}
	/**
	 * Adiciona um texto a image na coordenada indicada, se nada for dito
	 * o texto serс renderizado na posicao 10,10.
	 * @return void
	 * @param string $text
	 * @param integer $x
	 * @param integer $y
	 */
	public function addText($text="",$x=10,$y=10){
		$fontAdded["x"] = $x;
		$fontAdded["y"] = $y;
		$fontAdded["text"] = $text;
		$this->addedText[] = $fontAdded;
		//evita que se sistema fique alterando as fontes
		$this->fontConfig=false;
	}
	/**
	 * Configura a cor padrao do texto
	 * @return void
	 * @param integer
	 * @param integer
	 * @param integer
	 */
	public function setTextColor($red=0,$green=0,$blue=0){
		$this->fontColor = imagecolorallocate($this->image, $red,$green,$blue);
	}
	/**
	 * TODO Documentar
	 *
	 * @param float $rotation
	 */
	public function setTextRotation($rotation=0){
		if(is_numeric($rotation)){
			$this->fontRotation=$rotation;
		}else{
			throw new Exception("O valor da rotaчуo de texto precisa ser numщrico em setTextRotation();");
		}
	}
	/**
	 * Configura um tamanho em pixels para a fonte de texto;
	 *
	 * @param integer $rotation
	 */
	public function setTextFontSize($size=22){
		if(is_integer($size)){
			$this->fontSize=$size;
		}else{
			throw new Exception("O tamanho da fonte de texto precisa ser um inteiro em setTextFontSize();");
		}
	}
	/**
	 * Descreve um caminho diferente para as fontes da biblioteca.
	 *@param string $fontPath
	 */
	public function setTextFontPath($fontPath=null){
		$this->fontPath = $fontPath;
		//diz pro sistema se auto-configurar.
		$this->fontConfig=false;
	}
	/**
	 * Descreve um nome diferente para as fontes da biblioteca.
	 *@param string $fontName
	 */
	public function setTextFontName($fontName=null){
		$this->fontName = $fontName;
	}
	/**
	 *Passa as informaчѕes referentes ao texto adicionado a imagem original
	 *para que seja devidamente apresenta tal qual na original.
	 *
	 * @return array
	 */
	public function getAddedText(){
		return $this->addedText;
	}
	public function getFontResource(){
		$fontResource =array();
		$fontResource["color"] = $this->fontColor;
		$fontResource["size"]  = $this->fontSize;
		$fontResource["name"]  = $this->fontName;
		$fontResource["path"]  = $this->fontPath;
		$fontResource["rotation"] = $this->fontRotation;
		return $fontResource;
	}
	/**
	 * TODO DOCUMENTAR
	 *
	 * @param Image $image
	 */
	protected function recreateStruct(Image $image){
		$this->image        = $image->getImage();
		$this->outputFilename= $image->getOutputFile();
		$this->width        =$image->getWidth();
		$this->newWidth     = $image->getNewWidth();
		$this->addedText    = $image->getAddedText();
		$fontResource=$image->getFontResource();
		$this->fontColor    = $fontResource["color"] ;
		$this->fontSize     = $fontResource["size"]  ;
		$this->fontName     = $fontResource["name"] ;
		$this->fontRotation = $fontResource["rotation"];
		$this->fontPath     = $fontResource["path"];
	}
	protected function createImage(){}
	//Altera a interface das classes concretas a de poder criar uma fachada
	public function addImage(Image $img){}
	//compatibiliza a interface para evitar erros a chamada de mщtodos
	public function setQuality($quality){}
	abstract public function draw();
}
?>