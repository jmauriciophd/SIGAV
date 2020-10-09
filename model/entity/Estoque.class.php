<?php

/**
 * Description of Estoque
 * @author Rafael Dias
 */
class Estoque {
    
    private $codigoVestuario;
    private $vestuario;
    private $status;
    
    public function getCodigoVestuario() {
        return $this->codigoVestuario;
    }

    public function setCodigoVestuario($codigoVestuario) {
        $this->codigoVestuario = $codigoVestuario;
    }
    
    public function getVestuario() {
        return $this->vestuario;
    }

    public function setVestuario($vestuario) {
        $this->vestuario = $vestuario;
    }
    
	public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
}

?>
