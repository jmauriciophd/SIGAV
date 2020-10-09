<?php

/**
 * Classe dao do contato
 * @author Rafael Dias
 * 
 */
class ContatoDao extends AbstractEntityDao
{

	public function __construct(){
		parent::AbstractEntityDao();
	}
	
	public function inserir(Contato $novoContato)
	{
		$this->getDaoManager()->setTable("tb_contato");
		$this->getDaoManager()->addColumn("cpf_cnpj");
		$this->getDaoManager()->addValue($novoContato->getCpfCnpj());
		$this->getDaoManager()->addColumn("email");
		$this->getDaoManager()->addValue($novoContato->getEmail());
		$this->getDaoManager()->addColumn("tel_residencial");
		$this->getDaoManager()->addValue($novoContato->getTelResidencial());
		$this->getDaoManager()->addColumn("tel_comercial");
		$this->getDaoManager()->addValue($novoContato->getTelComercial());
		$this->getDaoManager()->addColumn("tel_celular");
		$this->getDaoManager()->addValue($novoContato->getTelCelular());
		$this->getDaoManager()->addColumn("twitter");
		$this->getDaoManager()->addValue($novoContato->getTwitter());
		$this->getDaoManager()->addColumn("facebook");
		$this->getDaoManager()->addValue($novoContato->getFacebook());
		$this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->reset();
			return true;
		} else{
			$this->getDaoManager()->rollback();
		 	return false;
		}
	}
	
	
	public function alterar(Contato $contato){
		$this->getDaoManager()->reset();
		$this->getDaoManager()->begin();
		$this->getDaoManager()->setTable("tb_contato");
		$this->getDaoManager()->addColumn("email");
		$this->getDaoManager()->addValue($contato->getEmail());
		$this->getDaoManager()->addColumn("tel_residencial");
		$this->getDaoManager()->addValue($contato->getTelResidencial());
		$this->getDaoManager()->addColumn("tel_comercial");
		$this->getDaoManager()->addValue($contato->getTelComercial());
		$this->getDaoManager()->addColumn("tel_celular");
		$this->getDaoManager()->addValue($contato->getTelCelular());
		$this->getDaoManager()->addColumn("twitter");
		$this->getDaoManager()->addValue($contato->getTwitter());
		$this->getDaoManager()->addColumn("facebook");
		$this->getDaoManager()->addValue($contato->getFacebook());
		$filterCpf = new SQLFilter("cpf_cnpj", "=", $contato->getCpfCnpj());
		$filter = $filterCpf->dump();
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
	
	public function excluir($cpfCnpj){
		$filter = "";
		if($cpfCnpj != NULL){
			$filterCpf = new SQLFilter("cpf_cnpj", "=", $cpfCnpj);
			$filter = $filterCpf->dump();
			$this->getDaoManager()->setTable("tb_contato");
			$this->getDaoManager()->setQueryFilter($filter);
			$this->getDaoManager()->doDelete();
		}
		if($this->getDaoManager()->getSize() > 0){
			$this->getDaoManager()->reset();
			return true;
		} else{
			$this->getDaoManager()->rollback();
		 	return false;
		}
	}
	
	public function consultar(Contato $contato){
	}
	
}

?>