<?php
/**
 * @author Gedalias Freitas Costa
 * @email gedalfc@gmail.com
 * @copyright 2007-2009
 * @access publico
 *
 */
class SQLUpdateSimple extends SQLSimple {

    public function __construct(ITransaction $trans=null) {
        if($trans instanceof ITransaction ) {
            parent::$transaction  = $trans;
        }else {
            throw new Exception("Parametro invalido no construtor de SQLUpdateSimple ");
        }
    }

    //monta o SQL padrao para updates simples
    protected  function mountSQL() {
    //tambem pode receber uma string
        $fields = (is_array($this->fields))? $this->fields : explode(",",$this->fields);
        $values = (is_array($this->values))? $this->values : explode(",",$this->values);
        //coleta valores para analise
        $field_count = count($fields);
        $value_count = count($this->values);
        $strField =" " ;
        if($field_count != $value_count) {
            throw new Exception("A quantidade de campos não coincide com os valores passados para atualizaïção.");
        }else {
            foreach($values as $key => $valueOfField) {
                if($valueOfField===NULL || $valueOfField === null ) {
                    $strField.= $fields[$key]."=". $fields[$key].",\n";
                }else {
                    $strField.= $fields[$key]."='". $valueOfField."',\n";
                }
            }
        }
        $strField = substr($strField,0,(strlen($strField)-2));
        $DMLString = "update " .$this->tableName ." set {$strField} \n". $this->criteria . $this->filter. " ; ";
	    //echo "<br/>SQL: ".$DMLString;
        return (string)$DMLString;
    }

}

?>