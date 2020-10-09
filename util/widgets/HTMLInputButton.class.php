<?php
/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 *
 */

class HTMLInputButton extends HTMLInput {

    private static $innerCounter=0;

    public function HTMLInputButton($name=null) {
        $this->name = (is_null($name) )? "Button_" . self::$innerCounter : $name ;
        $this->id       ="";
        $this->value    ="";
        $this->size     ="";
        $this->class    =" ";
        $this->styles   =array();
        $this->events   =array();
        $this->title    ="";
        $this->tabIndex ="";
        $this->inputType= "input type=\"button\" ";
        $this->title    ="" ;
        self::$innerCounter++;
    }

	/**
	 * Um Elemento Button devidamente configurado.
	 * @return string
	 *
	 */
    public function printOut() {
        $out = "<" .
            $this->getInputType() .
            $this->getName()      .
            $this->getId()        .
            $this->getValue()     .
            $this->getTitle()     .
            $this->getTabIndex()  .
            $this->getCSSClass()  .
            $this->getCSSStyle()  .
            $this->getEvents()    .
            $this->getEnabled()   .
            "/>\n";
        echo $out;
    }

    public function getOutput() {
        $out = "<" .
            $this->getInputType() .
            $this->getName()      .
            $this->getId()        .
            $this->getValue()     .
            $this->getTitle()     .
            $this->getTabIndex()  .
            $this->getCSSClass()  .
            $this->getCSSStyle()  .
            $this->getEvents()    .
            $this->getEnabled()   .
            "/>\n";
        return $out;
    }
}



?>