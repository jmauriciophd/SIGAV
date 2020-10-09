<?php
/**
 * @author Gedalias Freitas Costa
 * @email gedalfc@gmail.com
 * @copyright 2007-2009
 * @access publico
 *
 */
abstract class SQLSimple {
    protected static $transaction;
    protected $criteria     = "" ;
    protected $tableName    = "";
    protected $fields       = "";
    protected $values		= "";
    protected $filter       = "";
    protected $sqlStatement = "";
    protected $isAffected   = false;

    public function setFieldsName($fields=null) {
        if(is_array($fields) || is_string($fields)) {
            $this->fields = $fields;
        }else {
            throw new Exception("Parámetro inválido no método setFieldsName() em SQLUpdateSimple ");
        }

    }
    /**
     * Configura o nome interno da tabela.
     *
     * @param string $name
     * @return boolean
     */
    public function setTableName($name=null) {
        if(isset($name) && is_string($name)) {
            $this->tableName = $name;
        }else {
            throw new Exception("Par�metro inv�lido no m�todo setTableName().");
        }
    }

    /**
     * Recebe um objeto SQLExpression a fim montar um criterio de busca.
     * NAO pode ser usado com setFilter()
     *
     * @param Expression $criteria
     */

    public function setCriteria($criteria ) {
        if($criteria instanceof SQLExpression ) {
            $this->criteria = " where " . $criteria->dump();
        }else {
            $this->criteria=" ";
        }
    }
    /**
     * O par�metro $values pode ser um array contendo todos valores permitidos
     * para atualiza��o de acordo com a configura��o do banco de dados.
     * Em caso onde o campo dever� permanecer intacto, isto �, manter o valor atual,
     * sua posi��o no array deve descrita como uma string com o texto NULL ou null
     *
     * Ex: array("valor_1",null,"valor_3", NULL)
     * @param mixed $values
     */
    public function setValues($values=null) {
        if(is_array($values) ||  is_string($values)) {
            $this->values = $values;
        }else {
            throw new Exception("Par�metro inv�lido no m�todo setValues() em SQLUpdateSimple. ");
        }
    }

    /**
     * O $criteria passado deve ser um string contendo o filtro
     * SQL apropriado, neste caso pode-se passar o WHERE ou nao.
     *
     * @return void
     * @param string $filter
     * FIXME: ainda entendi porque sem invalida o metodo e lanca  a exce��o
     */
    public function setQueryFilter($filter=null) {
        if(is_string($filter) && strlen($filter) > 3) {
            $f = strtolower($filter);
            if(!(strpos($f,"where") === false) ) {
                $f = substr($filter,(strpos($f,"where") + 5), strlen($f));
            }
            $this->filter = " where " . $f;
        } else {
            $this->filter=" ";
        }
    }
    /**
     * Invoca o motodo execute de ITransaction
     * a fim de atualizar os dados e retorna a
     * quantidade de registros afetados ou um valor false.
     * @return boolean
     */
    abstract protected function mountSQL() ;
    /**
     *
     */
    public function execute($sqlStatement=null) {
        $this->sqlStatement = ($sqlStatement!=null) ? $sqlStatement : $this->mountSQL();
        $this->isAffected = self::$transaction->execute($this->sqlStatement);
        return $this->isAffected;
    }
    /**
     * Retorna false se a transa��o tiver falhado ou um valor inteiro com a quantidade de registros
     * alterados.
     * @return mixed
     */
    public function rowsChanged() {
        return $this->isAffected;
    }
    /**
     *Usado para alterar objetos de transa��o em tempo de execucao;
     * @param ITransaction $trans
     */
    public function changeTansaction(ITransaction $trans) {
        self::$transaction = $trans;
    }
    /**
     *
     *
     * @param string $grouping
     */
    public  function groupBy($grouping="") {

    }
    public  function orderBy($sorting="") {

    }
    public  function having($having ="") {

    }
    /**
     * Uma string representando a SQL que ser� inserido na base de dados.
     * @return string
     */
    public function sqlDebugger() {
        return self::$transaction->getSQLStatement();
    }
    /**
     * Uma string representando a SQL que ser� inserido na base de dados.
     * @return string
     */
    public function getSQLStatement() {
        return self::$transaction->getSQLStatement();
    }
    /**
     *Uma descricao do erro retornado pela transacao sendo realizada.
     * @return string
     *
     */
    public function getErrorDescription() {
        return self::$transaction->getErrorMessage();
    }
    /**
     *Um c�digo do erro retornado pela transacao sendo realizada.
     * @return string
     *
     */
    public function getErrorNo() {
        return self::$transaction->getErrorNo();
    }
    /**
     *Uma descricao do erro retornado pela transacao sendo realizada.
     * @return string
     *
     */
    public function getErrorMessage() {
        return self::$transaction->getErrorMessage();
    }
}

?>