<?php
abstract class HTMLDialog {
    protected $dialog;
    protected $btnConfirm;
    protected $btnCancel;
    protected $panel;
    //instancia uma nova linha
    public function __construct($message,$title="", $width, $height) {
    //Um HTMLWindow para positionar os obetos na tela
    //mudancas na aprencia de HTMLWindow tambem deve ser realizada em HTMLPanel
        $this->dialog = new HTMLWindow("$title",$width,$height);
        $this->dialog->setPosition(200,200);
        //um painel HTMLPanel para dispor os objetos em HTMLWindow
        $panelWidth = $this->dialog->getWidth() -1;
        $panelHeight = $this->dialog->getHeight() - 2;
        $this->panel = new HTMLPanel($panelWidth,$panelHeight);
        $this->panel->backgroundColor="#F7F7F7";
        $this->btnConfirm = new HTMLElement("input");
        $this->btnCancel = new HTMLElement("input");
        $this->btnConfirm->type="image";
        $this->btnCancel->type ="image";
        $this->btnConfirm->src ="../phplib/icons/button-ok-light.png";
        $this->btnCancel->src = "../phplib/icons/button-cancel-light.png";
        $this->btnConfirm->value="Confirmar";
        $this->btnCancel->value="Cancelar";
        $this->btnCancel->style ="border:0px;";
        $this->btnConfirm->style ="border:0px;";
        $msgParagraph = new HTMLParagraph("$message");
        $msgParagraph->style ="color:#4F576C;font-family:Sans Serif;font-size:12px;width:100%;text-align:justify; ";
        $this->panel->appendChild($msgParagraph,10,90);
    }
    /**
     *
     *
     * @param integer $top
     * @param integer $left
     */
    public function setPosition($top, $left) {
        $this->dialog->setPosition($top, $left);
    }
    /**
     * Enter description here...
     *
     * @param string $event
     * @param string $handler
     */
    public function addConfirmEvent($event,$handler) {}
    /**
     * Enter description here...
     *
     * @param string $event
     * @param string $handler
     */
    public function addCancelEvent($event,$handler) {
        $this->btnCancel->$event = "$handler";
    }

    /**
     * Agrega um novo elemento (HTMLTableCell) à linha
     *
     * @return HTMLTableCell
     */
    public function printOut() {
        $this->dialog->printOut();
    }

}

?>