<?php
class HTMLTableCell extends HTMLElement {
	public function __construct($value){
		parent::__construct('td');
		parent::appendChild($value);
	}
}

?>