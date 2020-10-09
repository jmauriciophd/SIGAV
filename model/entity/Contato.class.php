<?php
/**
 * Classe de dominio Contato
 * @author Rafael Dias
 */
class Contato 
{
	private $cpfCnpj;
	private $email;
	private $telResidencial;
	private $telComercial;
	private $telCelular;
	private $twitter;
	private $facebook;
	
	/** Construtor da classe */
	public function __construct() { 

	}
	
	// Metodos getters e setters
	public function getCpfCnpj()
	{
		return $this->cpfCnpj;
	}
	
	public function setCpfCnpj($cpfCnpj) {
		$this->cpfCnpj = $cpfCnpj;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function setEmail($email)
	{
		$this->email = $email;
	}
	
	public function getTelResidencial()
	{
		return $this->telResidencial;
	}
	
	public function setTelResidencial($telResidencial) 
	{
		$this->telResidencial = $telResidencial;
	}
	
	public function getTelComercial()
	{
		return $this->telComercial;
	}
	
	public function setTelComercial($telComercial) 
	{
		$this->telComercial = $telComercial;
	}
	
  	public function getTelCelular()
	{
		return $this->telCelular;
	}
	
	public function setTelCelular($telCelular) 
	{
		$this->telCelular = $telCelular;
	}
	
	public function getTwitter()
	{
		return $this->twitter;
	}
	
	public function setTwitter($twitter) 
	{
		$this->twitter = $twitter;
	}
	
	public function getFacebook()
	{
		return $this->facebook;
	}
	
	public function setFacebook($facebook) 
	{
		$this->facebook = $facebook;
	}
}
?>