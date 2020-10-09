<?php
class HTMLWindow {
    private $top;
    private $left;
    private $width;
    private $height;
    private $title;
    private $content;
    private $icon ;
    private $titleAlign;
    private $closeIcon;
    private static $counter=0;
    /**
     * Constroi uma janela para receber elementos de tela
     *
     * @param string $title
     * @param int $width
     * @param int $height
     */
    public function __construct($title="",$width=350,$height=100) {
        $this->title ="$title";
        $this->width =intval($width)  ;
        $this->height=intval($height) ;
        $this->titleAlign ="left";
        $this->closeIcon = new HTMLImage("../phplib/icons/closing.png");
    }
    /**
     * Define a linha e a coluna em pixel para o posicionamento da janela
     *
     * @param integer $top
     * @param integer $left
     */
    public function setPosition($top,$left) {
        $this->top=intval($top);
        $this->left=intval($left);
    }
    /**
     * Define a altura e a largura da janela na tela
     *
     * @param integer $width
     * @param integer $height
     */
    public function setSize($width=350,$height=150) {
        $this->width = intval($width);
        $this->height=intval($height);
    }
    public function getWidth() {
        return $this->width;
    }
    public function getHeight() {
        return $this->height;
    }
    
    /**
     * adiciona um HTMLElement dentro da janela
     *
     * @param HTMLElement $child
     */
    public function appendChild($child) {
        $this->content = $child;
    }

    public function printOut() {
        $windowId = "HTMLWindow".self::$counter++;
        $this->createLook($windowId);

        $window = new HTMLElement("div");
        $window->id = $windowId;
        $window->style="position: absolute; left:".$this->left."px; top: ".$this->top."px;";
        $window->class = $windowId;

        $innerTable = new HTMLTable();
        //$innerTable->border="1";
        $innerTable->cellspacing="0";
        $innerTable->cellpadding="0";
        $innerTable->style="width:100%;height:100%;border-collapse:collapse;position:absolute;top:0px;left:0px";

        $titleRow = $innerTable->insertRow();
        //--------------------------------------------------------
        //Insere um icone no canto esquerdo da janela
        if($this->icon) {
            $iconCol = $titleRow->insertCell($this->icon->getOutput());
        }else {
            $iconCol = $titleRow->insertCell("&nbsp;");
        }
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $titleCol = $titleRow->insertCell($this->title);
        $titleCol->onmousedown="Dragger(document.getElementById('$windowId'),event);";
        $titleWidth = $this->width-92;

        //***********************************************************
        if($this->closeIcon) {
            $this->closeIcon->onclick ="document.body.removeChild(document.getElementById('$windowId')); ";
            $buttonsCol = $titleRow->insertCell($this->closeIcon->getOutput());
        }else {
            $buttonsCol = $titleRow->insertCell("");
        }
        //*****************************
        //Visual da barra de titulo
        //*****************************
        $iconCol->style="background-image:url('../phplib/icons/title-bar-left.png');
		                    vertical-align:middle;
		                    text-align:center;
		                    width:26px";
        $buttonsCol->style="background-image:url('../phplib/icons/title-bar-right.png');
		                    text-align:right;
		                    padding-right:2px; 
		                    width:40px;
		                    margin:0px";
        $titleCol->style ="background-image:url('../phplib/icons/title-bar-middle.png');
		                   height:26px; 
		                   font-size:14px;	
		                   color:#4F576C;
		                   font-family:Sans Serif;
		                   text-align:" .$this->titleAlign. ";width:{$titleWidth}px";

        $bodyRow = $innerTable->insertRow();
        $contentCell = $bodyRow->insertCell($this->content);
        $contentCell->colspan ="3";
        $window->appendChild($innerTable);
        $script = new HTMLScript("../phplib/jscore/Dragger.js");
        $script->printOut();
        $window->printOut();
    }

    public function settTitleIcon($src) {
        $this->icon = new HTMLImage($src);
    }
    public function setClosingIcon($src) {
        $this->closeIcon = new HTMLImage($src);
    }

    /**
     * Enter description here...
     *
     * @param string $align
     */
    public function setTitleAlign($align) {
        $this->titleAlign = $align;
    }
    /**
     * Enter description here...
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     *
     *
     * @param string $class
     */
    private function createLook($class) {
        $style =  new HTMLStyle("$class");
        $style->width=$this->width+6 ."px";
        $style->height=$this->height+ 46 . "px";
        $style->border_top   ="0px outset #ADBCC7";
        $style->border_right ="2px inset #ADBCC7";
        $style->border_bottom="2px inset #CBD5EE";
        $style->border_left  ="2px outset #CBD5EE";
        $style->background_color="#F7F7F7";
        $style->z_index=self::$counter + "100000";
        $style->printOut();
    }

}

?>