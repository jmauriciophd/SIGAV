<?php
final class MenuBar {
	private static $menu; //Menu[]
	private $direction;

	/**
	 * Método construtor
	 * @param Menu $menu
	 */
	public function __construct() {
		self::$menu = new ArrayList();
	}
	/**
	 * Retorna texto html gerado
	 * @return string
	 */
	public function getOutput(){
		$aMenu = $this->mountBar();
		$aMenu->getOutput();
	}
	/**
	 *Imprime HTML diretamente na saída.
	 *@return void
	 */
	public function printOut() {
		$aMenu = $this->mountBar();
		$aMenu->printOut();
	}
	/**
	 * Torna a barra de menu disposta horizontalmente
	 * @return void
	 */
	public function isHorizontal() {
		$this->direction="H";
	}
	/**
	 * Torna a barra de menu disposta verticalmente
	 * @return void
	 */
	public function isVertical() {
		$this->direction="V";
	}
	/**
	 *
	 *
	 * @param Menu $menu
	 */
	public function addMenu(Menu $menu){
		self::$menu->add($menu);
	}
	/**
	 * Monta uma barra de menu vertical ou horizontal;
	 * @return HTMLTable
	 */
	private function mountBar(){
		$bar = self::$menu;
		$fullBar = new HTMLTable();
		//$fullBar->border="1";
		$fullBar->cellpadding="0";
		$fullBar->cellspacing="0";
		$fullBar->style="height:30px";
		$anTrItem = $fullBar->insertRow();
		$id = 0;
		while($bar->hasNext()){
			$anUl = new HTMLElement("ul");
			$anUl->id ="nav_" . $id++;
			$anUl->onmouseover = "activateMenu('".$anUl->id."'); ";//passa o mouuse ativa o menu
			$item = $bar->getNext();
			$anUl->appendChild($item->getOutput());
			if($this->direction =="V"){
				$anTrItem = $fullBar->insertRow();
			}
			$anTdItem=$anTrItem->insertCell($anUl);
			$anTdItem->appendChild($this->getHorizNeed());
			$anTdItem->valign="top";
		}
		return $fullBar;
	}
	 
	/**
	 * CSS do menu 
	 *
	 * @return string
	 */
	private function getHorizNeed(){
		 return	"";
	}
}
?>