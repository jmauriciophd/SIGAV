<?php
/**
 * Classe abstrata Pessoa
 * @author Rafael Dias
 */

abstract class Pessoa
{
	private $cpf;
	private $nome;
	private $dataNascimento;
	private $sexo;
	private $rg;
	private $orgaoExpedicao;
	private $ufExpedicao;
	private $estadoCivil;
	private $grauInstrucao;
	private $observacao;
	private $endereco;
	private $contato;
	
	/** Construtor da classe */
	public function __construct() { 
    
	}	
	// Metodos getters e setters
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
	
	public function getDataNascimento()
	{
		return $this->dataNascimento;
	}
	
	public function setDataNascimento($dataNascimento) 
	{
		$this->dataNascimento = $dataNascimento;
	}
	
	public function getSexo()
	{
		return $this->sexo;
	}
	
	public function setSexo($sexo) 
	{
		$this->sexo = $sexo;
	}
	
	public function getRg()
	{
		return $this->rg;
	}
	
	public function setRg($rg) 
	{
		$this->rg = $rg;
	}

	public function getOrgaoExpedicao()
	{
		return $this->orgaoExpedicao;
	}
	
	public function setOrgaoExpedicao($orgaoExpedicao) 
	{
		$this->orgaoExpedicao = $orgaoExpedicao;
	}
	
	public function getUfExpedicao()
	{
		return $this->ufExpedicao;
	}
	
	public function setUfExpedicao($ufExpedicao) 
	{
		$this->ufExpedicao = $ufExpedicao;
	}
	
	public function getEstadoCivil()
	{
		return $this->estadoCivil;
	}
	
	public function setEstadoCivil($estadoCivil) 
	{
		$this->estadoCivil = $estadoCivil;
	}
	
	public function getGrauInstrucao()
	{
		return $this->grauInstrucao;
	}
	
	public function setGrauInstrucao($grauInstrucao) 
	{
		$this->grauInstrucao = $grauInstrucao;
	}
	
	public function getEndereco()
	{
		return $this->endereco;
	}
	
	public function setEndereco(Endereco $endereco) 
	{
		$this->endereco = $endereco;
	}
	
	public function getContato()
	{
		return $this->contato;
	}
	
	public function setContato(Contato $contato) 
	{
		$this->contato = $contato;
	}
	
}
?>