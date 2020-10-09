<?php
/**
 * Classe de dominio do funcionario
 * @author Rafael Dias
 *
 */

class Funcionario extends Pessoa 
{
	private $inss;
	private $fgts;
	private $descontos;
	private $comissao;
	private $salarioLiquido;
	private $decimoTerceiroSalario;
	private $ctps;
	private $numeroSerie;
	private $cargo;
	private $dataAdmissao;
	private $dataDemissao;
	private $possuiUsuario;
	private $usuario;
	private $foto;
	
	public function __construct() { 
     	
	}
	
	//Metodos getters e setters
	public function getInss(){
		return $this->inss;
	}
	
	public function setInss($inss){
		$this->inss = $inss;
	}
	
    public function getFgts()
	{
		return $this->fgts;
	}
	
	public function setFgts($fgts) {
		$this->fgts= $fgts;
	}

    public function getDescontos()
	{
		return $this->descontos;
	}
	
	public function setDescontos($descontos) {
		$this->descontos= $descontos;
	}
    
	public function getComissao()
	{
		return $this->comissao;
	}
	
	public function setComissao($comissao) {
		$this->comissao = $comissao;
	}
    
	public function getSalarioLiquido()
	{
		return $this->salarioLiquido;
	}
	
	public function setSalarioLiquido($salarioLiquido) {
		$this->salarioLiquido = $salarioLiquido;
	}
	
    public function getDecimoTerceiroSalario()
	{
		return $this->decimoTerceiroSalario;
	}
	
	public function setDecimoTerceiroSalario($decimoTerceiroSalario) {
		$this->decimoTerceiroSalario = $decimoTerceiroSalario;
	}
	
	public function getCtps()
	{
		return $this->ctps;
	}
	
	public function setCtps($ctps) {
		$this->ctps = $ctps;
	}
	
	public function getNumeroSerie()
	{
		return $this->numeroSerie;
	}
	
	public function setNumeroSerie($numeroSerie) {
		$this->numeroSerie = $numeroSerie;
	}
	
	public function getCargo()
	{
		return $this->cargo;
	}
	
	public function setCargo($cargo) {
		$this->cargo = $cargo;
	}
	
	public function getDataAdmissao()
	{
		return $this->dataAdmissao;
	}
	
	public function setDataAdmissao($dataAdmissao) {
		$this->dataAdmissao = $dataAdmissao;
	}
	
	public function getDataDemissao()
	{
		return $this->dataDemissao;
	}
	
	public function setDataDemissao($dataDemissao) 
	{
		$this->dataDemissao = $dataDemissao;
	}
	
	public function getPossuiUsuario()
	{
		return $this->possuiUsuario;
	}
	
	public function setPossuiUsuario($possuiUsuario) 
	{
		$this->possuiUsuario = $possuiUsuario;
	}
	
	public function getUsuario()
	{
		return $this->usuario;
	}
	
	public function setUsuario($usuario) 
	{
		$this->usuario = $usuario;
	}
	
	public function getFoto()
	{
		return $this->foto;
	}
	
	public function setFoto($foto) 
	{
		$this->foto = $foto;
	}
}
?>