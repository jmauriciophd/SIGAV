<?php
/**
 * Classe de dominio Medidas
 * @author Rafael Dias
 */

class Medidas
{
	private $id;
	private $tamanho;
	private $bustoTorax;
	private $cintura;
	private $quadril;
	private $alturaFrente;
	private $ombro;
	private $costas;
	private $braco;
	private $observacao;
	
	/** Construtor da classe */
	public function __construct(){
		
	}
	
	// Metodos getters e setters
	public function getId()
	{
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getTamanho()
	{
		return $this->tamanho;
	}
	
	public function setTamanho($tamanho)
	{
		$this->tamanho = $tamanho;
	}
	
	public function getBustoTorax()
	{
		return $this->bustoTorax;
	}
	
	public function setBustoTorax($bustoTorax)
	{
		$this->bustoTorax = $bustoTorax;
	}
	
	public function getCintura()
	{
		return $this->cintura;
	}
	
	public function setCintura($cintura)
	{
		$this->cintura = $cintura;
	}
	
	public function getQuadril()
	{
		return $this->quadril;
	}

	public function setQuadril($quadril) 
	{
		$this->quadril = $quadril;
	}
	
    public function getAlturaFrente()
	{
		return $this->alturaFrente;
	}
	
	public function setAlturaFrente($alturaFrente) 
	{
		$this->alturaFrente = $alturaFrente;
	}
	
	public function getOmbro()
	{
		return $this->ombro;
	}
	
	public function setOmbro($ombro) 
	{
		$this->ombro = $ombro;
	}
	
	public function getCostas()
	{
		return $this->costas;
	}
	
	public function setCostas($costas) 
	{
		$this->costas = $costas;
	}
	
	public function getBraco()
	{
		return $this->braco;
	}
	
	public function setBraco($braco) 
	{
		$this->braco = $braco;
	}
	
	public function getObservacao()
	{
		return $this->observacao;
	}
	
	public function setObservacao($observacao) 
	{
		$this->observacao = $observacao;
	}
}
?>