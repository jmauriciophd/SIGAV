<?php
/**
 * Classe dao do cliente
 * @author Rafael Dias
 */
class ClienteDao extends AbstractEntityDao
{
	private $enderecoDao;
	private $contatoDao;
	
	public function __construct(){
		parent::AbstractEntityDao();
		$this->contatoDao = new ContatoDao();
		$this->enderecoDao = new EnderecoDao();
	}
	
	public function inserir(Cliente $novoCliente)
	{ 
		//Inicia a transação
		$this->getDaoManager()->begin();
		//define a tabela, os campos e os valores a serem persistido no banco de dados
		$this->getDaoManager()->setTable("tb_cliente");
		$this->getDaoManager()->addColumn("cpf");
		$this->getDaoManager()->addValue($novoCliente->getCpf());
		$this->getDaoManager()->addColumn("rg");
		$this->getDaoManager()->addValue($novoCliente->getRg());
		$this->getDaoManager()->addColumn("nome");
		$this->getDaoManager()->addValue($novoCliente->getNome());
		$this->getDaoManager()->addColumn("orgao_expeditor");
		$this->getDaoManager()->addValue($novoCliente->getOrgaoExpedicao());
		$this->getDaoManager()->addColumn("uf_orgao_expeditor");
		$this->getDaoManager()->addValue($novoCliente->getUfExpedicao());
		$this->getDaoManager()->addColumn("estado_civil");
		$this->getDaoManager()->addValue($novoCliente->getEstadoCivil());
		$this->getDaoManager()->addColumn("sexo");
		$this->getDaoManager()->addValue($novoCliente->getSexo());
		$this->getDaoManager()->addColumn("data_nascimento");
		$this->getDaoManager()->addValue($novoCliente->getDataNascimento());
		$this->getDaoManager()->addColumn("id_medidas");
		$this->getDaoManager()->addValue($novoCliente->getMedidas()->getId());
		//metodo que insere os dados no banco
		$this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->reset();
			$result = $this->enderecoDao->inserir($novoCliente->getEndereco())
			&& $this->contatoDao->inserir($novoCliente->getContato());
			if($result){
				//realiza um cominte no banco
				$this->getDaoManager()->commit();
				$this->getDaoManager()->reset();
		 		return true;
			} else{
				//realiza um rollback no banco
				$this->getDaoManager()->rollback();
				$this->getDaoManager()->reset();
		 		return false;
			}
		} else{
			//desfaz a transação
			$this->getDaoManager()->rollback();
			$this->getDaoManager()->reset();
		 	return false;
		}
	}
	
	public function alterar(Cliente $cliente){
			$this->getDaoManager()->begin();
			$enderecoAlterado = $this->enderecoDao->alterar($cliente->getEndereco());
	    	$contatoAlterado  = $this->contatoDao->alterar($cliente->getContato());
			
	    	if($enderecoAlterado && $contatoAlterado){
				$this->getDaoManager()->reset();
				$this->getDaoManager()->setTable("tb_cliente");
				$this->getDaoManager()->addColumn("rg");
			    $this->getDaoManager()->addValue($cliente->getRg());
			    $this->getDaoManager()->addColumn("nome");
				$this->getDaoManager()->addValue($cliente->getNome());
				$this->getDaoManager()->addColumn("orgao_expeditor");
			    $this->getDaoManager()->addValue($cliente->getOrgaoExpedicao());
			    $this->getDaoManager()->addColumn("uf_orgao_expeditor");
			    $this->getDaoManager()->addValue($cliente->getUfExpedicao());
			    $this->getDaoManager()->addColumn("estado_civil");
			    $this->getDaoManager()->addValue($cliente->getEstadoCivil());
			    $this->getDaoManager()->addColumn("sexo");
			    $this->getDaoManager()->addValue($cliente->getSexo());
			    $this->getDaoManager()->addColumn("data_nascimento");
			    $this->getDaoManager()->addValue($cliente->getDataNascimento());
				$filterCpf = new SQLFilter("cpf", "=", $cliente->getCpf());
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
		
	public function excluir($cpf){
		$filter = "";
		$this->getDaoManager()->begin();
		$enderecoExcluido = $this->enderecoDao->excluir($cpf);
		$contatoExcluido = $this->contatoDao->excluir($cpf);
		if($cpf != NULL && $enderecoExcluido && $contatoExcluido) {
			$filterCpf = new SQLFilter("cpf", "=", $cpf);
			$filter = $filterCpf->dump();
			$this->getDaoManager()->setTable("tb_cliente");
			$this->getDaoManager()->setQueryFilter($filter);
			$this->getDaoManager()->doDelete();
			if($this->getDaoManager()->getSize() > 0){
				$this->getDaoManager()->commit();
				$this->getDaoManager()->reset();
				return "FuncionÃ¡rio excluido com sucesso.";
			} else {
				$this->getDaoManager()->rollback();
				$this->getDaoManager()->reset();
				return false;
			}
		} else {
			$this->getDaoManager()->rollback();
			$this->getDaoManager()->reset();
			return false;
		}
	}
	
	public function consultarClientePorCpf($cpf){
		$this->getDaoManager()->reset();
		$fields = array("c.cpf", "c.rg", "c.nome", "c.orgao_expeditor", "c.uf_orgao_expeditor", 
		"c.sexo", "c.data_nascimento", "c.estado_civil", 
	    "e.cep", "e.logradouro", "e.bairro", "e.numero", "e.cidade", "e.estado", "e.complemento", 
		"co.email", "co.tel_celular", "co.tel_residencial",  "co.twitter", "co.facebook", 
		"m.id", "m.tamanho", "m.busto_torax", "m.cintura", "m.quadril", "m.altura_frente", "m.ombro", 
		"m.costas", "m.braco", "m.observacao");
		
		$filter = "";
		$filterCpf = new SQLFilter("c.cpf", "=", $cpf);
		$filter = $filterCpf->dump();

		$this->getDaoManager()->setTable("tb_cliente c inner join tb_contato co on c.cpf = co.cpf_cnpj
										  inner join tb_endereco e on c.cpf = e.cpf_cnpj
										  inner join tb_medidas m on c.id_medidas = m.id");
		
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();

		$cliente = new Cliente();
		$contato = new Contato();
		$endereco = new Endereco();
		$medidas = new Medidas();
		
		if($result != null && $result->getFirst() != null) {
			$result = $result->getFirst()->getElements();
			
			$cliente->setCpf($result[0]);
			$cliente->setRg($result[1]);
			$cliente->setNome($result[2]);
			$cliente->setOrgaoExpedicao($result[3]);
			$cliente->setUfExpedicao($result[4]);
			$cliente->setSexo($result[5]);
			$cliente->setDataNascimento($result[6]);
			$cliente->setEstadoCivil($result[7]);
					
			$endereco->setCpfCnpj($result[0]);
			$endereco->setCep($result[8]);
			$endereco->setLogradouro($result[9]);
			$endereco->setBairro($result[10]);
			$endereco->setNumero($result[11]);
			$endereco->setCidade($result[12]);
			$endereco->setEstado($result[13]);
			$endereco->setComplemento($result[14]);
			
			$contato->setCpfCnpj($result[0]);
			$contato->setEmail($result[15]);
			$contato->setTelCelular($result[16]);
			$contato->setTelResidencial($result[17]);
			$contato->setTwitter($result[18]);
			$contato->setFacebook($result[19]);
			
			$medidas->setId($result[20]);
			$medidas->setTamanho($result[21]);
			$medidas->setBustoTorax($result[22]);
			$medidas->setCintura($result[23]);
			$medidas->setQuadril($result[24]);
			$medidas->setAlturaFrente($result[25]);
			$medidas->setOmbro($result[26]);
			$medidas->setCostas($result[27]);
			$medidas->setBraco($result[28]);
			$medidas->setObservacao($result[29]);
		}
		
		$cliente->setContato($contato);
	    $cliente->setEndereco($endereco);
	    $cliente->setMedidas($medidas);
		
		return $cliente;
		
	}
	
	public function consultarTodosClientes(){
		$fields = array("c.cpf", "c.rg","c.nome", "c.estado_civil","c.data_nascimento","c.sexo","c.orgao_expeditor", "c.uf_orgao_expeditor",   
		"e.cep", "e.logradouro", "e.bairro", "e.numero", "e.complemento", "e.cidade", "e.estado", 
		"co.email", "co.tel_celular", "co.tel_residencial","co.twitter", "co.facebook");
		
		$this->getDaoManager()->setTable("tb_cliente c inner join tb_endereco e on c.cpf = e.cpf_cnpj 
		inner join tb_contato co on c.cpf = co.cpf_cnpj");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setFields($fields);
		return $this->getDaoManager()->doRead();
	}	
	
	public function consultarClientePorCpfLike($cpf){
			$conn = MysqlFactory::conectarBancoMysql();
			$sql = "SELECT cpf FROM tb_cliente WHERE cpf LIKE ('$cpf%')";
			$query = mysql_query($sql) or die("Erro na consulta");
			return $query;
	}
	
}

?>