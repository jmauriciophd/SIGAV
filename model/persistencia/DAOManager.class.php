<?php

/**
 * @author Gedalias Freitas da Costa
 * @copyright Copyright &copy; 2007, Gedalfc@gmail.com
 * @since 2008-12-31
 */
class DAOManager {
    private $orderby    ;
    private $groupby    ;
    private $transaction;
    private $size       ;
    private $columns    ;
    private $filter     ;
    private $values     ;
    private $criteria   ;
    private $table_name ;
    private $idGerado   ;
    /**
     Estes atributo representam singleTon, deve haver quatro,
     para que referencias possam ser chamadas em outros objetos DAOManager
     sem a necessidade de instanciar novos objetos
     */
    private static $singleInsert=null;
    private static $singleUpdate=null;
    private static $singleDelete=null;
    private static $singleRead  =null;
    private static $monoInstance= null;
    /**
     * OK
     *
     * @param Transaction $transaction
     * @return void
     */
    public function __construct(ITransaction $transaction=null) {
        if($transaction instanceof ITransaction ) {
            $this->transaction = $transaction;
            $this->criteria = NULL;
            $this->filter   = NULL;
        }else {
            throw new Exception("Parámetro inválido construtor de DAOManager.");
        }
    }
    /**
     * Nome da tabela que será usada na operação
     * @access public
     * @return boolean
     * @param  string $name
     * @throws Exception()
     */
    public function setTable($name) {
        if(is_string($name)) {
            $this->table_name = $name;
        }else {
            $ex = "Parámetro inválido no método setTable() em DAOManager .";
            throw new Exception($ex);
        }
    }

    /**
     *
     * @access public
     * @return void
     * @param  string $column
     * @throws Exception()
     */
    public function addColumn($column,$value=NULL,$index=NULL) {
        if(is_string($column) ) {

            if(!is_null($value) && is_null($index)) {
                $this->values[] = $value;
            }
            if(!is_null($index) && is_int($index)) {
                $this->columns[$index] = $column;
            }else {
                $this->columns[] = $column;
            }
        }else {
            $ex = "Parámetro inválido no método setFields() em DAOManager .";
            throw new Exception($ex);
        }
    }
    /** @access public
     * @return void
     * @param  string  $column
     */
    public function addSortColumn($column=null) {
        if(is_string($column)) {
            $this->orderby[] = $column;
        }else {
            $this->orderby[]="";
        }
    }
    /** @access public
     * @return void
     * @param  string  $column
     */
    public function addGroupColumn($column=null) {
        if(is_string($column)) {
            $this->groupby[] = $column;
        }else {
            $this->groupby[]="";
        }
    }
    /**
     *
     * @access public
     * @return void
     * @param  string  $value
     * @param  integer $index
     * @throws Exception()
     */
    public function addValue($value,$column=null,$index=null) {
    //if(is_string($value)){
        if(!is_null($column) && is_null($index)) {
            $this->columns[] = $column;
        }
        if(is_numeric($index)) {
            $this->values[$index] = $value;
        }else {
            $this->values[] = $value;
        }

    //}else{
    //throw new Exception("Par�metro inv�lido no m�todo addValue() de DAOManager.");
    //}
    }
    /**
     * Reincia os valores iniciais do DAOManager;
     *
     */
    public function reset() {
        $this->columns  = "";
        $this->values   = null;
        $this->criteria = null;
        $this->filter   = null;
        $this->groupby  = "";
        $this->orderby  = "";
        $this->table_name="";
    }
    /**
     * array com o nome dos campos que serão
     * usados nas operações de DAOManager()
     * @access public
     * @return void
     * @param  mixed $fields
     * @throws Exception()
     */
    public function setFields($fields) {
        if(is_array($fields) || is_string($fields)) {
            $this->columns = $fields;
        }else {
            $ex = "Parámetro inválido no método setFields() em DAOManager .";
            throw new Exception($ex);
        }
    }
    /**
     * Modifica o valor de apenas um campo em tempo de execução;
	  
     * @access public
     * @return void
     * @param  string $field
     * @param  integer $index
     * @throws Exception()
     */
    public function changeValue($index,$field="NULL") {
        if(is_int($index) && is_string($field)) {
            if($field=="NULL" || $field==NULL || $field==null) {
                $field=NULL ;
            }
            $this->values[$index] = $field;
        }else {
            $ex = "Parámetro inválido no método changeValue() em DAOManager .";
            throw new Exception($ex);
        }
    }
    /**
     * Pode-se passar com parámetro um array ou um string de valores
     * separados por vírgula para os campos que serão
     * usados nas operações de DAOManager()
     * @access public
     * @return void
     * @param  mixed $arrayValues
     * @throws Exception()
     */
    public function setValues($values) {
        if(is_array($values) || is_string($values) ) {
            $this->values = $values;
        }else {
            throw new Exception("Parámetro inválido no método setValues() de DAOManager.");
        }
    }
    /**
     * Criterio elementares de SQL ANSI que serão
     * Criterio usado nas operações de DAOManager()
     * @access public
     * @return void
     * @throws Exception()
     * @param  string $criteria
     */
    public function setCriteria(SQLExpression $criteria) {
        if($criteria instanceof SQLExpression ) {
            $this->criteria = $criteria;
        }else {
            $ex = "Parámetro inválido no método setCriteria() em DAOManager .";
            throw new Exception($ex);
        }
    }
    /**
     * Filtragem elementar de SQL ANSI que serão
     * usado nas operações de DAOManager()
     *
     * @access public
     * @return void
     * @param  string $filter
     * @throws Exception()
     */
    public function setQueryFilter($filter=NULL) {
        if(is_string($filter)) {
            $this->filter = $filter;
        }else {
            throw new Exception("Passagem de par�metro invalido em setQueryFilter() de DAOManager.");
        }
    }
    /**
     * Busca a quantidade de registros armazenados e retorna esse n�mero
     *
     * @return integer
     */
    public function dataIsStored() {
        $col = array();
        $this->size=0;
        if(isset($this->columns[0])) {
            $this->columns[0] = str_replace(" ","",$this->columns[0]);
        }
        $col[0]=" count(*) as total_reg ";
        if(isset($this->columns[0]) && $this->columns[0]!="*") {
            $col[0]=" count({$this->columns[0]}) as total_reg";
        }
        if(self::$singleRead == null ) {
            self::$singleRead = new SQLReadSimple($this->transaction);
        }
        //não preciso de polimorfirmos aqui...
        self::$singleRead->changeTansaction($this->transaction);
        self::$singleRead->setTableName($this->table_name);
        self::$singleRead->setFieldsName($col);
        self::$singleRead->setCriteria($this->criteria);
        if(!is_null($this->filter)) {
            self::$singleRead->setQueryFilter($this->filter);
        }
        //retorna um ArrayList<ArrayList> contendo a quantidade registros encontrados
        $countList = self::$singleRead->execute();
        //recupera o primeiro ArrayList contendo a informa��o
        $result = $countList->getFirst();
        $this->size = $result->contentAt("total_reg");
        //echo "<br>".$this->getSQLStatement();
        $countList = null;
        return $this->size;
    }

    /**
     *Factory Method  - instancia um SQLCreateSimple dinamicamente
     * e garante que só haverá uma instáncia desta Classe
     * Retorna quantidade de registros inseridos na base de dados
     * @access public
     * @return um int
     * @throws Exception()
     */
    public function doInsert() {
        $this->size = 0;
        //Instanciação do primeiro objeto de gravação/armazenamento
        if(self::$singleInsert==null) {
            self::$singleInsert = new SQLCreateSimple($this->transaction);
        }
        self::$monoInstance = self::$singleInsert;
        $this->statementPrepare(self::$singleInsert);
     	$this->size = self::$singleInsert->execute();
        $this->idGerado = mysqli_insert_id($this->transaction->getMyConnector());
        //echo  "<br/>ID gerado: " . $this->idGerado;
        if(is_numeric($this->size)) {
            return $this->size;
        }
        return false;
    }
    /**
     * Factory Method - instancia um SQLCreateSimple dinamicamente
     * e garante que só haverá uma instancia desta Classe.
     *
     * Retorna a quantidade de registros atualizados nesta operação
     
     * @return integer
     * numa base de dados;
     * @throws Exception()
     */
    public function doUpdate() {
        $this->size=0;
        if(self::$singleUpdate == null) {
            self::$singleUpdate = new SQLUpdateSimple($this->transaction);
        }
        self::$monoInstance=self::$singleUpdate;
        $this->statementPrepare(self::$singleUpdate);
        $this->size = self::$singleUpdate->execute();
        if(is_numeric($this->size)) {
            return $this->size;
        }
        return false;
    }

    /**
     * Um ArrayList com os registros lidos de uma base de dados;
     * @return ArrayList
     * @throws Exception()
     */
    public function doRead() {
        $this->size=0;
        if(self::$singleRead == null ) {
            self::$singleRead = new SQLReadSimple($this->transaction);
        }
        self::$monoInstance=self::$singleRead;
        $this->statementPrepare(self::$singleRead);
        $iterator = self::$singleRead->execute();
        $this->size = $iterator->getSize();
        return $iterator;

    }

    /**
     * reorna inteiro com quantidade de registros excluídos.
     * numa base de dados;
     * @access public
     * @return integer
     *
     */
    public function doDelete() {
        $this->size=0;
        if(self::$singleDelete == null ) {
            self::$singleDelete = new SQLDeleteSimple($this->transaction);
        }
        self::$monoInstance=self::$singleDelete;
        $this->statementPrepare(self::$singleDelete);
        $this->size = self::$singleDelete->execute();
        if(is_numeric($this->size)) {
            return $this->size;
        }
        return false;
    }

    public function rowsChanged() {
        return self::$monoInstance->rowsChanged();
    }
    /**
     * Inicia uma transação.
     * @return boolean
     */
    public function begin() {
        return $this->transaction->begin();
    }

    /**
     * Torna os dados persistentes em permanentes.
     * @return boolean
     */
    public function commit() {
        return $this->transaction->commit();
    }

    /**
     * Desfaz uma transaçãoo, eliminando todos os dados persistente,
     * durante a transação iniciada.
     * @return boolean
     */
    public function rollback() {
        return $this->transaction->rollback();
    }
    /**
     * A quantidade de registros alterados, criados, excluidos ou recuperados
     * durante a última transação.
     * @return integer
     */
    public function getSize() {
        return $this->size;
    }
    /**
     * @access private
     * @param SQLSimple $instance
     */
    private function statementPrepare(SQLSimple $instance) {
        $instance->setTableName($this->table_name);
        $instance->setFieldsName($this->columns);
        $instance->changeTansaction($this->transaction);
        $instance->setCriteria($this->criteria);
        $instance->orderBy($this->orderby);
        $instance->groupBy($this->groupby);
        $instance->setQueryFilter($this->filter);
        if(!is_null($this->values)) {
            $instance->setValues($this->values);
        }
    }
    /**
     * Uma string representando a SQL que ser� inserido na base de dados.
     * @return string
     */
    public function getSQLStatement() {
        if(self::$monoInstance) {
            return self::$monoInstance->getSQLStatement();
        }
        return false;
    }
    /**
     *Uma descrição do erro retornado pela transacao sendo realizada.
     * @return string
     *
     */
    public function getErrorDescription() {
        if(self::$monoInstance) {
            return self::$monoInstance->getErrorMessage();
        }
        return false;
    }
    /**
     *Um código do erro retornado pela transacao atualmente sendo realizada.
     *@return string
     *
     */
    public function getErrorNo() {
        if(self::$monoInstance) {
            return self::$monoInstance->getErrorNo();
        }
        return false;
    }
    /**
     *Uma descricao do erro retornado pela transacao atualmente sendo realizada.
     * @return string
     *
     */
    public function getErrorMessage() {
        if(self::$monoInstance) {
            return self::$monoInstance->getErrorMessage();
        }
        return false;
    }
    
 	public function getIdGerado(){
    	 return $this->idGerado;
    }
    
}

?>