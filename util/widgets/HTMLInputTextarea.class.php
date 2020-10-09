<?php
/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 *TODO
 */

class HTMLInputTextarea extends HTMLInput {
    private static $innerCounter=0;
    private $rows;
    private $cols;
    private $wrapped;
    private $fulltext;
    /**
     * @param string $name
     */
    public function HTMLInputTextarea($name) {
        $this->name = (is_null($name) )? "TextArea_" . self::$innerCounter : $name ;
        $this->id       = "";
        $this->value    = "";
        $this->events   = array();
        $this->isEnabled= "";
        $this->rows     =" rows=\"5\" ";
        $this->cols     =" cols=\"25\" ";
        $this->class    = "";
        $this->style    = "";
        $this->inputType= 'Textarea ';
        $this->tabIndex = "";
        $this->title    = "" ;
        $this->fulltext = array();
        $this->readonly = "" ;
        $this->label = (is_null($name) )? "<br>TextField_" . self::$innerCounter."<br>" : $name ;
        self::$innerCounter++;
    }
    /**
     *@return void
     * @param string rows
     */
    public function setRows($rows=null) {
        if(is_string($rows) || is_int($rows)) {
            $this->rows =" rows=\"".$rows."\" ";
        }else {
            throw new Exception("Passagem de parâmetro inválido no método setRows() de HTMLInputTextarea");
        }
    }
    /**
     * @return string
     */
    public function getRows() {
        return $this->rows;
    }
    /**
     * @param string $cols
     */
    public function setCols($cols) {
        if(is_string($cols) || is_int($cols)) {
            $this->cols =" cols=\"".$cols."\" ";
        }else {
            throw new Exception("Passagem de parâmetro inválido no método setCols() de HTMLInputTextarea");
        }
    }
    /**
     * @return string
     */
    public function getCols() {
        return $this->cols;
    }
    /**
     * adiciona um texto sequencialmente ao HTMLInputTextarea
     * e pode ser reescrita para inserir texto em qualquer posicao
     * dentro do compenente. Este componente está sendo elaborado para
     * uso com Ajax, logo se aperfeiçoamento trará grandes beneficios.
     * @param string $text
     */

    public function addText($text=null) {
        if(is_string($text)) {
            $this->fulltext[] = $text;
        }else {
            throw new Exception("Passagem de parâmetro inválido no método addText() de HTMLInputTextarea");
        }
    }

    /**
     * @return string
     * TODO:verificar este metodo e testar todo o componente
     */
    private function getText() {
        $textLength = count($this->fulltext);
        $localtext  ="";
        //$this->text ="";
        if(is_array($this->fulltext) && $textLength>0) {
            foreach ($this->fulltext as $text) {
                $localtext .= $text ." " ;
            }

        }
        return trim($localtext);
    }

    /**
     *
     * @return  string
     */
    public function printOut() {
        $textarea= $this->getLabel().
            "<".$this->getInputType().
            $this->getName()    .
            $this->getId()      .
            $this->getCols()    .
            $this->getRows()    .
            $this->getCSSClass().
            $this->getCSSStyle().
            $this->getEvents()  .
            $this->getTitle()   .
            $this->getReadOnly(). ">".
            $this->getText()    .
            "</". $this->getInputType().">";
        echo $textarea;
    }
    public function getOutput() {
        $textarea= $this->getLabel().
            "<".$this->getInputType().
            $this->getName()    .
            $this->getId()      .
            $this->getCols()    .
            $this->getRows()    .
            $this->getCSSClass().
            $this->getCSSStyle().
            $this->getEvents()  .
            $this->getTitle()   .
            $this->getReadOnly(). ">".
            $this->getText()    .
            "</". $this->getInputType().">";
        echo $textarea;
    }
}

?>