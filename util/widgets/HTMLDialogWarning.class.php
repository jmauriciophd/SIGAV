<?php
class HTMLDialogWarning extends HTMLDialog {
//instancia uma nova linha
    public function __construct($message,$title="INFORMATIVO.",$width=360,$height=180) {
        parent::__construct($message,$title,$width,$height);
        $warningPicture = new HTMLImage("../phplib/icons/dialog-warning-48.png");
        $this->dialog->setPosition(50,50);
        $buttTop= $this->panel->getHeight()-30;
        $buttLeft = $this->panel->getWidth()-100;
        $this->panel->appendChild($this->btnCancel,$buttTop,$buttLeft);
        $this->panel->appendChild($warningPicture,25,25);
        $this->dialog->appendChild($this->panel);
    }

}

?>