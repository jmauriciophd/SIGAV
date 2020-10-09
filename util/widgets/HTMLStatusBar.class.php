<?php
class HTMLStatusBar {
    private $container ;
    private $items;
    private $rowItem;
    private $firstItem;
    public function __construct($status="") {
        $this->firstItem ="$status";
        if (empty($status)) {
            $date = new Date();
            $this->firstItem = $date->getDatePTBR();
        }
        $this->items = array();
        $this->container = new HTMLTable();
        $this->container->border="1";
        $this->container->width ="100%";
        $this->container->cellspacing="1";
        $this->container->class      ="statusBar";
        $this->createStatusLook();
    }
    /**
     * retorna um tabela previamente formatada
     *
     * @return HTMLTable
     */
    public function getStatusBar() {
        $this->createStatus();
        return $this->container;
    }

    public function addItem($item) {
        if(count($this->items)<3) {
            $this->items[] = "$item";
        }
    }
    public function printOut() {
        $this->createStatus();
        $this->container->printOut();
    }
    /**
     *
     *@return  void
     */
    private function createStatus() {
        $this->rowItem = $this->container->insertRow();
        $firstCell = $this->rowItem->insertCell($this->firstItem);
        $firstCell->id ="status_0";
        $this->produceStatus();
        $resizeIcon   = new HTMLImage("../phplib/icons/resize.png");
        $resizeCol    = $this->rowItem->insertCell($resizeIcon);
        $resizeCol->style ="width:3%;text-align:right;";
    }

    private function produceStatus() {
        $id =1;
        foreach ($this->items as $item) {
            $itemCell = $this->rowItem->insertCell($item);
            $itemCell->style ="width:10%;text-align:right;";
            $itemCell->id = "status_".$id;
            $itemCell->nowrap ="nowrap";
            $id++;
        }
    }

    private function createStatusLook() {
        $look = new HTMLStyle("statusBar");
        $look->font_size ="12px";
        $look->font_family="Sans";
        $look->text_align="left";
        $look->color="#F3F5F5";
        $look->border ="1px outset #CEDAE8";
        $look->background_color="#AABACC";
        //$look->background_image="url('../library/icons/grid_caption.png')";
        $look->printOut();
    }
}
?>