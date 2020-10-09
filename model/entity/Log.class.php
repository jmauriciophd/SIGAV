<?php

/**
 * Description Classe para amazenar os logs das operações do sistema
 * @author Rafael Dias
 */
class Log 
{
    private $id;
    private $aplicacao;
    private $tabela;
    private $chavePrimaria;
    private $usuario;
    private $operacao;
    private $dataHora;
    private $ip;
    
    public function Log(){ } 
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getAplicacao() {
        return $this->aplicacao;
    }

    public function setAplicacao(Aplicacao $aplicacao) {
        $this->aplicacao = $aplicacao;
    }

    public function getTabela() {
        return $this->tabela;
    }

    public function setTabela($tabela) {
        $this->tabela = $tabela;
    }
    
    public function getChavePrimaria() {
        return $this->chavePrimaria;
    }

    public function setChavePrimaria($chavePrimaria) {
        $this->chavePrimaria = $chavePrimaria;
    }
    
	public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario) {
        $this->usuario = $usuario;
    }
    
	public function getOperacao() {
        return $this->operacao;
    }

    public function setOperacao($operacao) {
        $this->operacao = $operacao;
    }
    
	public function getDataHora() {
        return $this->dataHora;
    }

    public function setDataHora($dataHora) {
        $this->dataHora = $dataHora;
    }
    
	public function getIp() {
        return $this->ip;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }
    
}

?>
