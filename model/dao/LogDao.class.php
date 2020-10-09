<?php
class LogDao extends AbstractEntityDao
{
	public function __construct(){
		parent::AbstractEntityDao();
	}

    public function inserir(Log $log) {
   		$this->getDaoManager()->begin();
		$this->getDaoManager()->setTable("tb_log");
		$this->getDaoManager()->addColumn("id_aplicacao");
		$this->getDaoManager()->addValue($log->getAplicacao()->getId());
		$this->getDaoManager()->addColumn("tabela");
		$this->getDaoManager()->addValue($log->getTabela());
		$this->getDaoManager()->addColumn("chave_primaria");
		$this->getDaoManager()->addValue($log->getChavePrimaria());
		$this->getDaoManager()->addColumn("operacao");
		$this->getDaoManager()->addValue($log->getOperacao());
		$this->getDaoManager()->addColumn("cpf_usuario");
		$this->getDaoManager()->addValue($log->getUsuario()->getCpf());
		$this->getDaoManager()->addColumn("data_hora");
		$this->getDaoManager()->addValue($log->getDataHora());
		$this->getDaoManager()->addColumn("ip");
		$this->getDaoManager()->addValue($log->getIp());
		$this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->commit();
			$this->getDaoManager()->reset();
			return true;
		} else{
			$this->getDaoManager()->rollback();
			$this->getDaoManager()->reset();
		 	return false;
		}
	}
   
	public function consultarLogPorId($id){
		$fields = array("id", "nome", "descricao");
		$filter = new SQLFilter("id", "=", $id);
		$filter = $filter->dump();
		
		$this->getDaoManager()->setTable("tb_log");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		
		$log = new Log();
		
		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			
			$log->setId($result[0]);
			$log->setNome($result[1]);
			$log->setDescricao($result[2]);
		}
		
		return $log;
	}
      
    public function consultarTodosLogs(){
		$fields = array("id", "nome", "descricao");
		$this->getDaoManager()->setTable("tb_log");
		$this->getDaoManager()->setFields($fields);
		return $this->getDaoManager()->doRead();
	}
}
?>
