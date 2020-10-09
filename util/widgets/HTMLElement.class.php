<?php
class HTMLElement {
    private $tag;
    private $properties;
    private $children;
    private $openTag;
    private $midTag;
    private $closeTag;


    public function __construct($name) {
    //define o nome do elemento
        $this->tag = $name;
    }

    /**
     * método __set()
     * intercepta as atribuições à propriedades do objeto
     *
     * @param string $name;
     * @param string $value;
     * @return void
     */

    public function __set($name,$value) {
        $this->$name=$value;
        //armazena os valores atribuidos
        //ao array properties
        $this->properties[$name] = $value;
    }

    /**
     * Adciona um elemento filho
     *
     * @param HTMLElement $child
     */
    public function appendChild($child) {
        $this->children[] = $child;
    }

    /**
     * Prepara a abertura da tag
     *
     */
    private function  open() {
        $this->openTag ="<{$this->tag} ";
        if (is_array($this->properties)) {
            $this->midTag=" ";
            foreach ($this->properties as $attribute => $value) {
                $this->midTag .= $attribute . "=\"{$value}\" ";
            }
        }
        $this->closeTag =(is_array($this->children)) ? ">" :"/>";
        echo $this->openTag . $this->midTag . $this->closeTag;

    }

    /**
     * Fecha uma tag HTML
     *
     */
    private function close() {
        echo "</{$this->tag}>\n";
    }

    /**
     * Prepara a abertura da tag
     *
     */
    private function  openTag() {
        $this->openTag ="<{$this->tag} ";
        if (is_array($this->properties)) {
            $this->midTag=" ";
            foreach ($this->properties as $attribute => $value) {
                $this->midTag .= $attribute . "=\"{$value}\" ";
            }
        }
        $this->closeTag =(is_array($this->children)) ? ">" :"/>";
        return $this->openTag . $this->midTag . $this->closeTag."\n";
    }


    /**
     * Fecha uma tag HTML
     *
     */
    private function closeTag() {
        return "</{$this->tag}>\n";
    }
    /**
     * Método que exibe a tag na tela, juntamente com seu conteúdo
     *
     */
    public function printOut() {
        $this->open();
        if(is_array($this->children)) {
            foreach ($this->children as $child) {
                if(is_object($child)) {
                    $child->printOut()	;
                }else if(is_string($child) || is_numeric($child)) {
                    //se representa texto imprimiveis na tela
                        echo $child;
                    }
            }
            $this->close();
        }
    //conclui o fechamento da marca html
    }
    /**
     * Retorna o HTML na forma de uma string ao invés de escrever na saida de dados
     * pro navegador
     *
     * @return string
     */
    public function getOutput() {
        $content="";
        $openTag="";
        $closeTag="";
        $Tag = $this->openTag();
        if(is_array($this->children)) {
            foreach ($this->children as $child) {
                if(is_object($child)) {
                    $Tag .= $child->getOutput();
                }else if(is_string($child) || is_numeric($child)) {
                    //se representa texto imprimiveis na tela
                        $Tag .= $child;
                    }
            }
            $Tag .= $this->closeTag();
        }
        //conclui o fechamento da marca html
        return $Tag;
    }

}
?>
