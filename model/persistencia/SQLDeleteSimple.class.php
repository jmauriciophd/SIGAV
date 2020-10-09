<?php
/**
 * @author Gedalias Freitas Costa
 * @email gedalfc@gmail.com
 * @copyright 2007-2009
 * @access publico
 *
 */
class SQLDeleteSimple extends SQLSimple {
    public function __construct(ITransaction $trans=null) {
        if($trans instanceof ITransaction) {
            parent::$transaction = $trans;
        }else {
            throw new Exception("Parametro invalido no construtor de SQLDeleteSimple.");
        }
    }
    /**
     *Sua reescrita nao tem efeito sobre esta classe
     *
     */
    public function setValues($arrayValues=null) {
         //nao retorna nada nem mesmo void ou null
    }
    /**
     *Sua reescrita nao tem efeito sobre esta classe
     *
     */
    public function setFieldsName($arrayFields=null) {
         //nao retorna nada nem mesmo void ou null
    }

    protected function mountSQL() {
        if(!strlen($this->tableName)) {
            throw  new Exception("Nenhum nome de tabela definido para exclusão.");
        }
        $DMLString = "delete from " . $this->tableName ."\n".$this->criteria ."\n". $this->filter . ";";
        //echo $DMLString."<br>"; //DEBUGGER
        return (string)$DMLString;
    }
}

?>