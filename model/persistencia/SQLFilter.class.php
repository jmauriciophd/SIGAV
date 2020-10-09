<?php

class SQLFilter extends SQLExpression {

	private $column;
	private $operator;
	private $value;

	/**
	 *
	 */
	public function __construct($column,$operator,$value){
		$this->column = $column;
		$this->operator = $operator;
		$this->value=$this->transform($value);
	}
	/**
	 * recebe um valor e faz as modificacoes necessarias
	 * para ele ser interpretado pelo banco de dados
	 * podendo ser um integer,boolean,string ou array
	 *
	 *
	 */
	private function transform($value){
		$mounting = null;
		if(is_array($value)){
			foreach ($value as $val) {
				if(is_numeric($val) ){
					$mounting[] = $val;
				}else if (is_string($val)){
					$mounting[] = " '$val' ";
				}
			}
			$result = ' ( ' . implode(",",$mounting) . ' ) ';
		}else if(is_string($value)){
			$result = " '$value' ";
		}else if(is_null($value)){
			$result =  'NULL' ;
		}else if(is_bool($value)){
			$result = ($value) ?  'TRUE' : 'FALSE' ;
		}else{
			$result = $value ;
		}
		return $result;
	}

	public function dump(){
		return " {$this->column} {$this->operator} {$this->value} ";
	}

}
?>