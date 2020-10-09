<?php
class HTMLDialogQuestion extends HTMLDialog{
    //instancia uma nova linha
    public function __construct($message,$title="Solicitaηγo.",$width=360,$height=180){
        parent::__construct($message,$title,$width,$height);
        $this->dialog->setPosition(50,50);        
        $questionPicture = new HTMLImage("../phplib/icons/dialog-question-48.png");
        $buttTop= $this->panel->getHeight()-30;
        $buttLeft = $this->panel->getWidth()-100;
        $this->panel->appendChild($this->btnConfirm,$buttTop,$buttLeft-110);
        $this->panel->appendChild($this->btnCancel,$buttTop,$buttLeft);
        $this->panel->appendChild($questionPicture,25,15);
        $this->dialog->appendChild($this->panel);        
    }
    public function addConfirmEvent($event,$handler){
        $this->btnConfirm->$event = "$handler";
    }
}
?>