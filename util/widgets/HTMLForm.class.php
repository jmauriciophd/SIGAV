<?php

/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 *FIXME
 *
 */
class HTMLForm {
    private   $elements;
    private   $events;
    private   $class;
    private   $style;
    private   $action;
    private   $enctype;
    private   $innerCounter;
    private   $method;
    public function HTMLForm() {
        $this->elements = array();
        $this->innerCounter = 0 ;
        $this->enctype="enctype=\"application/x-www-form-urlencoded \"" ;

    }
    /**
     * Configura o atributo action do formulário (que representa aquele que vai analizar o
     * o conteúdo do formulário)
     * Por padrão configura a própria página onde reside o formulário.
     *
     * @param string $action
     */
    public function  setAction($action) {
        if(is_string($action)) {
            $this->action = $action;
        }else {
            throw new Exception("Atributo incorreto. Deve ser uma String.");
        }

    }
    /**
     * Recupera o valor do atributo Action
     *
     * @return string
     */
    private function getAction() {
        if(strlen($this->action) > 0 ) {
            return ' action="'. $this->action .'" ';
        }else {
            return '';
        }

    }
    /**
     * Recupera os valores armazenados no array de strings
     * @return string
     *
     */
    private function getEvents() {
        $events=" ";
        if(is_array($this->events) && count($this->events) > 0) {
            foreach ($this->events as $event=>$func) {
                $events.=$event.'="'.$func.'" '  ;
            }
        }
        return $events;
    }
    /**
     * Adiciona cada HTMLInput instanciado ao Formulario HTML
     *
     * @param HTMLInput $element
     */
    public function addElement(HTMLInput $element) {
        if($element instanceof HTMLInput) {
            if($element instanceof HTMLInputFile ) {
                $this->enctype = " enctype=\"multipart/form-data\"" ;
            }
            $this->elements[$this->innerCounter++] = $element;
        }else {
            throw  new Exception("O parâmetro passado nao é um HTMLInput.");
        }

    }


    /**
     * Adiciona um evento e suas respectivas lista de métodos
     * javascript
     *
     * @param string $eventName
     * @param string $functions
     */
    public function addEvents($event,$funcList) {
        if(is_string($event) && is_string($funcList)) {
        //acrescenta uma quantidade ilimitada de metodos javascript
            if (array_key_exists($event,$this->events)) {
                $funcList.= ";". $this->events[$event];
            }
            $this->events[$event] = $funcList;
        }
    }
    public function hasBorder($bool=false) {

    }

    /**
     * Percorre todos os elementos internos passados para
     * @return string
     */
    public function printOut() {
        echo "<FORM" .$this->getAction(). $this->getEvents(). $this->enctype. ">";
        foreach ($this->elements as $key=>$value) {
            $value->printOut();
        }
        echo "</FORM>";
    }

}

?>
