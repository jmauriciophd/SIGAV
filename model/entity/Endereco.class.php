<?php
/**
 * Classe de dominio Endereco
 * @author Rafael Dias
 */

class Endereco
{
	private $cep;
	private $bairro;
	private $logradouro;
	private $numero;
	private $complemento;
	private $cidade;
	private $estado;
	private $cpfCnpj;
	
	/** Construtor da classe */
	public function __construct(){
		
	}
	
	// Metodos getters e setters
	public function getCpfCnpj()
	{
		return $this->cpfCnpj;
	}
	
	public function setCpfCnpj($cpfCnpj) {
		$this->cpfCnpj = $cpfCnpj;
	}
	
	public function getCep()
	{
		return $this->cep;
	}
	
	public function setCep($cep)
	{
		$this->cep = $cep;
	}
	
	public function getBairro()
	{
		return $this->bairro;
	}
	
	public function setBairro($bairro)
	{
		$this->bairro = $bairro;
	}
	
	public function getLogradouro()
	{
		return $this->logradouro;
	}
	
	public function setLogradouro($logradouro)
	{
		$this->logradouro = $logradouro;
	}
	
	public function getCidade()
	{
		return $this->cidade;
	}

	public function setCidade($cidade) 
	{
		$this->cidade = $cidade;
	}
	
    public function getEstado()
	{
		return $this->estado;
	}
	
	public function setEstado($estado) 
	{
		$this->estado = $estado;
	}
	
	public function getNumero()
	{
		return $this->numero;
	}
	
	public function setNumero($numero) 
	{
		$this->numero = $numero;
	}
	
	public function getComplemento()
	{
		return $this->complemento;
	}
	
	public function setComplemento($complemento) 
	{
		$this->complemento = $complemento;
	}
}
?>