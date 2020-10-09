<?php

interface ITransaction { 
	public function execute($sql);
	public function executeQuery($sql);
	public function begin();
	public function rollback();
	public function commit();
	public function getSQLStatement();
    public function getErrorNo();
    public function getErrorMessage();
    public function getMyConnector();
}
 
?>