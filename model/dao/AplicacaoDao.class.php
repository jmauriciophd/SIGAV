<?php
class AplicacaoDao extends AbstractEntityDao
{

	public function __construct(){
		parent::AbstractEntityDao();
	}

   
	public function consultarAplicacaoPorId($id){
		$fields = array("id", "nome_arquivo",  "nome_aplicacao", "descricao");
		$filterId = new SQLFilter("id", "=", $id);
		$filter = $filterId->dump();
		$this->getDaoManager()->setTable("tb_aplicacao");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		
		$aplicacao = new Aplicacao();
		
		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			
			$aplicacao->setId($result[0]);
			$aplicacao->setNomeArquivo($result[1]);
			$aplicacao->setNomeAplicacao($result[2]);
			$aplicacao->setDescricao($result[3]);
		}
		
		return $aplicacao;
	}
	
	public function consultarAplicacaoPorNomeArquivo($nomeArquivo){
		$fields = array("id", "nome_arquivo",  "nome_aplicacao", "descricao");
		$filterId = new SQLFilter("nome_arquivo", "=", $nomeArquivo);
		$filter = $filterId->dump();
		$this->getDaoManager()->setTable("tb_aplicacao");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		
		$aplicacao = new Aplicacao();
		
		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			
			$aplicacao->setId($result[0]);
			$aplicacao->setNomeArquivo($result[1]);
			$aplicacao->setNomeAplicacao($result[2]);
			$aplicacao->setDescricao($result[3]);
		}
		
		return $aplicacao;
	}
	
	public function consultarTodasAplicacoes(){
		$fields = array("id", "nome_arquivo",  "nome_aplicacao", "descricao");
		$this->getDaoManager()->setTable("tb_aplicacao");
		$this->getDaoManager()->setFields($fields);
		return $this->getDaoManager()->doRead();
	}
	
}

?>
