<?php
class AluguelDao extends AbstractEntityDao
{

	private $aluguelVestuarioDao = null;
	
	public function __construct(){
		parent::AbstractEntityDao();
		$this->aluguelVestuarioDao = new AluguelVestuarioDao();
	}

    public function inserir(Aluguel $aluguel) {
    	$this->getDaoManager()->begin();
		$this->getDaoManager()->setTable("tb_aluguel");
		$this->getDaoManager()->addColumn("id");
		$this->getDaoManager()->addValue($aluguel->getId());
		$this->getDaoManager()->addColumn("valor_total_aluguel");
		$this->getDaoManager()->addValue($aluguel->getValorTotalAluguel());
		$this->getDaoManager()->addColumn("data_entrega");
		$this->getDaoManager()->addValue($aluguel->getDataEntrega());
		$this->getDaoManager()->addColumn("data_locacao");
		$this->getDaoManager()->addValue($aluguel->getDataLocacao());
		$this->getDaoManager()->addColumn("data_prevista_devolucao");
		$this->getDaoManager()->addValue($aluguel->getDataPrevistaDevolucao());
		$this->getDaoManager()->addColumn("data_previa");
		$this->getDaoManager()->addValue($aluguel->getDataPrevia());
		$this->getDaoManager()->addColumn("data_prova");
		$this->getDaoManager()->addValue($aluguel->getDataProva());
		$this->getDaoManager()->addColumn("cpf_usuario");
		$this->getDaoManager()->addValue($aluguel->getUsuario()->getCpf());
		$this->getDaoManager()->addColumn("cpf_cliente");
		$this->getDaoManager()->addValue($aluguel->getCliente()->getCpf());
		$this->getDaoManager()->addColumn("id_pagamento");
		$this->getDaoManager()->addValue($aluguel->getPagamento()->getId());
		$this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->commit();
			$this->getDaoManager()->reset();
			return $this->getIdGerado();
		} else {
			$this->getDaoManager()->rollback();
		 	return 0;
		}
	}
   
	public function excluir($id) {
			$this->getDaoManager()->begin();
			$this->getDaoManager()->setTable("tb_aluguel");
			$filterId = new SQLFilter("id", "=", $id);
			$filter = $filterId->dump();
			$this->getDaoManager()->setQueryFilter($filter);
			$this->getDaoManager()->doDelete();
			
			if($this->getDaoManager()->getSize() > 0){
				$this->getDaoManager()->commit();
				$this->getDaoManager()->reset();
				return true;
			} else{
				$this->getDaoManager()->rollback();
				return false;
			}
	}
	
	public function consultarAluguelPorId($id){
		$fields = array("a.id", "a.valor_total_aluguel", "a.data_locacao", "a.data_prevista_devolucao",
						"a.cpf_usuario",  "a.cpf_cliente", "a.id_pagamento");
		$filterCpf = new SQLFilter("a.id", "=", $id);
		$filter = $filterCpf->dump();
		
		$this->getDaoManager()->setTable("tb_aluguel a");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		
		$aluguel = new Aluguel();
		$cliente = new Cliente();
		$usuario = new Usuario();
		$pagamento = new Pagamento();
		
		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			
			$aluguel->setId($result[0]);
			$aluguel->setValorTotalAluguel($result[1]);
			$aluguel->setDataLocacao($result[2]);
			$aluguel->setDataPrevistaDevolucao($result[3]);
			$usuario->setCpf($result[4]);
			$cliente->setCpf($result[5]);
			$pagamento->setId($result[6]);
		}
		
		$aluguel->setCliente($cliente);
		$aluguel->setUsuario($usuario);
		$aluguel->setPagamento($pagamento);
		
		return $aluguel;
	} 
	
	public function consultarTodosAlugueis(){
		$fields = array("a.id", "c.nome", "a.valor_total_aluguel", "a.data_locacao", "a.data_prevista_devolucao");
		$tableInnerJoin = "tb_aluguel a inner join tb_cliente c on a.cpf_cliente = c.cpf 
				 		 inner join tb_usuario u on a.cpf_usuario = u.cpf";
		$this->getDaoManager()->setTable($tableInnerJoin);
		$this->getDaoManager()->setFields($fields);
		return $this->getDaoManager()->doRead();
	}
	
	public function consultarAluguel(AluguelFilter $aluguelFilter){
		$filter = "1=1";
		if($aluguelFilter->getCpfCliente() != ""){
			$filterCpfCliente = new SQLFilter("a.cpf_cliente", "=", $aluguelFilter->getCpfCliente());
			$filter .= " and " . $filterCpfCliente->dump();
		}
		if($aluguelFilter->getNomeCliente() != ""){
			$filterNomeCliente = new SQLFilter("c.nome_cliente", "=", $aluguelFilter->getNomeCliente());
			$filter .= " and " . $filterNomeCliente->dump();
		}
		if($aluguelFilter->getCpfFuncionario() != ""){
			$filterCpfFuncionario = new SQLFilter("a.cpf_usuario", "=", $aluguelFilter->getCpfFuncionario());
			$filter .= " and " . $filterCpfFuncionario->dump();
		}
		if($aluguelFilter->getNomeFuncionario() != ""){
			$filterNomeFuncionario = new SQLFilter("u.nome_usuario", "=", $aluguelFilter->getCpfFuncionario());
			$filter .= " and " . $filterNomeFuncionario->dump();
		}
		
		$fields = array("a.id", "c.cpf as cpf_cliente", "c.nome as nome_cliente", "u.cpf as cpf_usuario", "u.nome as nome_usuario",
						"a.data_locacao", "date_format(a.data_prevista_devolucao, '%d/%m/%Y')", "a.valor_total_aluguel");
		
		$tableInnerJoin = "tb_aluguel a inner join tb_cliente c on a.cpf_cliente = c.cpf 
				 		 inner join tb_usuario u on a.cpf_usuario = u.cpf";
		
		$this->getDaoManager()->setTable($tableInnerJoin);
		
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		return $this->getDaoManager()->doRead();
	}
	
}

?>

