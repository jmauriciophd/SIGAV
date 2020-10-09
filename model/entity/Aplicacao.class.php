<?php
/**
 * Classe do Usuário
 * @author José Mauricio
 *
 */

class Aplicacao
{
	private $id;
	private $nomeArquivo;
	private $nomeAplicacao;
	private $modulo;
	private $descricao; 

	public function __construct() { 
	}
	
	//Metodos getters e setters
	public function getId()
	{
		return $this->id;
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function getNomeArquivo()
	{
		return $this->nomeArquivo;
	}
	
	public function setNomeArquivo($nomeArquivo)
	{
		$this->nomeArquivo = $nomeArquivo;
	}
	
	public function getNomeAplicacao()
	{
		return $this->nomeAplicacao;
	}
	
	public function setNomeAplicacao($nomeAplicacao)
	{
		$this->nomeAplicacao = $nomeAplicacao;
	}
	
	public function getModulo()
	{
		return $this->modulo;
	}
	
	public function setModulo($modulo)
	{
		$this->modulo = $modulo;
	}
	
	public function getDescricao()
	{
		return $this->descricao;
	}
	
	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}
}
?>