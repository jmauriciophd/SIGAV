<?php
/**
 * Uma classe usada para gerar caixas de selecao
 * para data, dias, meses, anso, hora, minuto, segundos
 * e comparar valores provenientes de fontes externas
 * para marcar como selecionado.
 */
class HTMLTimeCombobox {
    private static $meses;
    public function __construct() {
        date_default_timezone_set("Brazil/East");
        self::$meses[]="Janeiro";
        self::$meses[]="Fevereiro";
        self::$meses[]="Março";
        self::$meses[]="Abril";
        self::$meses[]="Maio";
        self::$meses[]="Junho";
        self::$meses[]="Julho";
        self::$meses[]="Agosto";
        self::$meses[]="Setembro";
        self::$meses[]="Outubro";
        self::$meses[]="Novembro";
        self::$meses[]="Dezembro";
    }
	/**
	 * Enter description here...
	 *
	 * @param string $e
	 * @return string
	 */
    public function getDateOptions($e="") {
        $option ="<option value=\"null\">Dia</option>\n";
        for($d = 1 ; $d <= 31; $d++) {
            $option.= $this->optionGenerator($d, $e);
        }
        return $option;
    }
    /**
     *
     * @param string $e
     * @return string
     */
    public function getMonthOptions($e="") {
        $option ="<option value=\"null\">Mês</option>\n";
        for($d = 1 ; $d <= 12; $d++) {
            $option.= $this->optionGenerator($d, $e);
        }
        return  $option;
    }
   /**
     *
     * @param string $e
     * @return string
     */
    public function getLongMonthOptions($e="") {
        $option ="<option value=\"null\">Mês</option>\n";
        $e = (int)$e;
        for($d = 1 ; $d <= 12; $d++) {
            if ($d == $e) {
                $option.="<option value=\"{$d}\" selected>".self::$meses[$d-1]."</option>\n";
            }else {
                $option.="<option value=\"{$d}\">".self::$meses[$d-1]."</option>\n";
            }
        }
        return  $option;
    }
   /**
     *
     * @param string $e
     * @return string
     */
    public function getShortMonthOptions($e="") {
    //$e = (empty($e)) ? date("m")  :$e;
        $option ="<option value=\"null\">Mês</option>\n";
        $e = (int)$e;
        for($d = 1 ; $d <= 12; $d++) {
            if ($d == $e) {
                $option.="<option value=\"{$d}\" selected>".strtoupper(substr(self::$meses[$d-1],0,3))."</option>\n";
            }else {
                $option.="<option value=\"{$d}\">".strtoupper(substr(self::$meses[$d-1],0,3))."</option>\n";
            }
        }
        return  $option;
    }
    /**
     *
     * @param string $e
     * @return string
     */
    public function getYearsOptions($e="") {
        $option ="<option value=\"null\">Ano</option>\n";
        for($d = (2005) ; $d <= (2020); $d++) {
            $option.= $this->optionGenerator($d, $e);
        }
        return  $option;
    }
     /**
     *
     * @param string $e
     * @return string
     */
    public function getHoursOptions($e="") {
        $option ="<option value=\"null\">Hora</option>\n";
        for($d = 0 ; $d <= 23; $d++) {
            $option.= $this->optionGenerator($d, $e);
        }
        return  $option;
    }
    /**
     *
     * @param string $e
     * @return string
     */
    public function getMinutesOptions($e="") {
        $option ="<option value=\"null\">Min</option>\n";
        for($d = 0 ; $d <60; $d++) {
            $option.= $this->optionGenerator($d, $e);
        }
        return  $option;
    }
    private function optionGenerator($instante, $comparator) {
        $instante=($instante < 10) ?"0".$instante: $instante;
        if ($instante == $comparator) {
            return "<option value=\"{$instante}\" selected>{$instante}</option>\n";
        }
        return  "<option value=\"{$instante}\">{$instante}</option>\n";

    }
	/**
	 * Gera um SELECT com o valor do mes em abrevido
	 *
	 * @param string $name
	 * @return string
	 */
    public function getSelectShortMonth($name="shortMonth",$cmp=NULL) {
        if(!$cmp) {
            $cmp=date("m");
        }
        $select = new HTMLElement("select");
        $select->name =$name;
        $select->id   =$name;
        $select->appendChild($this->getShortMonthOptions($cmp));
        return $select->getOutput();
    }


	/**
	 * Gera um SELECT com o valo dor mes em abrevido
	 *
	 * @param string $name
	 * @return string
	 */
    public function getSelectLongMonth($name="shortMonth",$cmp=NULL) {
        if(!$cmp) {
            $cmp=date("m");
        }
        $select = new HTMLElement("select");
        $select->name =$name;
        $select->id   =$name;
        $select->appendChild($this->getLongMonthOptions($cmp));
        return $select->getOutput();
    }


	/**
	 * Gera uma caisa de seleção com a representação de anos.
	 *
	 * @param string $name
	 * @return string
	 */
    public function getSelectYear($name="years",$cmp=NULL,$autoDraw=false) {
        if(!$cmp) {
            $cmp=date("Y");
        }
        $select = new HTMLElement("select");
        $select->name =$name;
        $select->id   =$name;
        $select->appendChild($this->getYearsOptions($cmp));
        if($autoDraw===true){
            $select->printOut();
            return false;
        }
        return $select->getOutput();
    }
	/**
	 * Gera um SELECT com os anos.
	 * @param string $name
	 * @return string
	 */
    public function getSelectMonth($name="month",$cmp=NULL,$autoDraw=false) {
        if(!$cmp) {
            $cmp=date("m");
        }
        $select = new HTMLElement("select");
        $select->name =$name;
        $select->id   =$name;
        $select->appendChild($this->getMonthOptions($cmp));
         if($autoDraw===true){
            $select->printOut();
            return false;
        }
        return $select->getOutput();
    }
	/**
	 * Gera um SELECT com os anos.
	 * @param string $name
	 * @return string
	 */
    public function getSelectDate($name="date",$cmp=NULL,$autoDraw=false) {
        if(!$cmp) {
            $cmp=date("d");
        }
        $select = new HTMLElement("select");
        $select->name =$name;
        $select->id   =$name;
        $select->appendChild($this->getDateOptions($cmp));
        if($autoDraw===true){
            $select->printOut();
            return false;
        }
        return $select->getOutput();
    }
	/**
	 * Gera uma caixa de seleção com os valores representando os minutos
	 * @param string $name
	 * @return string
	 */
    public function getSelectHours($name="hours",$cmp=NULL) {
        if(!$cmp) { $cmp=date("H");}
        $select = new HTMLElement("select");
        $select->name =$name;
        $select->id   =$name;
        $select->appendChild($this->getHoursOptions($cmp));
        return $select->getOutput();
    }

	/**
	 * Gera uma caixa de seleção com os valores representando os minutos
	 * @param string $name
	 * @return string
	 */
    public function getSelectMinutes($name="minutes",$cmp=NULL) {
        if(!$cmp) {
            $cmp=date("i");
        }
        $select = new HTMLElement("select");
        $select->name =$name;
        $select->id   =$name;
        $select->appendChild($this->getMinutesOptions($cmp));
        return $select->getOutput();
    }
/**
	 * Gera uma caixa de seleção com os valores representando os segundos
	 * @param string $name
	 * @return string
	 */
    public function getSelectSeconds($name="seconds",$cmp=NULL) {
        if(!$cmp) {
            $cmp=date("s");
        }
        $select = new HTMLElement("select");
        $select->name =$name;
        $select->id   =$name;
        $select->appendChild($this->getMinutesOptions($cmp));
        return $select->getOutput();
    }
}
?>