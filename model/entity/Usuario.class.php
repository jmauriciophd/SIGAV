<?php
/**
 * Classe do Usuário
 * @author Rafael Dias
 *
 */

class Usuario
{
	private $cpf;
	private $nome;
	private $email;
	private $senha;
	private $situacao;
	private $perfil;
	
	public function __construct() { 
	}
	
	//Metodos getters e setters
	public function getCpf()
	{
		return $this->cpf;
	}
	
	public function setCpf($cpf)
	{
		$this->cpf = $cpf;
	}
	
	public function getNome()
	{
		return $this->nome;
	}
	
	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function setEmail($email)
	{
		$this->email = $email;
	}
	
	public function getSenha()
	{
		return $this->senha;
	}
	
	public function setSenha($senha)
	{
		$this->senha = $senha;
	}
	
	public function getSituacao()
	{
		return $this->situacao;
	}
	
	public function setSituacao($situacao)
	{
		$this->situacao = $situacao;
	}
	
	
	public function getPerfil()
	{
		return $this->perfil;
	}
	
	public function setPerfil(Perfil $perfil)
	{
		$this->perfil = $perfil;
	}
	
  }
?>