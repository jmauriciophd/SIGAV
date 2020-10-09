<?php
/**
 * Classe abstrata Pagamento
 * @author Rafael Dias
 *
 */
class Pagamento 
{
	//Atributos privados da classe
	private $id;
	private $tipoPagamento;
	private $numParcelas;
	private $valorParcelas;
	private $entrada;
	private $faltaPagar;
	private $multa;
	
	//Metodos getters e setters
	public function getId(){
		return  $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getTipoPagamento(){
		return  $this->tipoPagamento;
	}
	
	public function setTipoPagamento($tipoPagamento){
		$this->tipoPagamento = $tipoPagamento;
	}
	
	public function getNumParcelas(){
		return $this->numParcelas;
	}
	
	public function setNumParcelas($numParcelas){
		$this->numParcelas = $numParcelas;
	}
	
	public function getValorParcelas(){
		return $this->valorParcelas;
	}
	
	public function setValorParcelas($valorParcelas){
		$this->valorParcelas = $valorParcelas;
	}
	
	public function getEntrada(){
		return $this->entrada;
	}
	
	public function setEntrada($entrada){
		$this->entrada = $entrada;
	}
	
	public function getFaltaPagar(){
		return $this->faltaPagar;
	}
	
	public function setFaltaPagar($faltaPagar){
		$this->faltaPagar = $faltaPagar;
	}
	
	public function getMulta(){
		return $this->multa;
	}
	
	public function setMulta($multa){
		$this->multa = $multa;
	}
}
?>