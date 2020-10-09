<?php

class MysqlTransaction implements ITransaction {
    private $myConnector;
    private $statement;
    private $error;
    private $errorMessage;
     
    /**
     * @return void
     * construtor
     */
    public function MysqlTransaction(MysqlAccess $connector) {
        $this->myConnector = $connector->getConnector();
    }
    /**
     * Deve ser usada para gravar, deletar, atualizar dados se foi bem executada
     * retorna o numero de registros afetados. Em caso de dados serem
     * os mesmos o valor sera zero
     * @return boolean
     *
     */
    public function execute($sql) {

        $this->statement = $sql ;

        if (!is_string($this->statement)) {
            trigger_error("Passagem de parâmetro com tipo incorreto.", E_USER_ERROR);
        }
        
        $execute = $this->myConnector->query($this->statement);
        
        if($this->myConnector->error) {
	          trigger_error("Ocorreu um erro no MySql: " . $this->myConnector->error, E_USER_ERROR);
	          $this->errorMessage = "Ocorreu um erro no MySql: " . $this->myConnector->error;
	          return false;
	    } else {
		      return $this->myConnector->affected_rows;
	    }
    }
    /**
     * Uma colecao de todos os dados encontrados
     *@param String $sql
     *@return ArrayList
     */
    public function executeQuery($sql) {
        $whereIam =__CLASS__."::".__METHOD__;
        $list = null;
        $this->statement = $sql ;
        // echo $this->statement ."\n";
        if (!is_string($this->statement) ) {
            trigger_error("Passagem de parametro invalido em: " .$whereIam,E_USER_ERROR);
        }
        //Recupera os dados do banco dee dados
        //var_dump($this->myConnector);
        $myResult = $this->myConnector->query($this->statement);
        if($this->myConnector->error) {
            $this->errorMessage  = "Ocorreu um erro na tentativa de execução de " .$whereIam."\n";
            $this->errorMessage .= $this->myConnector->error;
        }else {
        //Instancia um objeto ArrayList para armazenar os dados em memoria
            $list = new ArrayList();
            $this->size=0;
            while ($record =$myResult->fetch_assoc()) {
            //cada Elemento de List e' um outro ArrayList
                $items = new ArrayList();
                //cada registro e recuperado em um ArrayList e armazenado em uma
                //collection que representa a estrutura do RecordSet
                foreach ($record as $key=>$item) {
                    $item =($item==NULL || $item==null ) ? "" :$item;
                    $items->add($item,$key);
                }
                $this->size++;
                $list->add($items);
                $items = null;
            }
        }
        return $list;
    }
    /**
     *@return boolean
     *Inicia uma transação Mysql
     *
     */
    public function begin() {
        $this->myConnector->autocommit(FALSE);
        if($this->myConnector->error) {
            $msg = "Ocorreu um erro na tentativa de execução de ";
            $msg.= __CLASS__."::".__METHOD__.": \n" . $this->myConnector->error;
            throw new Exception($msg);
        }
    }
    /**
     *@return boolean
     *Realiza um rollback de uma operação indesejada em numa
     *transação no Mysql
     */
    public function rollback() {
        $execute = $this->myConnector->rollback();
        if($this->myConnector->error) {
            $msg = "Ocorreu um erro na tentativa de execucao de ";
            $msg.= __CLASS__."::".__METHOD__ ."\n" . $this->myConnector->error;
            throw new Exception($msg);
        }
    }
    /**
     *@return boolean
     *Encerra com sucesso uma transa��o PostgreSQl
     */
    public function commit() {

        $execute = $this->myConnector->commit();
        if($this->myConnector->error) {
            $msg = "Ocorreu um erro na tentativa de execuçao de ";
            $msg.= __CLASS__."::".__METHOD__ ."\n" . $this->myConnector->error;
            throw new Exception($msg);
        }
    }
    public function getErrorNo() {
        return $this->error;
    }
    public function getErrorMessage() {
        return $this->errorMessage;
    }
    /**
     *
     * @return integer;
     */
    function getSize() {
        return $this->size;
    }
    
    public function getSQLStatement() {
        return $this->statement;
    }
    
	public function getMyConnector() {
        return $this->myConnector;
    }
}