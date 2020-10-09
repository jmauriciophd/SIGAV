<?php
class HTMLTableRow extends HTMLElement {

	//instancia uma nova linha
	public function __construct(){
		parent::__construct('tr');
	}
	/**
	 * Agrega um novo elemento (HTMLTableCell) à linha
	 *
	 * @return HTMLTableCell
	 */
	public function insertCell($value){
		$cell = new HTMLTableCell($value);
		parent::appendChild($cell);
		return $cell;
	}
}

?>