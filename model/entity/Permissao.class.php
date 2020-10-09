<?php
 class Permissao
 {
    private $id;
    private $perfil;
    private $aplicacao;
    private $acessa = 'N';
    private $consulta = 'N';
    private $cadastra = 'N';
    private $atualiza = 'N';
    private $exclui = 'N';   
    private $imprimi = 'N';
    
    public function Permissao(){
    	$acessa = 'N';
	    $consulta = 'N';
	    $cadastra = 'N';
	    $atualiza = 'N';
	    $exclui = 'N';   
	    $imprimi = 'N';
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPerfil() {
        return $this->perfil;
    }

    public function setPerfil(Perfil $perfil) {
        $this->perfil = $perfil;
    }

	public function getAplicacao() {
        return $this->aplicacao;
    }

    public function setAplicacao(Aplicacao $aplicacao) {
        $this->aplicacao = $aplicacao;
    }
    
    public function getAcessa() {
        return $this->acessa;
    }

    public function setAcessa($acessa) {
        $this->acessa = $acessa;
    }
    
   public function getConsulta() {
        return $this->consulta;
    }

    public function setConsulta($consulta) {
        $this->consulta = $consulta;
    }
    public function getCadastra() {
        return $this->cadastra;
    }

    public function setCadastra($cadastra) {
        $this->cadastra = $cadastra;
    }
    public function getAtualiza() {
        return $this->atualiza;
    }

    public function setAtualiza($atualiza) {
        $this->atualiza = $atualiza;
    }

	public function getExclui() {
        return $this->exclui;
    }

    public function setExclui($exclui) {
        $this->exclui = $exclui;
    }
    public function getImprimi() {
        return $this->imprimi;
    }

    public function setImprimi($imprimi) {
        $this->imprimi = $imprimi;
    }
    
    public function toString(){
    	return " Acessar: " . $this->acessa .
    		   " Cadastrar: " . $this->cadastra .
    		   " Alterar: " . $this->atualiza .
    		   " Excluir: " . $this->exclui .
    		   " Consultar: " . $this->consulta .
    		   " Imprimir: " . $this->imprimi .
    		   " Aplicaчуo: " . $this->aplicacao->getId() .
    		   " Perfil: " . $this->perfil->getId();
    }

 }
?>