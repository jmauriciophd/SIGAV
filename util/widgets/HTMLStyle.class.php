<?php
class HTMLStyle {

    private $name ;
    private $properties;
    static private $loaded;

    public function __construct($name) {
        $this->name = $name;
        self::$loaded[$this->name]="";
    }

    public function  __set($attribute, $value) {
    //substitui o "_" por "-" no nome da propriedade;
        $attribute = str_replace('_','-',$attribute);

        //guarda os valores atribuidos ao array properties
        $this->properties["{$attribute}"] = $value;

    }
    /**
     * Exibe a tag na tela
     *
     */
    public function printOut() {
        if(!self::$loaded[$this->name]) {
            echo "<style type='text/css' media='screen'> \n";
            //exibe a abertura do estilo
            echo ".{$this->name}\n";
            echo "{\n";
            if(is_array($this->properties)) {
            //percorre as propriedades
                foreach ($this->properties as $attribute => $value) {
                    echo "\t{$attribute}:{$value};\n";
                }
            }
            echo "}\n";
            echo "</style>\n";
            self::$loaded[$this->name]=true;
        }

    }
    public function getClass() {
        return $this->name;
    }
}
?>