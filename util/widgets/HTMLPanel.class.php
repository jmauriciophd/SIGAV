<?php
class HTMLPanel extends HTMLCSS2  {
    private $panel;
    private $id;
    public function __construct($width=300, $height=150,$border=0){
        $this->panel = new HTMLElement("div");
        $this->panel->class="panelLook";
        $this->height      = $height;
        $this->width       = $width;
        $this->borderWidth = $border;
        $this->borderColor = " #CECECE";
        $this->borderStyle = "solid";
        $this->backgroundColor = "#F0F0F0";
        $this->fontSize ="12";
        $this->fontFamily ="Sans Serif";
        $this->top  ="0";
        $this->left ="0";
    }
    /**
     * adiciona um HTMLElement em uma posicao especificada dentro painel
     *
     * @param HTMLElement $child
     * @param int $row
     * @param int $col
     */
    public function appendChild($child,$top=0,$left=0){
        //cria uma div para o elemento filho
        $camada = new HTMLElement("div");
        //define a posicao da camada
        $camada->style ="position:absolute;left:{$left}px;top:{$top}px;padding:0px;margin:0px;border:none;";
        $camada->appendChild($child);
        $this->panel->appendChild($camada);
    }
    private function createLook(){
        $panelStyle =  new HTMLStyle("panelLook");
        $panelStyle->position="relative";
        $panelStyle->width =$this->width."px";
        $panelStyle->height=$this->height."px";
        $panelStyle->left  =$this->left."px";
        $panelStyle->top   =$this->top."px";
        $panelStyle->font_size=$this->fontSize."px";
        $panelStyle->font_family=$this->fontFamily."px";
        $panelStyle->border=$this->borderWidth."px ".$this->borderStyle." ".$this->borderColor .";";
        $panelStyle->background_color=$this->backgroundColor;
        $panelStyle->printOut();
    }
    /**
     * Define a altura e a largura da janela na tela
     *
     * @param integer $width
     * @param integer $height
     */
    public function setSize($width=350,$height=150){
        $this->width = intval($width);
        $this->height=intval($height);
    }
    public  function printOut(){
        $this->createLook();
        $this->panel->printOut();
    }
}

?>