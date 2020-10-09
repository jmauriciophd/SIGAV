<?php
class UsuarioDao extends AbstractEntityDao
{

	public function __construct(){
		parent::AbstractEntityDao();
	}

    public function inserir(Usuario $usuario) {

   		$this->getDaoManager()->begin();
		$this->getDaoManager()->setTable("tb_usuario");
		$this->getDaoManager()->addColumn("cpf");
		$this->getDaoManager()->addValue($usuario->getCpf());
		$this->getDaoManager()->addColumn("nome");
		$this->getDaoManager()->addValue($usuario->getNome());
		$this->getDaoManager()->addColumn("email");
		$this->getDaoManager()->addValue($usuario->getEmail());
		$this->getDaoManager()->addColumn("senha");
		$this->getDaoManager()->addValue($usuario->getSenha());
		$this->getDaoManager()->addColumn("situacao");
		$this->getDaoManager()->addValue($usuario->getSituacao());
		$this->getDaoManager()->addColumn("id_perfil");
		$this->getDaoManager()->addValue($usuario->getPerfil()->getId());
		$this->getDaoManager()->doInsert();
		
		if($this->getDaoManager()->rowsChanged()){
			$this->getDaoManager()->commit();
			$this->getDaoManager()->reset();
			return true;
		} else{
			$this->getDaoManager()->rollback();
		 	return false;
		}
		
	}
   
	public function alterar(Usuario $usuario){
			$this->getDaoManager()->begin();
			$this->getDaoManager()->setTable("tb_usuario");
			$this->getDaoManager()->addColumn("nome");
			$this->getDaoManager()->addValue($usuario->getNome());
			$this->getDaoManager()->addColumn("email");
			$this->getDaoManager()->addValue($usuario->getEmail());
			$this->getDaoManager()->addColumn("situacao");
			$this->getDaoManager()->addValue($usuario->getSituacao());
			$this->getDaoManager()->addColumn("id_perfil");
			$this->getDaoManager()->addValue($usuario->getPerfil()->getId());
			$filterCpf = new SQLFilter("cpf", "=", $usuario->getCpf());
			$filter = $filterCpf->dump();
			$this->getDaoManager()->setQueryFilter($filter);
			$this->getDaoManager()->doUpdate();
			
			if($this->getDaoManager()->rowsChanged()){
				$this->getDaoManager()->commit();
				$this->getDaoManager()->reset();
				return true;
			} else {
				$this->getDaoManager()->rollback();
				return false;
			}
	}
	
    public function excluir($cpf){
			$this->getDaoManager()->begin();
			$this->getDaoManager()->setTable("tb_usuario");
			$filterCpf = new SQLFilter("cpf", "=", $cpf);
			$filter = $filterCpf->dump();
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
		
	public function consultarUsuarioPorCpf($cpf){
		$fields = array("u.cpf", "u.senha", "u.nome as nome_usuario", "u.email", "u.situacao", "u.id_perfil", "p.nome as nome_perfil");
		$filterCpf = new SQLFilter("u.cpf", "=", $cpf);
		$filter = $filterCpf->dump();
		
		$this->getDaoManager()->setTable("tb_usuario u inner join tb_perfil p on u.id_perfil = p.id");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		
		$usuario = new Usuario();
		$perfil = new Perfil();
		
		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			
			$usuario->setCpf($result[0]);
			$usuario->setSenha($result[1]);
			$usuario->setNome($result[2]);
			$usuario->setEmail($result[3]);
			$usuario->setSituacao($result[4]);
			$perfil->setId($result[5]);
			$perfil->setNome($result[6]);
		}
		
		$usuario->setPerfil($perfil);
		
		return $usuario;
	}
	
	public function consultarUsuarioPorCpfEmail($cpf, $email){
		$fields = array("u.cpf", "u.senha", "u.nome as nome_usuario", "u.email", "u.situacao", "u.id_perfil", "p.nome as nome_perfil");
		$filterCpf = new SQLFilter("u.cpf", "=", $cpf);
		$filter = $filterCpf->dump();
		
		$filterEmail = new SQLFilter("u.email", "=", $email);
		$filter .= " and " . $filterEmail->dump();
		
		$this->getDaoManager()->setTable("tb_usuario u inner join tb_perfil p on u.id_perfil = p.id");
		$this->getDaoManager()->setFields($fields);
		$this->getDaoManager()->setQueryFilter($filter);
		$result = $this->getDaoManager()->doRead();
		
		$usuario = new Usuario();
		$perfil = new Perfil();
		
		if($result != null && $result->getFirst() != null){
			$result = $result->getFirst()->getElements();
			
			$usuario->setCpf($result[0]);
			$usuario->setSenha($result[1]);
			$usuario->setNome($result[2]);
			$usuario->setEmail($result[3]);
			$usuario->setSituacao($result[4]);
			$perfil->setId($result[5]);
			$perfil->setNome($result[6]);
		}
		
		$usuario->setPerfil($perfil);
		
		return $usuario;
	}
	
	public function consultarTodosUsuarios(){
		$fields = array("u.cpf", "u.nome", "u.situacao", "p.nome as nome_perfil");

		$this->getDaoManager()->setTable("tb_usuario u inner join tb_perfil p on u.id_perfil = p.id");
		$this->getDaoManager()->setFields($fields);
		return $this->getDaoManager()->doRead();
	}
	
	public function alterarSenha(Usuario $usuario){
			$this->getDaoManager()->reset();
			$this->getDaoManager()->begin();
			$this->getDaoManager()->setTable("tb_usuario");
			$this->getDaoManager()->addColumn("senha");
			$this->getDaoManager()->addValue($usuario->getSenha());
			$filterCpf = new SQLFilter("cpf", "=", $usuario->getCpf());
			$filter = $filterCpf->dump();
			$this->getDaoManager()->setQueryFilter($filter);
			$this->getDaoManager()->doUpdate();
			
			if($this->getDaoManager()->rowsChanged()){
				$this->getDaoManager()->commit();
				return true;
			} else {
				$this->getDaoManager()->rollback();
				return false;
			}
	}
	
}

?>
