<?php

/**
 * Description of PerfilDAO
 *
 * @author José Mauricio
 */
class PagamentoDao extends AbstractEntityDao {

    public function __construct() {
        parent::AbstractEntityDao();
    }

    public function inserir(Pagamento $pagamento) {

        $this->getDaoManager()->begin();
        $this->getDaoManager()->setTable("tb_pagamento");
        $this->getDaoManager()->addColumn("id");
        $this->getDaoManager()->addValue($pagamento->getId());
        $this->getDaoManager()->addColumn("tipo_pagamento");
        $this->getDaoManager()->addValue($pagamento->getTipoPagamento());
        $this->getDaoManager()->addColumn("num_parcelas");
        $this->getDaoManager()->addValue($pagamento->getNumParcelas());
        $this->getDaoManager()->addColumn("valor_parcelas");
        $this->getDaoManager()->addValue($pagamento->getValorParcelas());
        $this->getDaoManager()->addColumn("entrada");
        $this->getDaoManager()->addValue($pagamento->getEntrada());
        $this->getDaoManager()->addColumn("falta_pagar");
        $this->getDaoManager()->addValue($pagamento->getFaltaPagar());
        $this->getDaoManager()->addColumn("multa");
        $this->getDaoManager()->addValue($pagamento->getMulta());
        $this->getDaoManager()->doInsert();

        if ($this->getDaoManager()->rowsChanged()) {
            $this->getDaoManager()->commit();
            $this->getDaoManager()->reset();
            return $this->getIdGerado();
        } else {
            $this->getDaoManager()->rollback();
            $this->getDaoManager()->reset();
            return 0;
        }
    }

    public function alterar(Pagamento $pagamento, $numDocumentoAntigo) {
        $this->getDaoManager()->begin();
        $this->getDaoManager()->setTable("tb_funcionario");
        $this->getDaoManager()->addColumn("tipo_pagamento");
        $this->getDaoManager()->addValue($pagamento->getTipoPagamento());
        $this->getDaoManager()->addColumn("num_parcelas");
        $this->getDaoManager()->addValue($pagamento->getNumParcelas());
        $this->getDaoManager()->addColumn("valor_parcelas");
        $this->getDaoManager()->addValue($pagamento->getValorParcelas());
        $this->getDaoManager()->addColumn("entrada");
        $this->getDaoManager()->addValue($pagamento->getEntrada());
        $this->getDaoManager()->addColumn("falta_pagar");
        $this->getDaoManager()->addValue($pagamento->getFaltaPagar());
        $this->getDaoManager()->addColumn("multa");
        $this->getDaoManager()->addValue($pagamento->getMulta());
        $filternumDocumento = new SQLFilter("numDocumento", "=", $numDocumentoAntigo);
        $filter = $filternumDocumento->dump();
        $this->getDaoManager()->setQueryFilter($filter);
        $this->getDaoManager()->doUpdate();

        if ($this->getDaoManager()->rowsChanged()) {
            $this->getDaoManager()->commit();
            $this->getDaoManager()->reset();
            return true;
        } else if($this->getDaoManager()->getErrorNo() != null && $this->getDaoManager()->getErrorNo() != "") {
            $this->getDaoManager()->rollback();
            $this->getDaoManager()->reset();
            return false;
        }
    }

    public function excluir($id) {
        $this->getDaoManager()->begin();
        $this->getDaoManager()->setTable("tb_pagamento");
        $filterCpf = new SQLFilter("id", "=", $id);
        $filter = $filterCpf->dump();
        $this->getDaoManager()->setQueryFilter($filter);
        $this->getDaoManager()->doDelete();

        if ($this->getDaoManager()->getSize() > 0) {
            $this->getDaoManager()->commit();
            $this->getDaoManager()->reset();
            return true;
        } else {
            $this->getDaoManager()->rollback();
            $this->getDaoManager()->reset();
            return false;
        }
    }

	public function consultarPagamentoPorId($id){
		$fields = array("id", "tipo_pagamento", "num_parcelas", "valor_parcelas", "entrada", "falta_pagar", "multa");
		$filterId = new SQLFilter("id", "=", $id);
		$filter = $filterId->dump();
		
		$this->getDaoManager()->setTable("tb_pagamento");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		
		$pagamento = new Pagamento();
		
		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			
			$pagamento->setId($result[0]);
			$pagamento->setTipoPagamento($result[1]);
			$pagamento->setNumParcelas($result[2]);
			$pagamento->setValorParcelas($result[3]);
			$pagamento->setEntrada($result[4]);
			$pagamento->setFaltaPagar($result[5]);
			$pagamento->setMulta($result[6]);
		}
		
		return $pagamento;
	}
}

?>
