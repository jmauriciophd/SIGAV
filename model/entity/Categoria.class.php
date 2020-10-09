<?php
/**
 * Classe de dominio categoria
 * @author Rafael Dias
 */
class Categoria
{
	private $codigo;
	private $descricao;
	
	public function  __construct(){}
	
	public function getCodigo()
	{
		return $this->codigo;
	}
	
    public function setCodigo($codigo)
    {
    	$this->codigo = $codigo;    	
    }
	
	public function getDescricao()
	{
		return $this->descricao;
	}
	
    public function setDescricao($descricao)
    {
    	$this->descricao=$descricao;    	
    }
	
}


?>