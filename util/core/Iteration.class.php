<?php

class Iteration implements Iterable{
	private $collection = null ;
	private $size = 0 ;
	public function Iteration(Object $obj) {
		if ($obj instanceof ArrayList) {
			$this->size = $obj->getSize();
			$this->collection = $obj->getElements();
		} else {
			throw new Exception("Tipo Inválido. Dados passado para Iteration não é uma collection");
		}
	}
	/**
	 * @return boolean
	 * Retorna true se ainda existir algum registro
	 */
	public function getNext() {
		//metodo de array
		return current($this->collection);
	}

	public function hasNext() {
		return next($this->collection);
	}
	public function resetIterator() {
		reset($this->collection);
	}

	public function getSize(){
		return $this->size;
	}
	public function getLast(){
		return end($this->collection);
	}

}
?>
