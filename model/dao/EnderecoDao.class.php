<?php
/**
 * Classe dao do endereco
 * @author Rafael Dias
 * 
 */
class EnderecoDao extends AbstractEntityDao
{

	public function __construct(){
		parent::AbstractEntityDao();
	}
	
	public function inserir(Endereco $novoEndereco)
	{
		$this->getDaoManager()->setTable("tb_endereco");
		$this->getDaoManager()->addColumn("cpf_cnpj");
		$this->getDaoManager()->addValue($novoEndereco->getCpfCnpj());
		$this->getDaoManager()->addColumn("cep");
		$this->getDaoManager()->addValue($novoEndereco->getCep());
		$this->getDaoManager()->addColumn("bairro");
		$this->getDaoManager()->addValue($novoEndereco->getBairro());
		$this->getDaoManager()->addColumn("logradouro");
		$this->getDaoManager()->addValue($novoEndereco->getLogradouro());
		$this->getDaoManager()->addColumn("numero");
		$this->getDaoManager()->addValue($novoEndereco->getNumero());
		$this->getDaoManager()->addColumn("complemento");
		$this->getDaoManager()->addValue($novoEndereco->getComplemento());
		$this->getDaoManager()->addColumn("cidade");
		$this->getDaoManager()->addValue($novoEndereco->getCidade());
		$this->getDaoManager()->addColumn("estado");
		$this->getDaoManager()->addValue($novoEndereco->getEstado());
		$this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->reset();
			$this->getDaoManager()->commit();
			return true;
		} else{
			$this->getDaoManager()->rollback();
		 	return false;
		}
	}
	
	public function alterar(Endereco $endereco){
		$this->getDaoManager()->reset();
		$this->getDaoManager()->begin();
		$this->getDaoManager()->setTable("tb_endereco");
		$this->getDaoManager()->addColumn("cep");
		$this->getDaoManager()->addValue($endereco->getCep());
		$this->getDaoManager()->addColumn("bairro");
		$this->getDaoManager()->addValue($endereco->getBairro());
		$this->getDaoManager()->addColumn("logradouro");
		$this->getDaoManager()->addValue($endereco->getLogradouro());
		$this->getDaoManager()->addColumn("numero");
		$this->getDaoManager()->addValue($endereco->getNumero());
		$this->getDaoManager()->addColumn("complemento");
		$this->getDaoManager()->addValue($endereco->getComplemento());
		$this->getDaoManager()->addColumn("cidade");
		$this->getDaoManager()->addValue($endereco->getCidade());
		$this->getDaoManager()->addColumn("estado");
		$this->getDaoManager()->addValue($endereco->getEstado());
		$filterCpf = new SQLFilter("cpf_cnpj", "=", $endereco->getCpfCnpj());
		$filter = $filterCpf->dump();
		$this->getDaoManager()->setQueryFilter($filter);
		$this->getDaoManager()->doUpdate();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->reset();
			return true;
		} else if ($this->getDaoManager()->getErrorNo() != null && $this->getDaoManager()->getErrorNo() != ""){
		 	$this->getDaoManager()->rollback();
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
			$this->getDaoManager()->setTable("tb_endereco");
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
	
}

?>