<?php

/**
 * @internal comment
 * Interface para determinar a assinatura das classes
 * que clamam implementar Connector
 * este conector deve ser usado para implementar diversos drivers
 * que podem compor uma verdadeira conexao com banco de dados
 */
interface IConnector {
	/**
	 * Um recurso com a conexao atual do banco de dados
	 *
	 */
	public static function createConnector();
	public function getTransaction();
	public static function createMetadataConnector();
	public function getMetadataTransaction();
}

?>