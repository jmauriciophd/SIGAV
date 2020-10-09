<?php
class SQLCriteria extends SQLExpression {

	private $properties   ; //propriedades do criterio
	private $operators     ; //armazena alista de operadores
	private $expressions=null  ; //armazena a lista de expressoes

	public function __construct(){}

	public function add(SQLExpression $expression, $operator =self::AND_OPERATOR){
		//na primeira vez, nao precisamos de operador logico para concatenar.
		if(!$this->expressions){
			$operator =" ";			
		}
		$this->expressions[] = $expression;
		$this->operators[]  = $operator;
	}
	/**
	 * Retorna expressao final
	 *
	 * @return string
	 */
	public function dump(){
		$operator=" ";
		$result  =" ";
		//concatena a lista de expressoes
		if(is_array($this->expressions)){
			foreach ($this->expressions as $i=>$expression) {
				$operator  = $this->operators[$i];
				//Concatena o operador com a respectiva expressao
				$result   .= $operator . $expression->dump().' ';
			}
			$result = trim($result);
			return " ({$result})";
		}
	}
	/**
	 * Define o valor de um propriedade;
	 *
	 * @param mixed $property
	 * @param mixed $value
	 */
	public function setProperty($property, $value){
		$this->properties[$property] = $value;

	}
	public function getProperty($property){
       $this->properties[$property];
	}
	public function reset(){
		$this->expressions= null;
		$this->operators  = null;
		$this->properties = "";
	}
}
?>