<?php

class HTMLInputSelect extends HTMLInput {
    private   $text;
    private   $selected=-1;
    private   $defaultSize;
    private   $isMultiple;


    private  static $innerCounter=0;
    /**
     *
     * @param string $name
     */
    public function HTMLInputSelect($name=null) {
        $this->name     =(is_null($name))? "Select_" . self::$innerCounter : $name ;
        $this->id       = "";
        $this->size     = "";
        $this->maxLength= "";
        $this->isEnabled= "";
        $this->class    = "";
        $this->inputType= 'select ';
        $this->tabIndex = "";
        $this->title    = "" ;
        $this->state    = "";
        $this->defaultSize =10;
        $this->events   = array();
        $this->styles   = array();
        $this->value    = array();
        $this->text     = array() ;
        self::$innerCounter++;
    }
    /**
     * Adiciona um elemento option no Select
     * @return void
     * @param string $value
     * @param string $label
     */
    public function addOption($val=NULL,$text=null) {
        if(is_string($val) && is_string($text) ) {
        //echo $val."dsdsd";
            $this->value[] = $val;
            $this->text[]  = $text;
        }else {
            throw new Exception("Passagem de parâmetro inválida.");
        }

    }
    /**
     * Deve receber uma coleção de objetos ArrayList cujo conteúdo deve ser os valores de
     * de string html option value e text. Este metodo opera junto de  addOption().
     * @param ArrayList $collection
     *
     */
    public function addOptions(Listable $collection,$concat = false) {
        if($collection instanceof Listable ) {
        //percorre o ArrayList realocando e configurando os valores para
        //criacao do componente option do select
            while($collection->hasNext()) {
                $options = $collection->getNext();
                $this->value[] = $options->contentAt(0);
                if($concat==true) {
                    $this->text[]  = $options->contentAt(0) ." - " . $options->contentAt(1);
                }else {
                    if($options->getSize()==2) {
                        $this->text[]  = $options->contentAt(1);
                    }else {
                        $this->text[]  = $options->contentAt(0);
                    }
                }
            }
            $collection=null;
        }else {
            throw new Exception("Parâmetro passado não é um ArrayList.");
        }
    }
    /**
     * Configura o valor de multiplo para o select
     * @param boolean $bool
     * @param integer $size
     */
    public function isMultiple($bool=false, $size=10) {
        $this->name .="[]";
        $this->size = $size;
        $this->isMultiple =$bool;
    }
    /**
     * Recupera o valor, informa se um componente Select terá mais de
     * uma seleção. tornando o select em um List
     */
    private function getMultiple() {
        if($this->isMultiple == true) {
            return " multiple ";
        }
        return " ";
    }

    public function setSize($size=1) {
        $this->size = $size;
    }

    protected  function getSize() {
        if($this->isMultiple == true) {
            return " size=\"".$this->size."\" ";
        }
        return " ";
    }
    /**
     * Determina qual será o index selecionado por padrao
     * @return void
     * @param integer $index;
     */
    public function setSelected($value) {
        if(is_int($value) || is_string($value)) {
            $this->selected = $value ;
    }//else {
    // throw new Exception("Passagem de parâmetro inválido.");
    //}
    }
    /**
     * Recupera o valor do item selecionado
     * @return string
     */
    private function getSelected() {
        if($this->selected >= 0) {
            return $this->selected;
        }else {
            return " ";
        }
    }

    /**
     * Montar dinamicamente os Options recebidos
     *@return string
     */
    private function getOptions() {
        $option="";
        $labelCount = count($this->text);

        for($i=0 ; $i<$labelCount; $i++) {
            if($this->selected == $i || $this->selected==$this->value[$i]) {
                $option.="<option selected value=\"".$this->value[$i]."\">".$this->text[$i]."</option>\n";
            }else {
                $option.="<option value=\"".$this->value[$i]."\">".$this->text[$i]. "</option>\n";
            }
        }
        return $option;
    }
    /**
     * Imprime o componente select na tela.
     * Este componente pode ser usado perfeitamente para formularios
     * montados para Ajax, que passa a receber o componente inteiro dinamicamente
     * fim substituir outro preexistente na tela
     *
     * @return string
     */
    public function printOut() {
        $select= $this->getLabel().
            "<".$this->getInputType().
            $this->getName() .
            $this->getId()   .
            $this->getSize() .
            $this->getMultiple().
            $this->getCSSClass().
            $this->getCSSStyle() .
            $this->getEvents(). ">".
            $this->getOptions() .
            "</". $this->getInputType().">";
        echo $select;
    }
    /**
     * @return string
     */
    public function getOutput() {
        $select= $this->getLabel().
            "<".$this->getInputType().
            $this->getName() .
            $this->getId()   .
            $this->getSize() .
            $this->getMultiple().
            $this->getCSSClass().
            $this->getCSSStyle() .
            $this->getEvents(). ">".
            $this->getOptions() .
            "</". $this->getInputType().">";
        return $select;
    }

}
?>
