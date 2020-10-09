<?php
/**
 * @author Gedalias Freitas da Costa
 * @copyright Copyright &copy; 2007, Gedalfc@gmail.com
 * @since 2008-12-31
 */
final class  DriverManager{
	private static $driver ;
	private static $driverPool;
	private static $metaPool;
	/**
	 *Um objeto de transacao que pode ser usado para persistir dados independente da base
	 *@param mixed $url
	 *@return Transaction
	 * modelo de $url a ser passada pro metodo getTransaction
	 * pgsql:usuario:senha:host:dbname
	 *
	 */
	public static function getTransaction($url=null) {
		self::driverList();
		if(is_string($url) && strpos($url,":")){
			$url   = str_replace(" ","",$url);
			$url   = explode(":",$url);
			$driver= (is_string($url[0]))  ? strtolower($url[0]) : "";			 
		}else{
			throw new Exception("Passagem de parámetro incorreto em getTransaction()");
		}
		if (!isset(self::$driverPool["$driver"])) {
			$dataBaseDriver = self::$driver["$driver"];
			//instancia uma fabrica concreta
			$classname = $dataBaseDriver."Factory";
			$factory = new $classname;
			//e chama o metodo fabrica da classe correta para instaciar o objeto
			self::$driverPool["$driver"] = $factory->getTransaction($url[1],$url[2],$url[3],$url[4]);
		}
		return self::$driverPool["$driver"];
	}
	/**Um objeto de transacao que que deve ser usado para reuperar metadados de um banco de dados
	 *
	 * @param string $url
	 * @return ITransMetadata
	 */
	public static function getTransMetadata($url=null) {
		self::driverList();
		if(is_string($url) && strpos($url,":")){
			$url   = str_replace(" ","",$url);
			$url   = explode(":",$url);
			$driver= (is_string($url[0]))  ? strtolower($url[0]) : "";			 
		}else{
			throw new Exception("Passagem de parametro incorreto em getTransaction()");
		}
		if (!isset(self::$metaPool["$driver"])) {
			$dataBaseDriver = self::$driver["$driver"];
			//instancia uma fabrica concreta
			$classname = $dataBaseDriver."Factory";
			
			$factory = new $classname;
			
			//e chama o metodo fabrica da classe correta para instaciar o objeto
			self::$metaPool["$driver"] = $factory->getMetadataTransaction($url[1],$url[2],$url[3],$url[4]);
		}
		return self::$metaPool["$driver"];
	}
	private function  __construct(){}
	private static function driverList(){
		self::$driver["pgsql"]  ="Postgres";
		self::$driver["mysql"]  ="Mysql";
		self::$driver["odbc"]   ="Odbc";
		self::$driver["firebird"]  ="Firebird";
		//self::$driver["msql"]   ="Msql";
		//self::$driver["mssql"]  ="Mssql";
		self::$driver["oracle"] ="Oracle";
		
	}
}
?>