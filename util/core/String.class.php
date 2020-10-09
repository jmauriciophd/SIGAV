<?php
class String extends Object {
    private $restore;
    private $precision = 2;
    private $decimalSeparator = ",";
    private $thousandSeparator = ".";
    private $value;
    public function String($string=null) {
        $this->value = (is_null($string))?"":(string)$string;
    }
    public function setValue($string=null) {
        $this->value = (is_null($string))?"":$string;
    }
    /**
     *@return Boolean Compara dois objetos String para ver se sao iguais
     *@param Object $obj
     */
    public function equals($obj) {
        if (!$obj instanceof String) {
            return false;
        }
        if ($this->__toString() === $obj->__toString()) {
            return true;
        }
        return false;
    }
    /**
     * @return String
     * Este metodo retorna o valor de texto corrente do objeto
     */
    public function valueOf() {
        return $this->value;
    }
    /**
     * @return String
     * Este metodo retorna o valor de texto corrente do objeto
     */
    public function __toString() {
        return (string)$this->value;
    }
    /**Informa o comprimeto do Objeto string
     * @return Integer
     */
    public function length() {
        return (integer)strlen($this->value);
    }
    /**
     *@return string
     */
    public function substr($start, $length) {
        if(!is_numeric($start) || !is_numeric($length)){
            throw new Exception("Parâmetros incorretos");
        }
        $str = $this->value;
        return  substr($str, $start,$length);
    }
    /**
     * Uma comprimento fixo de string delimitado entre $start e $length
     * @return string
     */
    public function subString($start=0, $length= 0) {
        $length = ($start == 0)      ? $length +1 : $length;
        $length = (!$length)         ? $start  +1 : $length;
        $length = ($length == $start)? $start  +1 : $length;
        return (string) substr($this->value, $start, ($length - $start));
    }
    /**
     * @return string
     */
    public function reverse() {
        return (string) strrev($this->value);
    }
    /**
     *@return string
     */
    public function getMD5Encripted() {
        return (string) md5($this->value);
    }
    /**
     *@return string
     */
    public function replace($find, $replaceby) {
        return (string) str_replace($find, $replaceby, $this->value);
    }
    /**
     * @return
     */
    public function indexOf($string, $onebased = false) {
        if ($onebased==true) {
            return (integer) (strpos($this->value, $string) + 1);
        } else {
            return (integer) strpos($this->value, $string);
        }
    }
    /**
     * @return string
     */
    public function charAt( $index, $onebased = false) {
        if ($onebased == true) {
            return (string) (substr($this->value, ($index - 1), 1));
        } else {
            return (string) (substr($this->value, $index, 1));
        }
    }
    /**
     *@return string escapada
     */
    public function newLine($count = 0) {
        for ($c = 0; $c <= $count; $c++) {
            return (string) "\n";
        }
    }
    /**
     * @return string
     */
    public function getValue() {
        return (string) $this->value;
    }
    /**
     * Reconfigura o valor interno de String, tal qual foi inicialmente instanciado.
     *@return  void;
     */
    public function restoreDefaults(){
        $this->value = $this->restore ;
    }
    /**
     * @return string
     */
    public function toUpperCase() {
        $this->restore = $this->value;
        $this->value = strtoupper($this->value);
        return $this->value;
    }
    /**
     * @return string
     */
    public function toLowerCase() {
        $this->restore = $this->value;
        $this->value = strtolower($this->value);
        return $this->value; 
    }
    public function capitalize() {
        $this->restore = $this->value;
        $this->value = ucwords(strtolower($this->value));
        return $this->value;
    }
    /**
     *@return void
     */
    public function setLocale($type, $country) {
        setlocale($type, $country);
    }
    /**
     *@return string
     */
    public function getLocale() {
        $locale = localeconv();
        foreach ($locale as $localeName => $value) {
            return $localeName . " = " . $value . "<br>";
        }
    }
    /**
     *
     */
    public function setLocaleAll($country) {
        setlocale(LC_ALL, $country);
    }
    /**
     *
     */
    public function setLocaleMonetary($country) {
        setlocale(LC_MONETARY, $country);
    }
    /**
     *
     */
    public function setLocaleType($country) {
        setlocale(LC_CTYPE, $country);
    }
    /**
     *
     */
    public function setLocaleNumeric($country) {
        setlocale(LC_NUMERIC, $country);
    }
    /**
     *
     */
    public function setLocaleTime($country) {
        setlocale(LC_TIME, $country);
    }
    /**
     *
     */
    public function setLocaleComparation($country) {
        setlocale(LC_COLLATE, $country);
    }
    /**
     *
     */
    public function setLocaleDefault() {
        setlocale(LC_ALL, NULL);
    }
    /**
     *
     */
    public function setFloatPrecision($precision) {
        $this->precision = $precision;
    }
    /**
     *@return  void
     *@param string $separator
     */
    public function setDecimalSeparator( $separator) {
        $this->decimalSeparator = $separator;
    }
    /**
     *@return  void
     *@param string $separator
     */
    public function setThousandSeparator($separator) {
        $this->thousandSeparator = $separator;
    }
    /**
     * @return void Configura a precisao de casas decimais
     *
     */
    public function setNumberPrecision($precision=0) {
        $this->precision = $precision;
    }
    /**
     * Formata uma string numerica que pode ser convertida
     * em um float com as casas de milhares devidamente agrupadas
     *@return float
     */
    public function stringToNumber() {
        return number_format(floatval($this->value),
        $this->precision, $this->decimalSeparator,
        $this->thousandSeparator);
    }
    /**
     *@return string
     */
    public function stringToCurrency() {
            return money_format(floatval($this->value), 
            $this->precision, 
            $this->decimalSeparator, 
            $this->thousandSeparator);       
    }
}
?>