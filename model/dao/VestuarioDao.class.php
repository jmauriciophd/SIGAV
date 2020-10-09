<?php
/**
 * Description of VestuarioDAO
 *
 * @author reginaldo.junior
 */

class VestuarioDao extends AbstractEntityDao
{
   private $categoriaDao;
	public function __construct(){
		parent::AbstractEntityDao();
		$this->categoriaDao= new CategoriaDao(); 
	}

    public function inserir(Vestuario $vestuario) {
    	$this->getDaoManager()->reset();
    	//Inicia a transaчуo
   		$this->getDaoManager()->begin();
   		//define a tabela, os campos e os valores a serem persistido no banco de dados
		$this->getDaoManager()->setTable("tb_vestuario");
		$this->getDaoManager()->addColumn("cnpj_fornecedor");
		$this->getDaoManager()->addValue($vestuario->getFornecedor()->getCnpj());
		$this->getDaoManager()->addColumn("nome");
		$this->getDaoManager()->addValue($vestuario->getNome());
		$this->getDaoManager()->addColumn("codigo_categoria");
		$this->getDaoManager()->addValue($vestuario->getCategoria()->getCodigo());
		$this->getDaoManager()->addColumn("tamanho");
		$this->getDaoManager()->addValue($vestuario->getTamanho());
		$this->getDaoManager()->addColumn("medidas");
		$this->getDaoManager()->addValue($vestuario->getMedidas());
		$this->getDaoManager()->addColumn("cor");
		$this->getDaoManager()->addValue($vestuario->getCor());
		$this->getDaoManager()->addColumn("valor_vestuario");
		$this->getDaoManager()->addValue($vestuario->getValorVestuario());
		$this->getDaoManager()->addColumn("valor_aluguel");
		$this->getDaoManager()->addValue($vestuario->getValorAluguel());
	    $this->getDaoManager()->addColumn("observacao");
		$this->getDaoManager()->addValue($vestuario->getObservacao());
		$this->getDaoManager()->addColumn("quantidade");
		$this->getDaoManager()->addValue($vestuario->getQuantidade());
    	//metodo que insere os dados no banco
		$this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
				//realiza um cominte no banco
				$this->getDaoManager()->commit();
				$this->getDaoManager()->reset();
		 		return $this->getIdGerado();
		} else {
			//realiza um rollback no banco
			$this->getDaoManager()->rollback();
			$this->getDaoManager()->reset();
	 		return false;
		}
    }
   
	public function alterar(Vestuario $vestuario){
			$this->getDaoManager()->reset();
			$this->getDaoManager()->begin();
			$this->getDaoManager()->setTable("tb_vestuario");
			$this->getDaoManager()->addColumn("cnpj_fornecedor");
			$this->getDaoManager()->addValue($vestuario->getFornecedor()->getCnpj());
			$this->getDaoManager()->addColumn("nome");
			$this->getDaoManager()->addValue($vestuario->getNome());
			$this->getDaoManager()->addColumn("codigo_categoria");
			$this->getDaoManager()->addValue($vestuario->getCategoria()->getCodigo());
			$this->getDaoManager()->addColumn("tamanho");
			$this->getDaoManager()->addValue($vestuario->getTamanho());
			$this->getDaoManager()->addColumn("medidas");
			$this->getDaoManager()->addValue($vestuario->getMedidas());
			$this->getDaoManager()->addColumn("cor");
			$this->getDaoManager()->addValue($vestuario->getCor());
			$this->getDaoManager()->addColumn("valor_vestuario");
			$this->getDaoManager()->addValue($vestuario->getValorVestuario());
			$this->getDaoManager()->addColumn("valor_aluguel");
			$this->getDaoManager()->addValue($vestuario->getValorAluguel());
		    $this->getDaoManager()->addColumn("observacao");
			$this->getDaoManager()->addValue($vestuario->getObservacao());
			$this->getDaoManager()->addColumn("quantidade");
			$this->getDaoManager()->addValue($vestuario->getQuantidade());
			
			$filterId = new SQLFilter("id", "=", $vestuario->getId());
			$filter = $filterId->dump();
		    $this->getDaoManager()->setQueryFilter($filter);
			$this->getDaoManager()->doUpdate();
			
			if($this->getDaoManager()->rowsChanged()){
				$this->getDaoManager()->commit();
				$this->getDaoManager()->reset();
				return true;
			} else if($this->getDaoManager()->getErrorNo() != null && $this->getDaoManager()->getErrorNo() != "") {
				$this->getDaoManager()->rollback();
				$this->getDaoManager()->reset();
				return false;
			} else {
				return true;
			}
	}
	
	public function excluir($id){
		$this->getDaoManager()->begin();
		$filterId = new SQLFilter("id", "=", $id);
		$filter = $filterId->dump();
		$this->getDaoManager()->setTable("tb_vestuario");
		$this->getDaoManager()->setQueryFilter($filter);
		$this->getDaoManager()->doDelete();
		
		if($this->getDaoManager()->getSize() > 0){
			$this->getDaoManager()->commit();
			$this->getDaoManager()->reset();
		} else {
			$this->getDaoManager()->rollback();
			$this->getDaoManager()->reset();
			return false;
		}
	}
	
	public function consultarVestuarioPorId($id){
		$fields = array("v.id", "v.nome", "v.cnpj_fornecedor", "v.cor", "v.medidas", "v.tamanho", "v.valor_vestuario", 
						"v.valor_aluguel", "v.observacao", "v.quantidade", "v.codigo_categoria", "c.descricao");

		$filter = "";
		$filterId = new SQLFilter("v.id", "=", $id);
		$filter = $filterId->dump();

		$this->getDaoManager()->setTable("tb_vestuario v inner join tb_categoria c on v.codigo_categoria = c.codigo");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		
		//print_r($result);
		$vestuario = new Vestuario();
		$fornecedor = new Fornecedor();
		$categoria = new Categoria();

		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			
			$vestuario->setId($result[0]);
			$vestuario->setNome($result[1]);
			$fornecedor->setCnpj($result[2]);
			$vestuario->setCor($result[3]);
			$vestuario->setMedidas($result[4]);
			$vestuario->setTamanho($result[5]);
			$vestuario->setValorVestuario($result[6]);
			$vestuario->setValorAluguel($result[7]);
			$vestuario->setObservacao($result[8]);
			$vestuario->setQuantidade($result[9]);
			$categoria->setCodigo($result[10]);
			$categoria->setDescricao($result[11]);
		}
		   
		$vestuario->setFornecedor($fornecedor);
		$vestuario->setCategoria($categoria);
		
		return $vestuario;
	}
	
	public function consultarVestuarioPorNome($nome){
		$fields = array("v.id", "v.nome", "v.cnpj_fornecedor", "v.cor", "v.medidas", "v.tamanho", "v.valor_vestuario", 
						"v.valor_aluguel", "v.observacao", "v.codigo_categoria",
						"c.codigo", "v.quantidade");

		$filter = "";
		$filterId = new SQLFilter("v.nome", "=", $nome);
		$filter = $filterId->dump();

		$this->getDaoManager()->setTable("tb_vestuario v inner join tb_categoria c on v.codigo_categoria = c.codigo");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		
		//print_r($result);
		$vestuario = new Vestuario();
		$fornecedor = new Fornecedor();
		$categoria =new Categoria();

		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			
			$vestuario->setId($result[0]);
			$vestuario->setNome($result[1]);
			$fornecedor->setCnpj($result[2]);
			$vestuario->setCor($result[3]);
			$vestuario->setMedidas($result[4]);
			$vestuario->setTamanho($result[5]);
			$vestuario->setValorVestuario($result[6]);
			$vestuario->setValorAluguel($result[7]);
			$vestuario->setObservacao($result[8]);
			$categoria->setCodigo($result[9]);
            $vestuario->setQuantidade($result[11]);
		}
		   
		$vestuario->setFornecedor($fornecedor);
        $vestuario->setCategoria($categoria);
            
		return $vestuario;
	}
	
	public function consultarVestuarioLike($param){
			$conn = MysqlFactory::conectarBancoMysql();
			$sql = "SELECT v.id, v.nome FROM tb_vestuario v INNER JOIN tb_categoria c ON v.codigo_categoria = c.codigo ";
			$sql .= "WHERE v.id LIKE ('$param%') OR v.nome LIKE ('$param%') OR c.descricao LIKE ('$param%')";
			$query = mysql_query($sql) or die("Erro na consulta do vestuсrio");
			return $query;
	}
	
	public function consultarTodosVestuarios(){
		$fields = array("v.id", "v.nome", "v.cor", "v.medidas", "v.tamanho", 
				  "v.valor_aluguel", "v.cnpj_fornecedor", "v.valor_vestuario", "v.observacao", "c.codigo", "c.descricao as desc_categoria");

		$this->getDaoManager()->setTable("tb_vestuario v inner join tb_categoria c on v.codigo_categoria = c.codigo");
		$this->getDaoManager()->setFields($fields);
		return $this->getDaoManager()->doRead();
	}
	
}
?>