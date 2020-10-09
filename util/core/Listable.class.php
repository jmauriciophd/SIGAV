<?php
/**
 * Criado em 17/06/2007
 *
 * @author Gedalias Freitas da Costa
 * 
 */
 interface Listable{
 	
 	public function add($value=null, $assoc=null);
 	public function remove($whatToRemove=null);
 	public function search($findvalue, $casesensitive=false);
 	public function getSize();
 	/**
 	 * @param mixed 
 	 */
 	public function contentAt($whereIs=null);
 	public function cleanArray();
 	public function getElements();
 	public function hasNext();
 	public function getNext();
 	public function getIndex();
 	
 }
?>
