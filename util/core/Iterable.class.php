<?php
/**
 * definicao da interface para os iteradores concretos
 */
interface Iterable {
	/**
	 * Retorna o elemento atual da cole��o e move o ponteiro
	 * interno uma posicao
	 * @return mixed
	 */
	public function getNext();
	/**
	 *@return boolean
	 *se ainda existe algum outro registro
	 */
	public function hasNext();
	/**
	 * Retorna o numero de elementos na colecao
	 * @return Integer
	 */
	public function getSize();
	/**
	 * Reseta o ponteiro da colecao para o inicio
	 * @return void
	 */
	public function resetIterator();
	/**
	 *
	 */
	public function getLast();

}
?>
