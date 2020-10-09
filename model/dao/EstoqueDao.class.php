<?php
class EstoqueDao extends AbstractEntityDao
{

	public function __construct(){
		parent::AbstractEntityDao();
	}

    public function inserir(Estoque $estoque) {
    	$this->getDaoManager()->reset();
   		$this->getDaoManager()->begin();
		$this->getDaoManager()->setTable("tb_estoque");
		$this->getDaoManager()->addColumn("codigo_vestuario");
		$this->getDaoManager()->addValue($estoque->getCodigoVestuario());
		$this->getDaoManager()->addColumn("id_vestuario");
		$this->getDaoManager()->addValue($estoque->getVestuario()->getId());
		$this->getDaoManager()->addColumn("status");
		$this->getDaoManager()->addValue($estoque->getStatus());
		$this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->commit();
			$this->getDaoManager()->reset();
			return true;
		} else{
			$this->getDaoManager()->rollback();
		 	return false;
		}
	}
   
	public function alterar(Estoque $estoque){
			$this->getDaoManager()->reset();
			$this->getDaoManager()->begin();
			$this->getDaoManager()->setTable("tb_estoque");
			$this->getDaoManager()->addColumn("status");
			$this->getDaoManager()->addValue($estoque->getStatus());
			$filter = new SQLFilter("codigo_vestuario", "=", $estoque->getCodigoVestuario());
			$this->getDaoManager()->setQueryFilter($filter->dump());
			$this->getDaoManager()->doUpdate();
			
			if($this->getDaoManager()->rowsChanged()){
				$this->getDaoManager()->commit();
				$this->getDaoManager()->reset();
				return true;
			} else {
				$this->getDaoManager()->rollback();
				return false;
			}
	}
	
		public function excluir($codigo){
			$this->getDaoManager()->begin();
			$this->getDaoManager()->setTable("tb_estoque");
			$filterId = new SQLFilter("codigo_vestuario", "=", $codigo);
			$filter = $filterId->dump();
			$this->getDaoManager()->setQueryFilter($filter);
			$this->getDaoManager()->doDelete();
			
			if($this->getDaoManager()->getSize() > 0){
				$this->getDaoManager()->commit();
				return true;
			} else{
				$this->getDaoManager()->rollback();
				return false;
			}
		}
		
		public function consultarEstoquePorVestuario($idVestuario){
			$fields = array("codigo_vestuario", "id_vestuario", "status");
			$filter = new SQLFilter("id_vestuario", "=", $idVestuario);
			$filter = $filter->dump();
			
			$this->getDaoManager()->setTable("tb_estoque");
			$this->getDaoManager()->setFields($fields);
			$this->getDaoManager()->setQueryFilter($filter);
			return $this->getDaoManager()->doRead();
		}
		
		public function consultarEstoquePorCodigo($codigo){
			$fields = array("codigo_vestuario", "id_vestuario", "status");
			$filter = new SQLFilter("codigo_vestuario", "=", $codigo);
			$filter = $filter->dump();
			
			$this->getDaoManager()->setTable("tb_estoque");
			$this->getDaoManager()->setFields($fields);
			$this->getDaoManager()->setQueryFilter($filter);
			$result = $this->getDaoManager()->doRead();
			
		    $estoque = new Estoque(); 
		    $vestuario = new Vestuario();
		    
		    if($result != null && $result->getFirst() != null) {
		    	$result = $result->getFirst()->getElements();
		    	
			    $estoque->setCodigoVestuario($result[0]);
			    $vestuario->setId($result[1]);
			    $estoque->setStatus($result[2]);
		    }
		    
		    $estoque->setVestuario($vestuario);
		     
			return $estoque;
		}
      
	    public function consultarTodosEstoques(){
			$fields = array("codigo_vestuario", "id_vestuario", "status");
			$this->getDaoManager()->setTable("tb_estoque order by id desc");
			$this->getDaoManager()->setFields($fields);
			return $this->getDaoManager()->doRead();
		}
}

?>
