<?php
class AluguelVestuarioDao extends AbstractEntityDao
{

	public function __construct(){
		parent::AbstractEntityDao();
	}

    public function inserir(AluguelVestuario $aluguelVestuario) {
		$this->getDaoManager()->reset();
   		$this->getDaoManager()->begin();
		$this->getDaoManager()->setTable("tb_aluguel_vestuario");
		$this->getDaoManager()->addColumn("id_aluguel");
		$this->getDaoManager()->addValue($aluguelVestuario->getAluguel()->getId());
		$this->getDaoManager()->addColumn("codigo_vestuario");
		$this->getDaoManager()->addValue($aluguelVestuario->getEstoque()->getCodigoVestuario());
		$this->getDaoManager()->addColumn("data_devolucao");
		$this->getDaoManager()->addValue($aluguelVestuario->getDataDevolucao());
		$this->getDaoManager()->addColumn("situacao");
		$this->getDaoManager()->addValue($aluguelVestuario->getSituacao());
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
   
	
	public function consultarAluguelVestuatioPorIdAluguel($idAluguel){
		$fields = array("av.id_aluguel", "av.codigo_vestuario", "av.data_devolucao", "av.situacao");
		$filterIdVestuario = new SQLFilter("av.id_aluguel", "=", $idAluguel);
		$filter = $filterIdVestuario->dump();
		
		$this->getDaoManager()->setTable("tb_aluguel_vestuario av inner join tb_aluguel a on av.id_aluguel = a.id");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		return $this->getDaoManager()->doRead();
	} 
	
	public function consultarTodosAlugueisVestuarios(){
		$fields = array("av.id_aluguel", "av.codigo_vestuario", "av.data_devolucao", "av.situacao");
		$this->getDaoManager()->setTable("tb_aluguel_vestuario av inner join tb_aluguel a on av.id_vestuario = a.id");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		return $this->getDaoManager()->doRead();
	}
	
}

?>
