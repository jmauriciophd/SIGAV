<?php
class PerfilDao extends AbstractEntityDao
{

	public function __construct(){
		parent::AbstractEntityDao();
	}

    public function inserir(Perfil $perfil) {
    	$this->getDaoManager()->reset();
   		$this->getDaoManager()->begin();
		$this->getDaoManager()->setTable("tb_perfil");
		$this->getDaoManager()->addColumn("id");
		$this->getDaoManager()->addValue($perfil->getId());
		$this->getDaoManager()->addColumn("nome");
		$this->getDaoManager()->addValue($perfil->getNome());
		$this->getDaoManager()->addColumn("descricao");
		$this->getDaoManager()->addValue($perfil->getDescricao());
		$this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->commit();
			$this->getDaoManager()->reset();
			return $this->getIdGerado();
		} else{
			$this->getDaoManager()->rollback();
		 	return 0;
		}
	}
   
	public function alterar(Perfil $perfil){
			$this->getDaoManager()->reset();
			$this->getDaoManager()->begin();
			$this->getDaoManager()->setTable("tb_perfil");
			$this->getDaoManager()->addColumn("nome");
			$this->getDaoManager()->addValue($perfil->getNome());
			$this->getDaoManager()->addColumn("descricao");
			$this->getDaoManager()->addValue($perfil->getDescricao());
			$filter = new SQLFilter("id", "=", $perfil->getId());
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
	
		public function excluir($id){
			$this->getDaoManager()->begin();
			$this->getDaoManager()->setTable("tb_perfil");
			$filterId = new SQLFilter("id", "=", $id);
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
		
		public function consultarPerfilPorId($id){
			$fields = array("id", "nome", "descricao");
			$filter = new SQLFilter("id", "=", $id);
			$filter = $filter->dump();
			
			$this->getDaoManager()->setTable("tb_perfil");
			$this->getDaoManager()->setFields($fields);
			$this->getDaoManager()->setQueryFilter($filter);
			$result = $this->getDaoManager()->doRead();
			
			$perfil = new Perfil();
			
			if($result != null && $result->getFirst() != null){
				$result = $result->getFirst()->getElements();
				
				$perfil->setId($result[0]);
				$perfil->setNome($result[1]);
				$perfil->setDescricao($result[2]);
			}
			
			return $perfil;
		}
      
		public function consultarPerfilPorNome($nome){
			$fields = array("id", "nome", "descricao");
			$this->getDaoManager()->setTable("tb_perfil");
			$this->getDaoManager()->setFields($fields);
			$filterNome = new SQLFilter("nome", "=", $nome);
			$filter = $filterNome->dump();
			$this->getDaoManager()->setQueryFilter($filter);
			$result = $this->getDaoManager()->doRead();
			
			$perfil = new Perfil();
			
			if($result != null && $result->getFirst() != null){
				$result = $result->getFirst()->getElements();
				
				$perfil->setId($result[0]);
				$perfil->setNome($result[1]);
				$perfil->setDescricao($result[2]);
			}
			
			return $perfil;
		}
	
	    public function consultarTodosPerfis(){
			$fields = array("id", "nome", "descricao");
			$this->getDaoManager()->setTable("tb_perfil order by id desc");
			$this->getDaoManager()->setFields($fields);
			return $this->getDaoManager()->doRead();
		}
}

?>
