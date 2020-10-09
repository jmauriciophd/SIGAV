<?php
class Template{
	private $changesList;
	private $tplContent ="";
	/**
	 *
	 * @param string  $file
	 */
	public function __construct($file=null){
		$this->changesList= array();
		if(file_exists($file)){
			$this->tplContent  = file_get_contents($file);
		}
	}
	/**
	 * carrega um arquivo para ser usado como template
	 * @return void
	 * @param string $file
	 */
	public function load($file=null){
		if(file_exists($file)){
			$this->tplContent = file_get_contents($file);
		}
	}
	/**
	 * @param string $change
	 * @param mixed $mixed
	 */
	public function addChanges($change=null, $mixed=null){
	 if(!is_null($change) && !is_null($mixed)){
	 	$this->changesList[$change] = $mixed;
	 }
	}
	/**
	 * imprime a saida do arquivo html alterado substituindo
	 * as MARCAS pelas mudancas solicitadas
	 *
	 * @return  void;
	 */
	public function printOut(){
		foreach ($this->changesList as $change => $object) {
			if(is_object($object)){				
				$this->tplContent = str_replace($change,$object->getOutput(),$this->tplContent );
			}else if(is_string($object)){
				$this->tplContent = str_replace($change,$object,$this->tplContent );
			}else if(is_array($object)){
				$this->tplContent = str_replace($change,implode($object),$this->tplContent );
			}
		}
		echo $this->tplContent;
	}
}
?>