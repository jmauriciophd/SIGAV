<?php

/**
 * Classe dao do Medidas
 * @author Rafael Dias
 * 
 */
class MedidasDao extends AbstractEntityDao
{

	public function __construct(){
		parent::AbstractEntityDao();
	}
	
	public function inserir(Medidas $medidas)
	{
		$this->getDaoManager()->reset();
		$this->getDaoManager()->setTable("tb_medidas");
		$this->getDaoManager()->addColumn("tamanho");
		$this->getDaoManager()->addValue($medidas->getTamanho());
		$this->getDaoManager()->addColumn("busto_torax");
		$this->getDaoManager()->addValue($medidas->getBustoTorax());
		$this->getDaoManager()->addColumn("cintura");
		$this->getDaoManager()->addValue($medidas->getCintura());
		$this->getDaoManager()->addColumn("quadril");
		$this->getDaoManager()->addValue($medidas->getQuadril());
		$this->getDaoManager()->addColumn("altura_frente");
		$this->getDaoManager()->addValue($medidas->getAlturaFrente());
		$this->getDaoManager()->addColumn("ombro");
		$this->getDaoManager()->addValue($medidas->getOmbro());
		$this->getDaoManager()->addColumn("braco");
		$this->getDaoManager()->addValue($medidas->getCostas());
		$this->getDaoManager()->addColumn("costas");
		$this->getDaoManager()->addValue($medidas->getBraco());
		$this->getDaoManager()->addColumn("observacao");
		$this->getDaoManager()->addValue($medidas->getObservacao());
		$this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->commit();
			return $this->getIdGerado();
		} else{
			$this->getDaoManager()->rollback();
			$this->getDaoManager()->reset();
		 	return 0;
		}
	}
	
	
	public function alterar(Medidas $medidas){
		$this->getDaoManager()->reset();
		$this->getDaoManager()->begin();
		$this->getDaoManager()->setTable("tb_medidas");
		$this->getDaoManager()->addColumn("tamanho");
		$this->getDaoManager()->addValue($medidas->getTamanho());
		$this->getDaoManager()->addColumn("busto_torax");
		$this->getDaoManager()->addValue($medidas->getBustoTorax());
		$this->getDaoManager()->addColumn("cintura");
		$this->getDaoManager()->addValue($medidas->getCintura());
		$this->getDaoManager()->addColumn("quadril");
		$this->getDaoManager()->addValue($medidas->getQuadril());
		$this->getDaoManager()->addColumn("altura_frente");
		$this->getDaoManager()->addValue($medidas->getAlturaFrente());
		$this->getDaoManager()->addColumn("ombro");
		$this->getDaoManager()->addValue($medidas->getOmbro());
		$this->getDaoManager()->addColumn("braco");
		$this->getDaoManager()->addValue($medidas->getCostas());
		$this->getDaoManager()->addColumn("costas");
		$this->getDaoManager()->addValue($medidas->getBraco());
		$this->getDaoManager()->addColumn("observacao");
		$this->getDaoManager()->addValue($medidas->getObservacao());
		
		$filterId = new SQLFilter("id", "=", $medidas->getId());
		$filter = $filterId->dump();
		
		$this->getDaoManager()->setQueryFilter($filter);
		$this->getDaoManager()->doUpdate();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->commit();
			$this->getDaoManager()->reset();
			return true;
		} else if ($this->getDaoManager()->getErrorNo() != null && $this->getDaoManager()->getErrorNo() != ""){
		 	$this->getDaoManager()->rollback();
		 	$this->getDaoManager()->reset();
		 	return false;
		} else {
			return true;
		}
	}
	
	public function excluir($id){
			$filterCpf = new SQLFilter("id", "=", $id);
			$filter = $filterCpf->dump();
			$this->getDaoManager()->setTable("tb_medidas");
			$this->getDaoManager()->setQueryFilter($filter);
			$this->getDaoManager()->doDelete();
			
			if($this->getDaoManager()->getSize() > 0){
				$this->getDaoManager()->commit();
				$this->getDaoManager()->reset();
				return true;
			} else{
				$this->getDaoManager()->rollback();
				$this->getDaoManager()->reset();
			 	return false;
			}
	}
	
	public function consultar(Medidas $medidas){
	}
	
}

?>