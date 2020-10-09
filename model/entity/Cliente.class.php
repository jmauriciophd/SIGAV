<?php
/**
 * Classe Cliente
 * @author jmauriciophd
 */
class Cliente extends Pessoa
{
	private $medidas;
	
	public function __construct(){}	
	
	public function getMedidas()
	{
		return $this->medidas;
	}
	
	public function setMedidas(Medidas $medidas)
	{
		$this->medidas = $medidas;
	}
}
