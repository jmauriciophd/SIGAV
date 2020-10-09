<?php

/**
 * Ao definir o metodo __destructor(() torna-se impossivel
 * usar a classe, ao que parece o destrutor � chamado antes da classe do arquivo
 * chamador ser encerrado
 *
 */

/**
 * @author Gedalias Freitas da Costa
 * @copyright Copyright &copy; 2007, Gedalfc@gmail.com
 *
 */
class MysqlAccess {
    private $myConnector = null;
    private $size = 0;
    private $result = null;
    
    public function MysqlAccess($user,$passwd,$host,$dbname) {
        $this->myConnector = new mysqli($host, $user, $passwd, $dbname) ;
        
		if(mysqli_connect_errno()){
			trigger_error('Erro ao tentar conectar com o banco de dados. ' . $this->myConnector->error, E_USER_ERROR);
		}
    }
    
	public static function conectarBancoMysql($user,$passwd,$host,$dbname){
    	$conn = mysql_connect($host, $user, $passwd)  or die ("Erro ao se conectar ao servidor");
		$bd	  = mysql_select_db($dbname) or die ("Erro ao se conectar ao banco");
		return $conn;
    }

    /**
     * Carrega um arquivo devidamente formatado, com SQL ANSI
     * com delimitadores de texto ";\n". e passa para o banco a fim de
     * criar a base de dados se ele ainda nao existir
     *
     * @param string
     */
    public function createDatabase($filename) {
        if (!$this->getDatabase()) {
            if (file_exists($filename)) {
                $arquivo = fopen($filename, "r");
                $leitura = fread($arquivo, filesize($filename));
                $sql = explode(";\n", $leitura);
                $i = 0;
                do {
                    $ok = $this->myConnector->query(current($sql)) ;
                    if ($this->myConnector->error) {
                        throw new ErrorException($this->myConnector->error);
                    }
                    $i++;
                } while (next($sql));
                if($i==count($sql)) {
                    return true;
                }else {
                    throw new Exception("Não foi possível criar a base de dados.");
                }
                fclose($arquivo);
            }
        }
    }
    /**
     * @return Recurso
     * Um recurso com a ultima conexao Mysql válida
     */
    public function getConnector() {
        return $this->myConnector;
    }
    
    public function close() {
        $this->myConnector->close();
    }
} //fim da classe ;
?>
