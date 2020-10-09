<?php
/**
 * Classe de dominio do fornecedor
 * @author Rafael Dias
 *
 */

class Fornecedor 
{
	private $cnpj;
	private $razaoSocial;
	private $nomeFantasia;
	private $inscricaoEstadual;
	private $endereco;
	private $contato;
	
	public function __construct() { 
     	
	}
	
	//Metodos getters e setters
	public function getCnpj(){
		return $this->cnpj;
	}
	
	public function setCnpj($cnpj){
		$this->cnpj = $cnpj;
	}

    public function getRazaoSocial()
	{
		return $this->razaoSocial;
	}
	
	public function setRazaoSocial($razaoSocial) {
		$this->razaoSocial= $razaoSocial;
	}

   public function getNomeFantasia()
	{
		return $this->nomeFantasia;
	}
	
	public function setNomeFantasia($nomeFantasia) 
	{
		$this->nomeFantasia = $nomeFantasia;
	}
	
    public function getInscricaoEstadual()
	{
		return $this->inscricaoEstadual;
	}
	
	public function setInscricaoEstadual($inscricaoEstadual) {
		$this->inscricaoEstadual = $inscricaoEstadual;
	}
   
	public function getEndereco()
	{
		return $this->endereco;
	}
	
	public function setEndereco(Endereco $endereco) 
	{
		$this->endereco= $endereco;
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