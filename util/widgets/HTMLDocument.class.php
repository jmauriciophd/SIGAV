<?php
/**
 * Classe que representa todo o documento raiz de um documento HTML
 *
 */
class HTMLDocument {
    private $documentRoot;
    public function HTMLDocument() {
        $this->documentRoot = new HTMLElement("html");

    }

    public function appendChild(HTMLElement $child){
        $this->documentRoot->appendChild($child);
    }
    /**
     * @return  void
     */
    public  function printOut(){
        $this->documentRoot->printOut();
    }
    /**
     * Retorna o HTML na forma de uma string ao invés de escrever na saida de dados
     * pro navegador
     *
     * @return string
     */
    public  function getOutput(){
        $this->documentRoot->getOutput();
    }

}

?>