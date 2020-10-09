<?php
/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 *
 */
abstract class HTMLInput {
    protected $name;
    protected $id;
    protected $value;
    protected $size;
    protected $maxLength;
    protected $events;
    protected $isEnabled;
    protected $class;
    protected $styles;
    protected $inputType;
    protected $tabIndex;
    protected $title ;
    protected $label;
    protected $readonly;
    protected static $eventList=array();

    private function checkEvent($event) {
        $event = strtolower($event);
        self::$eventList["click"] = "onclick";
        self::$eventList["mouseover"] = "onmouseover";
        self::$eventList["mousemove"] = "onmousemove";
        self::$eventList["mouseout"]  = "onmouseout";
        self::$eventList["mousedown"] = "onmousedown";
        self::$eventList["mouseup"]   = "onmouseup";
        self::$eventList["keyup"]     = "onkeyup";
        self::$eventList["keydown"]   = "onkeydown";
        self::$eventList["keypress"]  = "onkeypress";
        self::$eventList["blur"]      = "onblur";
        self::$eventList["change"]    = "onchange";
        self::$eventList["dblclick"]  = "ondblclick";
        self::$eventList["focus"]     = "onfocus";
        self::$eventList["help"]      = "onhelp";
        self::$eventList["select"]    = "onselect";

        if(array_key_exists($event,self::$eventList)  ||
            array_search($event,self::$eventList,true)) {
            return true;
        }
        return false;

    }

    /**
     * Configura o rótulo do componente...
     *
     * @param string $label
     * @param bool $bool
     */
    public function setLabel($label,$bool=false) {
        $break = ($bool == true) ? "<br>": "&nbsp;&nbsp;";
        if(is_string($label)) {
            $this->label = $label . $break ;
        }else {
            throw  new Exception("O parâmetro passado é inválido.");
        }
    }
    /**
     * Restaura o valor de uma sequncia passad
     *
     * @return string
     */
    protected function getLabel() {
        if(is_string($this->label) && strlen($this->label) > 2) {
            return $this->label;
        }
    }

    /**
     * Configura o valor do atributo Value de um elemento
     * de formulário HTML
     *
     * @return void
     * @param string $value
     */
    public function setValue($value=null) {
        $this->value = $value ;
    }
    /**
     * Recupera o valor do atributo value do componente
     * @return string
     *
     */
    protected function getValue() {
        if(is_string($this->value) && strlen($this->value) >0) {
            return " value='{$this->value}'";
        }
        return null;
    }

    /**
     * Recebe um string contendo o nome do elemento
     *
     * @param string $nome
     */
    public function setName($name=null) {
        if(is_string($name)) {
            $this->name = $name;
        }else {
            throw new Exception("Atributo NAME inválido.");
        }
    }
    /**
     * Recupera o nome do elemento de formulario
     *
     * @return string
     */
    protected function getName() {
        if(strlen($this->name) > 0 ) {
            $this->name = (strlen($this->id) <=0) ? 'name="' .$this->name . '" id="'. $this->name . '" ': " name=\"". $this->name ."\" " ;
        }
        return $this->name;
    }
    /**
     * Configura o atributo maxLength de um eleento de
     * Formulário HTML
     *
     * @param string $maxLength
     */
    public function setMaxLength($maxLength) {
        if(is_string($maxLength) || is_int($maxLength)) {
            $this->maxLength = $maxLength;
        }else {
            throw new Exception("Passagem de parâmetro inválido.");
        }
    }
    /**
     *Restaura o parâmetro
     * @return string
     */
    protected function getMaxLength() {
        if($this->maxLength > 0) {
            return	" maxlength=\"". $this->maxLength ."\"";
        }
        return " ";

    }
    /**
     * Configura o parâmetro HTML size de um componente
     * de Formulário HTML.
     *
     * @param string $size
     */
    public function setSize($size) {
        if(is_string($size) || is_int($size) ) {
            $this->size = $size;
        }else {
            throw new Exception("Passagem de parâmetro inválido.");
        }
    }
    /**
     * Descreve o atributo size do elemento de Formulário
     * tem comportamento diferenciado de acordo com
     * o tipo de elemento.
     *
     * @return string
     */
    protected function getSize() {
        if(strlen($this->size) > 0) {
            return " size=\"" . $this->size ."\" ";
        }
        return " ";
    }
    /**
     * Configuração dos atributos de strings de eventos.
     * @param string $event
     * @param string $funcList
     */
    public function addEvent($event,$funcList) {
        if($this->checkEvent($event)) {
            if(is_string($event) && is_string($funcList)) {
            //acrescenta uma quantidade ilimitada de metodos javascript
                if (array_key_exists($event,$this->events)) {
                    $funcList.= ";". $this->events[$event];
                }
                $this->events[$event] = $funcList;
            }
        }else {
            throw new Exception("Evento passado para componente é inválido.");
        }
    }
    /**
     * Recupera os metodos de javascript passados para o componente
     * @return string
     */
    protected function getEvents() {
        $events=" ";
        if(is_array($this->events) && count($this->events) > 0) {
            foreach ($this->events as $event=>$func) {
                $events.=$event.'="'.$func.'" '  ;
            }
        }
        return $events;
    }
    /**
     * Configura a classe CSS ao qual este compenente pertence
     *
     * @param string $className
     *
     * @return
     */
    public function addCSSClass($className) {
        if (is_string($className)) {
            $this->class = $className;
        }else {
            throw new Exception ("o Atributo classe deve ser uma string.");
        }
    }
    /**
     * Restaura o valor do atributo  HTML class;
     * @return string
     */
    protected function getCSSClass() {
        if(strlen($this->class) > 2 ) {
            return ' class="'. $this->class .'"';
        }
        return  " ";
    }
    /**
     * Configura o atributo CSS style do compenente
     *
     * @return void
     * @param string $cssStyle
     */
    public function addCSSStyle($cssStyle=null) {
        if (is_string($cssStyle)) {
            $this->styles = explode(";",$cssStyle);
        }else if(is_array($cssStyle)) {
                $this->styles =$cssStyle;
            }
    }
    /**
     * Restaura o valor de uma string CSS Passada
     * @return string
     */
    protected function getCSSStyle() {
        $style="";
        if(is_array($this->styles)  && count($this->styles) > 0 ) {
            foreach ($this->styles as $stl) {
                $style .= $stl.";";
            }
            return ' style="'. $style .'"';
        }
        return " ";
    }
    /**
     * Configura o Parâmetro ID
     *
     * @param string $id
     */
    public function setId($id) {
        if(is_string($id)) {
            $this->id = $id;
        }else {
            throw new Exception("Atributo ID inválido.");
        }
    }
    /**
     * Recupera o valor do atributo ID de Formulário HTML
     *
     * @return string
     */
    protected  function getId() {
        if(strlen ($this->id) > 0 ) {
            return ' id="' . $this->id .'"' ;
        }
        return " ";
    }

    /**
     * Recupera o valor do atributo ID de Formulário HTML
     *
     * @return string
     */
    protected function getInputType() {
        if(strlen($this->inputType) > 5 ) {
            return $this->inputType;
        }
        return " ";
    }

    /**
     * Auxilia na criação de um elemento de Formulário
     * HTML desabilitado por padrão.
     *
     * @param boolean $boolean
     */
    public function isReadOnly($boolean=true) {
        if(is_bool($boolean)) {
            $this->readonly= ($boolean == true) ? " readonly " : " "  ;
        }else {
            throw new Exception("Não é boleano.");
        }
    }
    /**
     *Recupera o valor ReadOnly do elemento de Formulário HTML
     *@return string
     *
     */
    protected function getReadOnly() {
        $this->readonly= (strlen($this->readonly) > 5) ? $this->readonly: " ";
        return $this->readonly;
    }

    /**
     * Auxilia na criação de um elemento de Formulário
     * HTML desabilitado por padrão.
     *
     * @param boolean $boolean
     */
    public function isEnabled($boolean=null) {
        if(is_bool($boolean)) {
            $this->isEnabled=($boolean==true) ?	 " disabled ": " ";
        }else {
            throw new Exception("Não é boleano.");
        }
    }
    /**
     *
     */
    protected function getEnabled() {
        $this->isEnabled;
    }

    /**
     * Configura o valor do atributo title do elemento
     * de Formulário HTML
     *
     * @param string $title
     */
    public function setTitle($title) {
        if( is_string($title) ) {
            $this->title = $title;
        }else {
            throw new Exception("O atributo título não está definido corretamente.");
        }
    }
    /**
     *
     */
    protected function getTitle() {
        if(is_string($this->title) && strlen($this->title)) {
            return " title=\"". $this->title ."\"";
        }
        return " ";
    }
    /**
     * Configura o valor do atributo tabIndex do elemento
     * de Formulário HTML
     *
     * @param string $index
     */
    public function setTabIndex($index) {
        if( is_string($index) || is_integer($index)  ) {
            $this->tabIndex = $index;
        }else {
            throw new Exception("O atributo tabIndex não está definido corretamente.");
        }
    }
    /**
     * Recupera o valor de tabIndex, já devidamente configurado.
     *
     * @return string
     */
    protected function getTabIndex() {
        if(strlen($this->tabIndex) > 0 ) {
            return " tabIndex=\"" . $this->tabIndex ."\"";
        }
        return " ";
    }
    /**
     * Imprime a saída do elemento, já formato e
     * preparado para a visualização na página HTML
     *
     * Este método, seja ele herdado ou redefinido nas subclasses
     * tem a função adicional principal a de compor um decorator onde as
     * interfaces de outros objetos, como a de HTMLForm deve implementar
     * @return string
     *
     */

    public function printOut() {
        $this->out =$this->getLabel() . "<" .
            $this->getInputType() ." ".
            $this->getName().
            $this->getId().
            $this->getCSSClass() .
            $this->getEvents() .
            $this->getEnabled() .
            $this->getMaxLength() .
            $this->getSize() .
            $this->getTabIndex() .
            $this->getCSSStyle() .
            $this->getValue().
            $this->getReadOnly().
            $this->getTitle() ." />\n";
        echo $this->out;
    }
    public function getOutput() {
        $this->out =$this->getLabel() . "<" .
            $this->getInputType() ." ".
            $this->getName().
            $this->getId().
            $this->getCSSClass() .
            $this->getEvents() .
            $this->getEnabled() .
            $this->getMaxLength() .
            $this->getSize() .
            $this->getTabIndex() .
            $this->getCSSStyle() .
            $this->getValue().
            $this->getReadOnly().
            $this->getTitle() ." />\n";
        return $this->out;
    }

}

?>