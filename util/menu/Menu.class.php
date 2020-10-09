<?php
class Menu {
	protected $menu;
	protected $menuItems; //MenuItem[]
	protected $label;
	protected $href;
	protected $target;
	//Formatacao visual
	/*protected $itemStyle="";
	protected $itemClass="";
	protected $title="";
	protected $titleStyle="";
	*/
	//private MenuBar menuBar;
	/**
	* @param string $label
	* @param string $href
	* @param string $target
	*/
	public function Menu($label="Descrever Link",$href="#",$target="_self") {
		$this->menuItems = new ArrayList();
		$attributes      = new ArrayList();
		$attributes->add($label,"label");
		$attributes->add($href,"href");
		$attributes->add($target,"target");
		$this->menuItems->add($attributes);
	}
	/**
	 * Retorna texto html gerado
	 *
	 * @return string
	 */
	public function getOutput() {
		//$this->menu =
		$this->mountMenu();
		return $this->menu->getOutput();
	}
	/**
	 * Imprime HTML diretamente na saída.
	 *@return void
	 */
	public function printOut() {
		//$this->menu =
		$this->mountMenu();
		$this->menu->printOut();
	}
	/**
	 * adiciona itens de menu idefinidamente a hieraquia
	 * @return void
	 */
	public function addItem(MenuItem $item){
		$this->menuItems->add($item);
	}
	protected function mountMenu(){
		$this->menu  = new HTMLElement("li");
		$menuList = new HTMLElement("ul");
		while($this->menuItems->hasNext()){
			$menuItem = $this->menuItems->getNext();
			if($menuItem instanceof MenuItem ){
				$hyperLink = $menuItem->mountMenu();
				$menuList->appendChild($hyperLink);
			}else{
				//Configura os itens do menu
				$hyperLink = new HTMLElement("a");				
				$hyperLink->href   = $menuItem->contentAt("href");
				$hyperLink->target = $menuItem->contentAt("target");
				$hyperLink->appendChild($menuItem->contentAt("label"));
				$this->menu->appendChild($hyperLink);
			}

		}//fim do while
		$this->menu->appendChild($menuList);
	}
}

?>