<?php

/**
 * @author Gedalias Freitas Costa
 * @email gedalfc@gmail.com
 * @copyright 2007-2009
 * @access publico
 *
 */
class SQLCreateSimple extends SQLSimple {

    public function __construct(ITransaction $trans=null) {
        if($trans instanceof ITransaction ) {
            parent::$transaction = $trans;
        }else {
            throw new Exception("Parámetro inválido no construtor de SQLCreateSimple ");
        }
    }
    /**
     *Sua reescrita nao tem efeito sobre esta classe
     *
     */
    public function setCriteria($criteria) {
    //nao retorna nada nem mesmo void ou null
    }
    /**
     *Sua reescrita nao tem efeito sobre esta classe
     *
     */
    public function setQueryFilter($filter=null) {
    //nao retorna nada nem mesmo void ou null
    }
    /**
     * Este metodo deve analisar, configurar e lancar exceďż˝ďż˝es
     * caso algo ainda nao tiver sido configurado corretamente
     *
     * @return string
     *
     */
    protected function mountSQL() {
        $this->fields = (is_array($this->fields))? $this->fields : explode(",",$this->fields);
        $this->values = (is_array($this->values))? $this->values : explode(",",$this->values);
        $count_fields = count($this->fields);
        $count_values = count($this->values);
        $field_value ="" ;
        if($count_fields != $count_values) {
            throw new Exception("A quantidade de campos para inserção não coincide com os valores passados.");
        }
        //verifica o nome da tabela ja foi configurado.
        if(empty($this->tableName)) {
            throw new Exception("O nome da tabela ainda não foi definido.");
        }
        //Monta uma string parcialmente, e faz
        //$this->values = implode("','",$this->values);
        $allfields = implode(",",$this->fields);

        //Monta a string com os valores de dados valores
        foreach($this->values as $key=>$value) {
            if(strlen($field_value) > 0 && ($value!==NULL)) {
                $field_value .=   ",'" . $value."'";
            }else if((strlen($field_value) > 0) && ($value===NULL || $value==="")) {
                    $field_value .=   ",".$this->fields[$key]  ;
                }else {
                    $field_value =  "'$value'";
                }
        }

        $DMLString = "insert into " .$this->tableName ."({$allfields}) \n values({$field_value}); ";
        //echo "<br />" .$DMLString."<br />"; //DEBUGAR
        return $DMLString;

    }
    
}
?>