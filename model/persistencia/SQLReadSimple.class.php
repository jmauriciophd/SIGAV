<?php
/**
 * @author Gedalias Freitas Costa
 * @email gedalfc@gmail.com
 * @copyright 2007-2009
 * @access publico
 *
 */
class SQLReadSimple extends SQLSimple {
    private $grouby;
    private $orderby;
    private $having;
    public function __construct(ITransaction $trans) {
        if($trans instanceof ITransaction ) {
            parent::$transaction = $trans;
        }else {
            throw new Exception("Parámetro inválido no construtor de SQLReadSimple ");
        }
    }

    public function setValues($arrayValues=null) {}
    /**
     * Ler os dados e retorna um ArrayList com o resultset lido da base de dados.
     * Tambem pode retornar referencia NULL em caso de nao localizar qualquer registro.
     * @access public
     * @return ArrayList
     */
    public function execute($sqlStatement=null) {
        $this->sqlStatement = ($sqlStatement!=null) ? $sqlStatement:  $this->mountSQL();
         $this->isAffected = parent::$transaction->executeQuery($this->sqlStatement);
        return $this->isAffected ;
    }
    public  function groupBy($grouping="") {
        if(is_array($grouping)) {
            $this->grouby = " group by " . implode(",",$grouping);
        }else {
            $this->grouby ="";
        }
    }
    public  function orderBy($sorting="") {
        if(is_array($sorting)) {
            $this->orderby = " order by " . implode(",",$sorting);
        }else {
            $this->orderby ="";
        }
    }
    public  function having($having="") {
        if(is_array($having)) {
            $this->having = " having " . implode(",",$having);
        }else {
            $this->having ="";
        }
    }
    protected function mountSQL() {
        $this->fields = (is_array($this->fields)) ? implode(",",$this->fields) : $this->fields;
        $DMLString = "select " . $this->fields . " \nfrom " . $this->tableName .
            $this->criteria . $this->filter . $this->orderby. $this->grouby ;
        //echo 	$DMLString."<br>"; // DEBUGGER
        return $DMLString;
    }

}
?>