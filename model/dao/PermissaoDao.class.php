<?php
class PermissaoDao extends AbstractEntityDao
{

	public function __construct(){
		parent::AbstractEntityDao();
	}

    public function inserir(Permissao $permissao) {
    	$this->getDaoManager()->reset();
   		$this->getDaoManager()->begin();
		$this->getDaoManager()->setTable("tb_permissao_acesso");
		$this->getDaoManager()->addColumn("id_perfil");
		$this->getDaoManager()->addValue($permissao->getPerfil()->getId());
		$this->getDaoManager()->addColumn("id_aplicacao");
		$this->getDaoManager()->addValue($permissao->getAplicacao()->getId());
		$this->getDaoManager()->addColumn("flg_acessar");
		$this->getDaoManager()->addValue($permissao->getAcessa());
		$this->getDaoManager()->addColumn("flg_consultar");
		$this->getDaoManager()->addValue($permissao->getConsulta());
		$this->getDaoManager()->addColumn("flg_cadastrar");
		$this->getDaoManager()->addValue($permissao->getCadastra());
		$this->getDaoManager()->addColumn("flg_atualizar");
		$this->getDaoManager()->addValue($permissao->getAtualiza());
		$this->getDaoManager()->addColumn("flg_excluir");
		$this->getDaoManager()->addValue($permissao->getExclui());
		$this->getDaoManager()->addColumn("flg_imprimir");
		$this->getDaoManager()->addValue($permissao->getImprimi());
		
        $this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->commit();
			$this->getDaoManager()->reset();
			return $this->getDaoManager()->getIdGerado();
		} else{
			$this->getDaoManager()->rollback();
			$this->getDaoManager()->reset();
		 	return 0;
		}
	 }
	 
	public function alterar(Permissao $permissao){
		$this->getDaoManager()->reset();
		$this->getDaoManager()->begin();
		$this->getDaoManager()->setTable("tb_permissao_acesso");
		$this->getDaoManager()->addColumn("flg_acessar");
		$this->getDaoManager()->addValue($permissao->getAcessa());
		$this->getDaoManager()->addColumn("flg_consultar");
		$this->getDaoManager()->addValue($permissao->getConsulta());
		$this->getDaoManager()->addColumn("flg_cadastrar");
		$this->getDaoManager()->addValue($permissao->getCadastra());
		$this->getDaoManager()->addColumn("flg_atualizar");
		$this->getDaoManager()->addValue($permissao->getAtualiza());
		$this->getDaoManager()->addColumn("flg_excluir");
		$this->getDaoManager()->addValue($permissao->getExclui());
		$this->getDaoManager()->addColumn("flg_imprimir");
		$this->getDaoManager()->addValue($permissao->getImprimi());
		$filterIdPerfil = new SQLFilter("id_perfil", "=", $permissao->getPerfil()->getId());
		$filter = $filterIdPerfil->dump();
		$filterIdAplicacao = new SQLFilter("id_aplicacao", "=", $permissao->getAplicacao()->getId());
		$filter .= " AND " . $filterIdAplicacao->dump();
		$this->getDaoManager()->setQueryFilter($filter);
		$this->getDaoManager()->doUpdate();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->commit();
			$this->getDaoManager()->reset();
			return true;
		} elseif($this->getDaoManager()->getErrorNo() != null && $this->getDaoManager()->getErrorNo() != ""){
			$this->getDaoManager()->rollback();
		 	return $this->getDaoManager()->getErrorMessage();
		} else {
			return true;
		}
	}
	  
	 public function consultarPermissaoPorPerfil($id){
	 	$this->getDaoManager()->reset();
		$fields = array("pa.id", "pa.flg_acessar", "pa.flg_consultar", "pa.flg_cadastrar", 
		"pa.flg_atualizar", "pa.flg_excluir", "pa.flg_imprimir",   
    	"pa.id_perfil", "p.nome", "p.descricao as desc_perfil", "pa.id_aplicacao", "a.nome_arquivo", "a.nome_aplicacao",  "a.modulo", "a.descricao as desc_aplicacao");
		
		$filter = new SQLFilter("pa.id_perfil", "=", $id);
		$filter = $filter->dump();			
			
		$this->getDaoManager()->setTable("tb_permissao_acesso pa inner join tb_perfil p on pa.id_perfil = p.id
			inner join tb_aplicacao a on pa.id_aplicacao = a.id");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		
		return $result=$this->getDaoManager()->doRead();
	 }
			
	public function consultarPermissaoPorId($idPerfil, $idAplicacao){
		$this->getDaoManager()->reset();
		$fields = array("pa.id", "pa.id_perfil", "pa.id_aplicacao", "pa.flg_acessar",
		"pa.flg_consultar", "pa.flg_cadastrar", "pa.flg_atualizar", "pa.flg_excluir", 
		"pa.flg_imprimir", "p.nome", "a.nome_arquivo");
		
		$this->getDaoManager()->setTable("tb_permissao_acesso pa 
					inner join tb_perfil p on pa.id_perfil = p.id
					inner join tb_aplicacao a on pa.id_aplicacao = a.id");
		
		$filterIdPerfil = new SQLFilter("id_perfil", "=", $idPerfil);
		$filter = $filterIdPerfil->dump();
		
		$filterIdAplicacao = new SQLFilter("id_aplicacao", "=", $idAplicacao);
		$filter .= " AND " . $filterIdAplicacao->dump();
		
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		
		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			
			$perfil = new Perfil();
			$perfil->setId($result[1]);
			
			$aplicacao = new Aplicacao();
			$aplicacao->setId($result[2]);
			
			$permissao = new Permissao();
			$permissao->setAplicacao($aplicacao);
			$permissao->setPerfil($perfil);
			
			return $permissao;
		} else{
			return null;
		}
	}
 }
?>
