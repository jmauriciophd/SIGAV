<?php
/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 *  
 */
class HTMLInputText extends HTMLInput {
    private static  $innerCounter=0;
    public function HTMLInputText($name=null) {
        $this->name     =$name;
        $this->id       ="";
        $this->value    ="";
        $this->size     ="";
        $this->maxLength="";
        $this->events   =array();
        $this->isEnabled="";
        $this->class    ="";
        $this->style    ="";
        $this->inputType= 'input type="text" ';
        $this->tabIndex ="";
        $this->title    ="" ;
        $this->readonly ="";
        self::$innerCounter++;
    }
}

?>