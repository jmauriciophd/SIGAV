<?php
class MenuItem extends Menu {
	/**
	 * @param string $label
	 * @param string $href
	 * @param string $target
	 */
	public function MenuItem($label="Descrever Link",$href="#",$target="_self") {
		parent::Menu($label,$href,$target);
	}
	protected function mountMenu(){
		$outPut = "";
		$subItem= "";
		while($this->menuItems->hasNext()){
			$menuItem = $this->menuItems->getNext();
			if(!$subItem){
				$li = new HTMLElement("li");
			}
			if($menuItem instanceof MenuItem){
				//apresenta na tela os itens do menu dentro de uma tabela
				$subItem .= $menuItem->mountMenu();
				$level++;
			}else{
				$level=0;
				//Configura os itens do menu
				$hyperLink = new HTMLElement("a");
				$hyperLink->href   = $menuItem->contentAt("href");
				$hyperLink->target = $menuItem->contentAt("target");
				$hyperLink->appendChild($menuItem->contentAt("label"));
			}
			if($subItem){
				if($level==($this->menuItems->getSize()-1)){
					$ul = new HTMLElement("ul");
					$ul->appendChild($subItem);
					$li->appendChild($hyperLink);
					$li->appendChild($ul);
				}
			}else{
				$li->appendChild($hyperLink);
			}
		}//fim do while
		return $li->getOutput();
	}
}
?>