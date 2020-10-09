<?php
class AluguelVestuario 
{
	private $aluguel;
	private $estoque;
	private $dataDevolucao;
	private $situacao;
	
	public function __construct(){}

	public function getAluguel()
	{
		return $this->aluguel;
	}
	
	public function setAluguel(Aluguel $aluguel)
	{
		$this->aluguel = $aluguel;
	}
	
	public function getDataDevolucao()
	{
		return $this->dataDevolucao;
	}
	
	public function setDataDevolucao($dataDevolucao)
	{
		$this->dataDevolucao = $dataDevolucao;
	}
	
	public function getEstoque()
	{
		return $this->estoque;
	}

	public function setEstoque(Estoque $estoque)
	{
		$this->estoque = $estoque;
	}
	
	public function getSituacao()
	{
		return $this->situacao;
	}
	
	public function setSituacao($situacao) 
	{
		$this->situacao = $situacao;
	}
	
 }
?>