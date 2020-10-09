<?php
//*********************************************
class Logger{
    private $logText = null;
	private $handler=null ;
    
	public function Logger($handle ,$auth="" ){		
       $this->handler = $handle  ;
       $this->logText = "USUARIO=" . $auth .  "; IP=" . $_SERVER['REMOTE_ADDR'].   ";Data=" . date("d-m-Y H:i:s") ;
    }
	/**
	 com parametro  $default = true ele usa o valor
	*/
    public function setLogText($str ,  $default = false) {
        $str = ( $default ==true ) ? $this->logText . " " .  $str :  $str  ;
        $this->logText=$str;

     }
    public function getLogText(){
       return  $this->logText ."\n";
    } 
    public function log(){
       $this->handler->append($this->getLogText());
    }
}
?>