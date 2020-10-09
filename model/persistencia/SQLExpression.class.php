<?php
/**
 * Classe Expression baseada e praticamente copiada
 * no que for possivel na classe TExpression de
 * Pablo Dall'Oglio
 * pablo@dalloglio.net
 *
 */
abstract class SQLExpression{
	const AND_OPERATOR = " AND ";
    const OR_OPERATOR = " OR ";
    
    abstract public function dump();
    
}

?>