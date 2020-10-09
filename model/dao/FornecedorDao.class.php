<?php
/**
 * Classe dao do fornecedor
 * @author Rafael Dias
 */
class FornecedorDao extends AbstractEntityDao
{
	private $enderecoDao;
	private $contatoDao;
		
	public function __construct(){
		parent::AbstractEntityDao();
		$this->contatoDao = new ContatoDao();
		$this->enderecoDao = new EnderecoDao();
	}
	
	public function inserir(Fornecedor $novoFornecedor)
	{ 
		//Inicia a transaчуo
		$this->getDaoManager()->begin();
		//define a tabela, os campos e os valores a serem persistido no banco de dados
		$this->getDaoManager()->setTable("tb_fornecedor");
		$this->getDaoManager()->addColumn("cnpj");
		$this->getDaoManager()->addValue($novoFornecedor->getCnpj());
		$this->getDaoManager()->addColumn("razao_social");
		$this->getDaoManager()->addValue($novoFornecedor->getRazaoSocial());
		$this->getDaoManager()->addColumn("nome_fantasia");
		$this->getDaoManager()->addValue($novoFornecedor->getNomeFantasia());
		$this->getDaoManager()->addColumn("inscricao_estadual");
		$this->getDaoManager()->addValue($novoFornecedor->getInscricaoEstadual());
		//metodo que insere os dados no banco
		$this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->reset();
			$result = $this->enderecoDao->inserir($novoFornecedor->getEndereco())
			&& $this->contatoDao->inserir($novoFornecedor->getContato());
			if($result) {
		 		 //conclui a transaчуo
				 $this->getDaoManager()->commit();
				 $this->getDaoManager()->reset();
				 return true; 
			} else { 
				 $this->getDaoManager()->rollback();
				 $this->getDaoManager()->reset();
				 return false;
			}
		}
		 else{
			//desfaz a transaчуo
			$this->getDaoManager()->rollback();
			$this->getDaoManager()->reset();
		 	return false;
		}
	}
	
	public function alterar(Fornecedor $fornecedor){
		$this->getDaoManager()->begin();
		$enderecoAlterado = $this->enderecoDao->alterar($fornecedor->getEndereco());
		$contatoAlterado = $this->contatoDao->alterar($fornecedor->getContato());
		
		if($enderecoAlterado && $contatoAlterado){
			$this->getDaoManager()->reset();
			$this->getDaoManager()->setTable("tb_fornecedor");
			$this->getDaoManager()->addColumn("razao_social");
			$this->getDaoManager()->addValue($novoFornecedor->getRazaoSocial());
			$this->getDaoManager()->addColumn("nome_fantasia");
			$this->getDaoManager()->addValue($novoFornecedor->getNomeFantasia());
			$this->getDaoManager()->addColumn("inscricao_estadual");
			$this->getDaoManager()->addValue($novoFornecedor->getInscricaoEstadual());
			$filterCpf = new SQLFilter("cnpj", "=", $fornecedor->getCnpj());
			$filter = $filterCpf->dump();
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
		} else {
				$this->getDaoManager()->rollback();
				$this->getDaoManager()->reset();
				return false;
		}
	}
	public function excluir($cnpj){
		$filter = "";
		$this->getDaoManager()->begin();
		$enderecoExcluido = $this->enderecoDao->excluir($cnpj);
		$contatoExcluido = $this->contatoDao->excluir($cnpj);
		if($cnpj != NULL && $enderecoExcluido && $contatoExcluido){
			$filterCpf = new SQLFilter("cnpj", "=", $cnpj);
			$filter = $filterCpf->dump();
			$this->getDaoManager()->setTable("tb_fornecedor");
			$this->getDaoManager()->setQueryFilter($filter);
			$this->getDaoManager()->doDelete();
			if($this->getDaoManager()->getSize() > 0){
				$this->getDaoManager()->commit();
				$this->getDaoManager()->reset();
				return "Fornecedor excluido com sucesso.";
			} else{
				$this->getDaoManager()->rollback();
				$this->getDaoManager()->reset();
				return false;
			}
		} else{
			$this->getDaoManager()->rollback();
			$this->getDaoManager()->reset();
			return false;
		}
	}
	
	public function consultarFornecedorPorCnpj($cnpj){
		$fields = array("f.cnpj", "f.razao_social", "f.nome_fantasia", "f.inscricao_estadual", 
		"e.cep", "e.logradouro","e.bairro","e.numero","e.cidade","e.estado","e.complemento","c.email","c.tel_comercial");
		
		$filter = "";
		$filterCnpj = new SQLFilter("f.cnpj", "=", $cnpj);
		$filter = $filterCnpj->dump();

		$this->getDaoManager()->setTable("tb_fornecedor f inner join tb_contato c on f.cnpj = c.cpf_cnpj
			inner join tb_endereco e on f.cnpj = e.cpf_cnpj");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		
		$fornecedor = new Fornecedor();
		$contato = new Contato();
		$endereco = new Endereco();
		
		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			
			$fornecedor->setCnpj($result[0]);
			$fornecedor->setRazaoSocial($result[1]);
			$fornecedor->setNomeFantasia($result[2]);
			$fornecedor->setInscricaoEstadual($result[3]);
			
			$endereco->setCpfCnpj($result[0]);
			$endereco->setCep($result[4]);
			$endereco->setLogradouro($result[5]);
			$endereco->setBairro($result[6]);
			$endereco->setNumero($result[7]);
			$endereco->setCidade($result[8]);
			$endereco->setEstado($result[9]);
			$endereco->setComplemento($result[10]);
			
			$contato->setCpfCnpj($result[0]);
			$contato->setEmail($result[11]);
			$contato->setTelComercial($result[12]);
		
		}	
		
		   $fornecedor->setContato($contato);
		   $fornecedor->setEndereco($endereco);	
		   
		   return $fornecedor;
		
	}
	
	public function consultarTodosFornecedores(){
		$fields = array("f.cnpj", "f.razao_social", "f.nome_fantasia", "f.inscricao_estadual", 
		"e.cep", "e.logradouro","e.bairro","e.numero","e.cidade","e.estado","e.complemento","c.email","c.tel_comercial");
		
		$this->getDaoManager()->setTable("tb_fornecedor f inner join tb_contato c on f.cnpj = c.cpf_cnpj 
		inner join tb_endereco e on f.cnpj = e.cpf_cnpj");
		
		$this->getDaoManager()->setFields($fields);
		return $this->getDaoManager()->doRead();
	}
	
}

?>