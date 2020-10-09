<?php
class HTMLTitle extends HTMLElement {
    //configuracao interna de dados
    /**
     * 
     *
     * @param string $title
     */
    public function  __construct($title="") {
        parent::__construct("title");
        $this->appendChild($title);
    }
    /**
     * Adiciona um texto ao título
     *
     * @param string $title
     */
    public function setTitle($title){
        $this->appendChild($title);
    }
}

?>