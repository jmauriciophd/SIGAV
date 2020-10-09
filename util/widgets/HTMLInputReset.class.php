<?php
/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 *
 */

class HTMLInputReset extends HTMLInput {
    private static $innerCounter=0;
    public function HTMLInputReset($name=null) {
        $this->name = (is_null($name) )? "ResetButton_" . self::$innerCounter: $name ;
        $this->id       ="";
        $this->value    ="Limpar";
        $this->events   =array();
        $this->isEnabled="";
        $this->class    ="";
        $this->styles    ="";
        $this->inputType= 'input type="reset" ';
        $this->tabIndex ="";
        $this->title    ="" ;
        self::$innerCounter++;
    }


}

?>