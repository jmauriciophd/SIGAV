<?php
  class Vestuario
{
	private $id;
	private $nome;
	private $tamanho;
	private $medidas;
	private $cor;
	private $observacao;
	private $categoria;		
	private $valorVestuario;
	private $valorAluguel;
	private $quantidade;
	private $listaEstoque;
	private $fornecedor;
	
	public function  __construct(){}
	
	public function getId()
	{
		return $this->id;		
	}
	
	public function setId($id)
	{
		$this->id=$id;
	}	
	
	public function getNome()
	{
		return $this->nome;
	}
	
    public function setNome($nome)
    {
    	$this->nome = $nome;    	
    }
    
    public function getTamanho()
	{
		return $this->tamanho;
	}
	
    public function setTamanho($tamanho)
    {
    	$this->tamanho=$tamanho;    	
    }
    
	public function getMedidas()
	{
		return $this->medidas;
	}
	
    public function setMedidas($medidas)
    {
    	$this->medidas=$medidas;    	
    }
    
    public function getCor()
	{
		return $this->cor;
	}
	
	public function setCor($cor)
    {
    	$this->cor=$cor;    	
    }
    
    public function getObservacao()
	{
		return $this->observacao;
	}
	public function setObservacao($observacao)
    {
    	$this->observacao=$observacao;    	
    }
    
    public function getCategoria()
    {
        return $this->categoria;    	
    }
    public function setCategoria(Categoria $categoria)
    {
    	$this->categoria = $categoria;    	
    }
    
    public function getValorVestuario()
	{
		return $this->valorVestuario;
	}

	public function setValorVestuario($valorVestuario)
    {
    	$this->valorVestuario=$valorVestuario;    	
    }
    
	public function getValorAluguel()
	{
		return $this->valorAluguel;
	}

	public function setValorAluguel($valorAluguel)
    {
    	$this->valorAluguel=$valorAluguel;    	
    }
    
	public function getQuantidade()
	{
		return $this->quantidade;
	}

	public function setQuantidade($quantidade)
    {
    	$this->quantidade = $quantidade;    	
    }
    
	public function getListaEstoque()
	{
		return $this->listaEstoque;
	}

	public function setListaEstoque($listaEstoque)
    {
    	$this->listaEstoque = $listaEstoque;    	
    }
    
    public function getFornecedor()
	{
		return $this->fornecedor;
	}
	
    public function setFornecedor(Fornecedor $fornecedor)
    {
    	$this->fornecedor = $fornecedor;    	
    }
    
} 
?>