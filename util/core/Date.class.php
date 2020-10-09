<?php
class Date {
// lista de nome para os dias da semana e meses
    protected  $days = array("Domingo", "Segunda", "Ter�a", "Quarta", "Quinta", "Sexta", "S�bado");
    protected  $months = array("", "Janeiro", "Fevereiro", "Mar�o", "Abril", "Maio", "Junho", "Julho", "Agosto","Setembro", "Outubro", "Novembro", "Dezembro");
    // numero de dias para cada mes
    protected $totalDays = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    protected $locale = array("en_US","pt_BR");
    private $year;
    private $month;
    private $date;
    private $startTimeStamp;
    private $iso ;
    private $inputDate;

    /**
     * @param string $date
     * @param boolean $iso
     */
    public function __construct($fullDate=null , $iso = false) {
        date_default_timezone_set("Brazil/East");
        $this->inputDate = (!is_null($fullDate) && strlen($fullDate)==10)? $fullDate:date("Y-m-d");
        $aDate = null;
        $this->iso=$iso;
        $this->check();
        $this->startTimeStamp = getdate(strtotime($fullDate));
    }
    /**
     * @return void
     * Reconfigura o estado de date;
     * @param string $fullDate
     */
    public function changeDate($fullDate=null,$iso=false) {
        $this->inputDate = (!is_null($fullDate) && strlen($fullDate)==10)? $fullDate:date("Y-m-d");
        $this->iso=$iso;
        $this->check();
        $this->startTimeStamp = getdate(strtotime($this->inputDate));
    }

    /**
     *
     *
     * @return string
     */
    public function getDatePTBR() {
        return ($this->date."-".$this->month ."-".$this->year);
    }

    /**
     *Formata a data no padr�o americano, que � como est� nas base de dados
     *
     * @return string
     */
    public function getDateUS() {
        return ($this->year."-".$this->month ."-".$this->date);
    }
    /**
     * Retorna  os segundos passados desde 1 janeiro de 1970 00:00:00
     * tamb�m conhecida com era Unix, at� o instante da instancia��o
     * de Date
     * @return integer
     */
    public function getTime() {
        return $this->startTimeStamp[0];
    }
    /**
     * Retorna o dia do mes no formato legivel.
     * @return integer
     */
    public function getDate() {
        return $this->date;
    }
    /**
     * Retorna a representa��o numerica do mes no formato legivel.
     * um intervalo de 1 a 12, deve-se ficar atento, j� que com
     * uso de array o primeiro mes come�a em 1(um) e n�o 0 (zero)
     * @return integer
     */
    public function getMonth() {
        return $this->month;
    }
    /**
     * Retorna a representa��o gr�fica do mes por extenso
     * se o par�metro opcional no construtor for true o valor
     * retornado � em ingl�s
     * @return string
     */
    public function getMonthName() {
        if($this->iso==true) {
            return $this->startTimeStamp['month'];
        }
        return $this->months[(int)$this->getMonth()];
    }
    /**
     * @return string
     * Retorna o nome do dia da semana  na sua representa��o
     * alfab�tica, por extenso
     *
     */
    public function getDayOfWeek() {
        if($this->iso==true) {
            return $this->startTimeStamp['weekday'];
        }
        return $this->days[$this->startTimeStamp['wday']];
    }
    /**
     * @return string
     * Retorna o nome do dia da semana em abreviado, na sua representa��o
     * alfab�tica
     *
     */
    public function getShortDayOfWeek() {
        if($this->iso==true) {
            return substr($this->startTimeStamp['weekday'],0,3);
        }
        return substr($this->days[$this->startTimeStamp['wday']],0,3);
    }
    /**
     * Retorna a representa��o num�rica do dia da semana.
     * um intervalo de 0 a 6, 0 representado o primeiro
     * dia da semana com domingo e 6  s�bado;
     * @return integer
     */
    public function getNumericalDayOfWeek() {
        return $this->startTimeStamp['wday'];
    }
    /**
     * Retorna o valor do ano do instante atual.
     * @return integer
     */
    public function getYear() {
        return $this->year;
    }
    /**
     * Retorna o valor da hora do instante atual.
     * @return integer
     */
    public function getHours() {
        return date("H");
    }
    /**
     * Retorna o valor da hora do instante atual.
     * @return integer
     */
    public function getHoursString() {
        return date("H:i:s");
    }
    /**
     * Retorna os minutos do instante atual.
     * @return integer
     */
    public function getMinutes() {
        return date("i");
    }
    /**
     * Retorna os segundos do instante atual.
     * @return integer
     */
    public function getSeconds() {
        return date("s");
    }

    public function getNow() {
        return strtotime("now");
    }

    /**
     *
     * O numero de segundos desde o momento em que o objeto
     * foi criado acrescido dos segundos passados como parametros;
     * @param string $seconds
     * @return integer
     */
    public function quantityOfMiliseconds(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime() ;
        $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return $seconds*1000;
    }
    /**
     * Retorna a quantidade de segundos desde
     * o momento da instancia��o do objeto Date mais o valor passado
     * @return string
     * @param string $seconds
     */
    public function quantityOfSeconds(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime() ;
        //  $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return $seconds;
    }
    /**
     * @TODO:
     * @return integer
     */
    public function quantityOfMinutes(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime() ;
        // $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds/60);
    }
    /**
     * @TODO:
     * @return integer
     */
    public function quantityOfHours(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime() ;
        // $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds/3600);
    }
    /**
     * @TODO:
     * @return integer
     */
    public function quantityOfDays(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime() ;

        // $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds/3600/24);
    }
    /**
     *@return integer
     */
    public function quantityOfWeeks(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime() ;
        //  $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds/3600/(7*24));
    }

    /**
     *@FIXME
     */
    public function quantityOfMonths(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime() ;
        //  $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds/3600/(24*30));
    }


    /**
     *FIXME: estou desconsiderando ainda o bisexto
     * @return integer
     */
    public function quantityOfYears(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime() ;
        $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        // verifica se � ano bisexto, modifica o vetor $totalDays
        $year = (date("L", mktime(0, 0, 0, $this->month, 1,$this->year))) ? 366 : 365;

        return ($seconds/3600/(24*$year));
    }

    public function getTimeRegister() {
        return date("YmdHis");
    }
    /**
     *Uma representa��o do data-hora em que o metodo foi chamado,
     * seguindo o padr�o pt_BR.
     * @return string
     */
     public function getTimeStamp(){
        return date("d-m-Y H:i:s");
    }


    /**
     * Metodo interno usado para validar uma data
     * o par�metro $value deve ter o formato de uma data
     * em ingles. Toda est� classe ser� otimizada para
     * operar somente com datas em USA ou PT_BR
     * @param string $value
     *
     */
    private function check() {
        $this->inputDate = str_replace("/","-",$this->inputDate);
        $aDate = explode("-",$this->inputDate);
        if(strlen($aDate[2]) == 4) {
            $this->date  = (is_array($aDate)) ? $aDate[0] : date("d");
            $this->year  = (is_array($aDate)) ? $aDate[2] : date("Y");
        }else {
            $this->year  = (is_array($aDate)) ? $aDate[0] : date("Y");
            $this->date  = (is_array($aDate)) ? $aDate[2] : date("d");
        }
        $this->month = (is_array($aDate)) ? $aDate[1] : date("m");
        return true;
    }
}

?>
