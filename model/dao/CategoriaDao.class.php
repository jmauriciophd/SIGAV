<?php

/**
 * Description of PerfilDAO
 *
 * @author reginaldo.junior
 */

class CategoriaDao extends AbstractEntityDao
{

	public function __construct(){
		parent::AbstractEntityDao();
	}

    public function inserir(Categoria $categoria) {
   		$this->getDaoManager()->begin();
		$this->getDaoManager()->setTable("tb_categoria");
		$this->getDaoManager()->addColumn("codigo");
		$this->getDaoManager()->addValue($categoria->getCodigo());
		$this->getDaoManager()->addColumn("descricao");
		$this->getDaoManager()->addValue($categoria->getDescricao());
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
   
	public function alterar(Categoria $categoria){
			$this->getDaoManager()->begin();
			$this->getDaoManager()->setTable("tb_categoria");
			$this->getDaoManager()->addColumn("descricao");
			$this->getDaoManager()->addValue($categoria->getDescricao());
			$filterCodigo = new SQLFilter("codigo", "=", $categoria->getCodigo());
			$filter = $filterCodigo->dump();
			$this->getDaoManager()->setQueryFilter($filter);
			$this->getDaoManager()->doUpdate();
			
			if($this->getDaoManager()->rowsChanged()){
				$this->getDaoManager()->commit();
				$this->getDaoManager()->reset();
				return true;
			} else {
				$this->getDaoManager()->rollback();
				$this->getDaoManager()->reset();
			 	return false;
			}
	}
	
	public function excluir($codigo){
			$this->getDaoManager()->begin();
			$this->getDaoManager()->setTable("tb_categoria");
			$filterCpf = new SQLFilter("codigo", "=", $codigo);
			$filter = $filterCpf->dump();
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
	
	public function consultarTodasCategorias(){
		$fields = array("codigo", "descricao");
		$this->getDaoManager()->setTable("tb_categoria");
		$this->getDaoManager()->setFields($fields);
		return $this->getDaoManager()->doRead();
	}

	public function consultarCategoriaPorCodigo($codigo){
		$fields = array("codigo", "descricao");
		$this->getDaoManager()->setTable("tb_categoria");
		$this->getDaoManager()->setFields($fields);
		$filterCodigo = new SQLFilter("codigo", "=", $codigo);
		$filter = $filterCodigo->dump();
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		$categoria = new Categoria();
		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			$categoria->setCodigo($result[0]);
			$categoria->setDescricao($result[1]);
		}
		$this->getDaoManager()->reset();
		return $categoria;
	}
	
	public function consultarCategoriaPorDescricao($descricao){
		$fields = array("codigo", "descricao");
		$this->getDaoManager()->setTable("tb_categoria");
		$this->getDaoManager()->setFields($fields);
		$filterCodigo = new SQLFilter("descricao", "=", $descricao);
		$filter = $filterCodigo->dump();
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		$categoria = new Categoria();
		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			$categoria->setCodigo($result[0]);
			$categoria->setDescricao($result[1]);
		}
		$this->getDaoManager()->reset();
		return $categoria;
	}
}

?>
