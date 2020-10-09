<?php
require_once dirname(__FILE__) . "/../../../config/config.sys.php";
class MysqlFactory implements IConnector {
    private static $transaction;
    private static $transMetadata;
    private static $user	= USUARIO_BD;
    private static $passwd  = SENHA_BD;
    private static $host 	= NOME_SERVIDOR_BD;
    private static $dbname  = NOME_BD;
    
    public function __construct() {}
    /**
     * Gerencia a instanciacao de um MysqlAccess e um MysqlTransaction
     * @return MysqlTransaction
     */
    public static function createConnector() {
        if(!isset(self::$transaction)) {
            $connector = new MysqlAccess(self::$user, self::$passwd, self::$host, self::$dbname);
            self::$transaction = new MysqlTransaction($connector);
        }
        
        return self::$transaction;
    }
    
    public static function conectarBancoMysql() {
    	MysqlAccess::conectarBancoMysql(self::$user, self::$passwd, self::$host, self::$dbname);
    }

    public function getTransaction() {
        return self::createConnector();
    }
    
    /**
     * Gerencia a instanciacao de um MysqlAccess e um MysqlTransMetadata
     * @return MysqlTransMetadata
     */
    public static function createMetadataConnector() {
        if(!isset(self::$transMetadata)) {
            $connector         = new MysqlAccess(self::$user, self::$passwd, self::$host, self::$dbname);
            self::$transMetadata = new MysqlTransMetadata($connector);
        }
        return self::$transMetadata;
    }
    /**
     * Gerencia a instanciacao de um MysqlAccess e um MysqlTransaction
     * @return MysqlTransMetadata
     */
    public function getMetadataTransaction() {
        return self::createMetadataConnector(self::$user, self::$passwd, self::$host, self::$dbname);
    }
}


?>