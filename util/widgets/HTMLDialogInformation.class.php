<?php
class HTMLDialogInformation extends HTMLDialog {
//instancia uma nova linha
    public function __construct($message,$title="INFORMATIVO.",$width=360,$height=180) {
        parent::__construct($message,$title,$width,$height);
        $info = new HTMLImage("../phplib/icons/dialog-information-48.png");
        $this->dialog->setPosition(50,50);
        $buttTop= $this->panel->getHeight()-30;
        $buttLeft = $this->panel->getWidth()-100;
        $this->panel->appendChild($this->btnCancel,$buttTop,$buttLeft);
        $this->panel->appendChild($info,25,15);
        $this->dialog->appendChild($this->panel);
    }
}
?>