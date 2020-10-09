<?php
/**
 * Classe dao do funcionario
 * @author Rafael Dias
 */
class FuncionarioDao extends AbstractEntityDao
{
	private $enderecoDao;
	private $contatoDao;
	private $usuarioDao;
	
	public function __construct(){
		parent::AbstractEntityDao();
		$this->contatoDao = new ContatoDao();
		$this->enderecoDao = new EnderecoDao();
		$this->usuarioDao = new UsuarioDao();
	}
	
	public function inserir(Funcionario $novoFuncionario)
	{ 
		//Inicia a transação
		$this->getDaoManager()->begin();
		//define a tabela, os campos e os valores a serem persistido no banco de dados
		$this->getDaoManager()->setTable("tb_funcionario");
		$this->getDaoManager()->addColumn("cpf");
		$this->getDaoManager()->addValue($novoFuncionario->getCpf());
		$this->getDaoManager()->addColumn("nome");
		$this->getDaoManager()->addValue($novoFuncionario->getNome());
		$this->getDaoManager()->addColumn("rg");
		$this->getDaoManager()->addValue($novoFuncionario->getRg());
		$this->getDaoManager()->addColumn("orgao_expeditor");
		$this->getDaoManager()->addValue($novoFuncionario->getOrgaoExpedicao());
		$this->getDaoManager()->addColumn("uf_orgao_expeditor");
		$this->getDaoManager()->addValue($novoFuncionario->getUfExpedicao());
		$this->getDaoManager()->addColumn("estado_civil");
		$this->getDaoManager()->addValue($novoFuncionario->getEstadoCivil());
		$this->getDaoManager()->addColumn("sexo");
		$this->getDaoManager()->addValue($novoFuncionario->getSexo());
		$this->getDaoManager()->addColumn("grau_instrucao");
		$this->getDaoManager()->addValue($novoFuncionario->getGrauInstrucao());
		$this->getDaoManager()->addColumn("data_nascimento");
		$this->getDaoManager()->addValue($novoFuncionario->getDataNascimento());
		$this->getDaoManager()->addColumn("ctps");
		$this->getDaoManager()->addValue($novoFuncionario->getCtps());
		$this->getDaoManager()->addColumn("salario");
		$this->getDaoManager()->addValue($novoFuncionario->getSalarioLiquido());
		$this->getDaoManager()->addColumn("cargo");
		$this->getDaoManager()->addValue($novoFuncionario->getCargo());
		$this->getDaoManager()->addColumn("comissao");
		$this->getDaoManager()->addValue($novoFuncionario->getComissao());
		$this->getDaoManager()->addColumn("num_serie");
		$this->getDaoManager()->addValue($novoFuncionario->getNumeroSerie());
		$this->getDaoManager()->addColumn("data_admissao");
		$this->getDaoManager()->addValue($novoFuncionario->getDataAdmissao());
		
		//metodo que insere os dados no banco
		$this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->reset();
			$result = $this->enderecoDao->inserir($novoFuncionario->getEndereco())
			&& $this->contatoDao->inserir($novoFuncionario->getContato());
			$resultUsuario = ($novoFuncionario->getPossuiUsuario() == 'S' 
								&& $novoFuncionario->getUsuario() != null) 
								? $this->usuarioDao->inserir($novoFuncionario->getUsuario()) 
								: true;
			if($result && $resultUsuario) {
		 		 //conclui a transação
				 $this->getDaoManager()->commit();
				 $this->getDaoManager()->reset();
				 return true; 
			} else { 
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
	
	public function alterar(Funcionario $funcionario){
		$this->getDaoManager()->begin();
		$enderecoAlterado = $this->enderecoDao->alterar($funcionario->getEndereco());
		$contatoAlterado =  $this->contatoDao->alterar($funcionario->getContato());
		if($enderecoAlterado && $contatoAlterado){
			$this->getDaoManager()->reset();
			$this->getDaoManager()->setTable("tb_funcionario");
			$this->getDaoManager()->addColumn("nome");
			$this->getDaoManager()->addValue($funcionario->getNome());
			$this->getDaoManager()->addColumn("rg");
			$this->getDaoManager()->addValue($funcionario->getRg());
			$this->getDaoManager()->addColumn("orgao_expeditor");
			$this->getDaoManager()->addValue($funcionario->getOrgaoExpedicao());
			$this->getDaoManager()->addColumn("uf_orgao_expeditor");
			$this->getDaoManager()->addValue($funcionario->getUfExpedicao());
			$this->getDaoManager()->addColumn("estado_civil");
			$this->getDaoManager()->addValue($funcionario->getEstadoCivil());
			$this->getDaoManager()->addColumn("sexo");
			$this->getDaoManager()->addValue($funcionario->getSexo());
			$this->getDaoManager()->addColumn("grau_instrucao");
			$this->getDaoManager()->addValue($funcionario->getGrauInstrucao());
			$this->getDaoManager()->addColumn("data_nascimento");
			$this->getDaoManager()->addValue($funcionario->getDataNascimento());
			$this->getDaoManager()->addColumn("ctps");
			$this->getDaoManager()->addValue($funcionario->getCtps());
			$this->getDaoManager()->addColumn("salario");
			$this->getDaoManager()->addValue($funcionario->getSalarioLiquido());
			$this->getDaoManager()->addColumn("cargo");
			$this->getDaoManager()->addValue($funcionario->getCargo());
			$this->getDaoManager()->addColumn("comissao");
			$this->getDaoManager()->addValue($funcionario->getComissao());
			$this->getDaoManager()->addColumn("num_serie");
			$this->getDaoManager()->addValue($funcionario->getNumeroSerie());
			$this->getDaoManager()->addColumn("data_admissao");
			$this->getDaoManager()->addValue($funcionario->getDataAdmissao());
			$this->getDaoManager()->addColumn("data_demissao");
			$this->getDaoManager()->addValue($funcionario->getDataDemissao());
			
			$filterCpf = new SQLFilter("cpf", "=", $funcionario->getCpf());
			$filter = $filterCpf->dump();
			$this->getDaoManager()->setQueryFilter($filter);
			$this->getDaoManager()->doUpdate();
			if($this->getDaoManager()->rowsChanged()){
				$this->getDaoManager()->commit();
				$this->getDaoManager()->reset();
				return true;
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
	
	
	public function excluir($cpf){
		$filter = "";
		$this->getDaoManager()->begin();
		$enderecoExcluido = $this->enderecoDao->excluir($cpf);
		$contatoExcluido = $this->contatoDao->excluir($cpf);
		if($cpf != NULL && $enderecoExcluido && $contatoExcluido){
			$filterCpf = new SQLFilter("cpf", "=", $cpf);
			$filter = $filterCpf->dump();
			$this->getDaoManager()->setTable("tb_funcionario");
			$this->getDaoManager()->setQueryFilter($filter);
			$this->getDaoManager()->doDelete();
			if($this->getDaoManager()->getSize() > 0){
				$this->getDaoManager()->commit();
				$this->getDaoManager()->reset();
				return "FuncionÃ¡rio excluido com sucesso.";
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
	
	public function consultar(Funcionario $funcionario, $operador){
		$fields = array("f.cpf", "f.nome", "e.cep", "e.bairro", "c.email", "c.tel_residencial");
		$filters = NULL;
		
		if($funcionario->getCpf() != NULL){
			$filterCpf = new SQLFilter("f.cpf", "=", $funcionario->getCpf());
			$filters[] = $filterCpf->dump();
		}
		if($funcionario->getNome() != NULL){
			$filterNome = new SQLFilter("f.nome", "=", $funcionario->getNome());
			$filters[] = $filterNome->dump();
		}
		
		$size = sizeof($filters);
		$filter = "";
		$i = 0;
		if($filters != NULL){
			foreach ($filters as $f){
				$i++;
				if($i == $size)
				 $filter .= $f;
				else 
				 $filter .= $f . $operador;
			}
		}
		
		$this->getDaoManager()->setTable("tb_funcionario f inner join tb_contato c on f.cpf = c.cpf_cnpj
			inner join tb_endereco e on f.cpf = e.cpf_cnpj");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		return $this->getDaoManager()->doRead();
	}
	
	public function consultarFuncionarioPorCpf($cpf){
		$fields = array("f.cpf", "f.nome", "f.rg", "f.orgao_expeditor", "f.uf_orgao_expeditor", "f.sexo", "f.data_nascimento", "f.estado_civil", 
		"f.grau_instrucao", "f.cargo", "f.ctps", "f.num_serie", "f.comissao", "f.salario", "f.foto", "f.data_admissao", "f.data_demissao", "f.possui_usuario",
		"e.cep", "e.logradouro", "e.bairro", "e.numero", "e.cidade", "e.estado", "e.complemento", 
		"c.email", "c.tel_celular","c.tel_residencial", "c.facebook", "c.twitter");
		
		$filter = "";
		$filterCpf = new SQLFilter("f.cpf", "=", $cpf);
		$filter = $filterCpf->dump();

		$this->getDaoManager()->setTable("tb_funcionario f inner join tb_contato c on f.cpf = c.cpf_cnpj
			inner join tb_endereco e on f.cpf = e.cpf_cnpj");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		//print_r($result);
		$funcionario = new Funcionario();
		$contato = new Contato();
		$endereco = new Endereco();
		
		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			
			$funcionario->setCpf($result[0]);
			$funcionario->setNome($result[1]);
			$funcionario->setRg($result[2]);
			$funcionario->setOrgaoExpedicao($result[3]);
			$funcionario->setUfExpedicao($result[4]);
			$funcionario->setSexo($result[5]);
			$funcionario->setDataNascimento($result[6]);
			$funcionario->setEstadoCivil($result[7]);
			$funcionario->setGrauInstrucao($result[8]);
			$funcionario->setCargo($result[9]);
			$funcionario->setCtps($result[10]);
			$funcionario->setNumeroSerie($result[11]);
			$funcionario->setComissao($result[12]);
			$funcionario->setSalarioLiquido($result[13]);
			$funcionario->setFoto($result[14]);
			$funcionario->setDataAdmissao($result[15]);
			$funcionario->setDataDemissao($result[16]);
			$funcionario->setPossuiUsuario($result[17]);
			
			$endereco->setCpfCnpj($result[0]);
			$endereco->setCep($result[18]);
			$endereco->setLogradouro($result[19]);
			$endereco->setBairro($result[20]);
			$endereco->setNumero($result[21]);
			$endereco->setCidade($result[22]);
			$endereco->setEstado($result[23]);
			$endereco->setComplemento($result[24]);
						
			$contato->setCpfCnpj($result[0]);
			$contato->setEmail($result[25]);
			$contato->setTelCelular($result[26]);
			$contato->setTelResidencial($result[27]);
			$contato->setTwitter($result[28]);
			$contato->setFacebook($result[29]);
		}
		
		$funcionario->setContato($contato);
		$funcionario->setEndereco($endereco);
		
		return $funcionario;
		
	}
	
	public function consultarTodosFuncionarios(){
		$fields = array("f.cpf","f.rg", "f.nome","f.data_nascimento","f.cargo","f.ctps", "f.comissao","f.salario","f.data_admissao","f.data_demissao","f.possui_usuario","f.orgao_expeditor", "f.uf_orgao_expeditor", 
		"e.cep", "e.logradouro","e.numero","e.cidade","e.estado", 
		"c.email","c.tel_celular", "c.tel_comercial", "c.twitter","c.facebook");

		$this->getDaoManager()->setTable("tb_funcionario f inner join tb_endereco e on f.cpf = e.cpf_cnpj
		inner join tb_contato c on f.cpf = c.cpf_cnpj");
		$this->getDaoManager()->setFields($fields);
		return $this->getDaoManager()->doRead();
		
	}
	
}

?>