<?php
require_once dirname(__FILE__) . "/../../libloader.php";
class AbstractEntityDao
{
	private $mysqlFactory;
	private $mysqlTransaction;
	private $daoManager;
	
	public function AbstractEntityDao()
	{
		$this->mysqlFactory = new MysqlFactory();
		$this->mysqlTransaction = $this->mysqlFactory->createConnector();
		$this->daoManager = new DAOManager($this->mysqlTransaction);
		$this->daoManager->reset();
	}
	
	public function getMySqlFactory()
	{
		return $this->mysqlFactory;
	}

	public function getMySqlTransaction()
	{
		return $this->mysqlTransaction;
	}
	
	public function getDaoManager()
	{
		return $this->daoManager;
	}
	
	public function getIdGerado(){
		return $this->getDaoManager()->getIdGerado();
	}
}

?>
