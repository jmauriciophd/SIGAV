<?php

class File {
	private $name        = null;
	private $fileHandler=null;
	private $size       =0;
	private $writable   = false;
	private $filelist   = array();
	private $dirlist   = array();
	public function File($path, $file=null) {

		//echo $fwdSlash."<br>";
		if( (strrpos($path,"/") != strlen($path)-1) &&
		is_dir($path)){
			$path .= "/";
		}
		//analisa se é um diretorio, inicializa a lista de arquivos
		$this->isDir($path);
		//echo $filename ."<br>";
		$this->name = $path;
	}
	/**
	 * Cria um novo arquivo, apartir do nome dado
	 * @return boolean
	 *
	 */
	public function createNewFile(){
		if($this->isFile() || $this->exists()){
			return true;
		}
		if(!$this->exists()){
			fclose(fopen($this->name,"w"));
			return true;
		}
		return false;
	}

	/**
	 * Tenta criar o diretório.
	 * Retorna TRUE em caso de sucesso ou FALSE em falhas.
	 * Atualmente desconsidera seu uso em Windows.
	 * @return boolean
	 */
	public function createDirectory(){
		if($this->isDirectory()){
			return true;
		}
		if(!$this->exists()){
			return  @mkdir($this->name,0777,true);
			
		}
		return false;
	}
	/**
	 * Enter description here...
	 *
	 * @param  int $mode
	 * @return boolean
	 */
	public function changeAccess($mode){
		if($this->isDirectory() || $this->isFile() ){
			return chmod($this->name,$mode);
		}
		return false;
	}
	/**
	 * Retorna um vetor contendo  a lista de todos os arquivos
	 * contidos neste diretório
	 *
	 * @return array
	 */
	public function getFileList(){
		return $this->filelist;
	}
	/**
	* Retorna um vetor contendo  a lista de todos os diretorios
	* contidos neste diretório
	*
	* @return array
	*/
	public function getDirectoryList(){
		return $this->dirlist;
	}
	/**
	 *@return string com o nome do arquivo
	 */
	public function getFilename() {
		return $this->name;
	}
	/**
	 * Retorna o tamanho do arquivo, ou -1 em caso de erro.
	 *
	 * @return integer
	 */
	public function getFilesize() {
		if($this->exists()){
			$this->size = filesize($this->name);
			return $this->size;
		}
		return -1;
	}
	/**
	 * Retorna TRUE se o nomedoraquivo existe e é legível (readable).
	 * Esta função não trabalha com arquivos remotos.
	 * @return boolean
	 *
	 */

	public function isReadable() {
		return is_readable($this->name);
	}
	/**
	 * Renomeia um arquivo ou um diretório.
	 * Retorna TRUE em caso de sucesso ou FALSE em falhas.
	 * @param  string $newName
	 * @return boolean
	 */
	public function rename($newName) {
		return rename($this->name, $newName);
	}
	/**
	 * Informa se o aruivo passado é executável e
	 * retorna verdadeiro ou falso em caso contrário.
	 * @return boolean
	 */
	public function isExecutable() {
		return is_executable($this->name);
	}
	/**
	 * Checa se um diretório ou um arquivo existe e se existir
	 * retorna verdadeiro ou falso em caso contrário.
	 *
	 * @return boolean
	 */
	public function exists() {
		//echo $this->name;
		return file_exists($this->name);
	}
	/**
	 * @return boolean
	 * @Param string $mode para infomar o modo de arbertura de arquivo
	 */
	public function open($mode = null) {
		$mode = (is_string($mode))?$mode:"w";
		$this->fileHandler = @fopen($this->name,$mode);
		if($this->fileHandler){
			return $this->fileHandler ;
		}else{
			throw new Exception("Não tem permissão de escrita.");
		}
	}

	/**
	 * @return boolean
	 */
	public function close() {
		return fclose($this->fileHandler);
	}
	/**
	 *
	 *
	 * @param string $path
	 * @param boolean $mayDestroy
	 * @return boolean
	 */
	public function copyTo($path,$mayDestroy=false) {
		//verifica se a origem é emsmo um arquivo
		if(!is_file($this->name)){
			throw new Exception("O arquivo File não é um arquivo e não poderá ser copiado.");
		}
		//verifica se pode-se manipular o caminho seja um dir ou um arquivo
		if(is_writable($path)){
			//recupera o ultimo caracter
			$lastChar = substr($path,strlen($path)-1,1);
			if($lastChar=="/" && is_dir($path)){
				$path = $path.$this->name;
			}
			//é feita uma verificacao para garantir a montagem correta de $path
			if($lastChar!="/" && is_dir($path)){
				$path = $path."/".$this->name;
			}
			if($lastChar!="/" && is_file($path) && $mayDestroy===false){
				throw new Exception("O arquivo destino já existe e a cópia não será permitida.");
			}
			@copy($this->name,$path);
			chmod("$path",0777);
		}
		return true;
	}
	/**
	 * Retorna TRUE se o arquivo ou diretório existe e pode ser escrito nele.
	 *
	 * @return boolean se o arquivo tiver permissão de escrita
	 */
	public function isWritable() {
		if(is_writable($this->name)){
			return is_writable($this->name);
		}else{
			throw new Exception("Não tem permissão de escrita neste diretório.");
		}

	}

	/**
	 * Retorna TRUE em caso de sucesso ou FALSE em falhas.
	 * Somente pode tratar arquivos que tem permissão de escrita.
	 *
	 * @return boolean
	 * @param string $directory com o diretório de destino
	 */
	public function moveTo($directory) {
		if(!is_file($this->name)){
			return false;
		}
		if(is_dir($directory) && is_writable($directory) && is_writable($this->name)){
			copy($this->name,"{$directory}/{$this->name}");
			chmod("{$directory}/{$this->name}",0777);
		}else{
			throw new Exception("O destino não pode escrito ou não é um diretório.");
		}
		delete($this->name);
		return true;

	}
	/**
	 * Diz se o arquivo é um arquivo comum (não é diretório).
	 * Retorna TRUE se o arquivo existe e é um arquivo comum.
	 * trabalha somente com arquivos locais ao sistema de arquivos
	 * @return boolean
	 */
	public function isFile() {
		return is_file($this->name);
	}
	/**
	 * Diz se o arquivo é um link simbólico
	 * Retorna TRUE se o arquivo existe e é um link simbólico
	 * Trabalha somente com arquivos locais ao sistema de arquivos
	 * @return boolean
	 */

	public function isLink() {
		return is_link($this->name);
	}
	/**
	 * Analisa as permissoes de um arquivo e retorna uma string
	 * com a representacao dessas permissoes.
	 * @param File $file
	 * @return string
	 */
	function getFilePermissions(File $file=null) {

		$perms = ($file !=null) ? fileperms($file) : fileperms($this->getFilename()) ;
		if (($perms & 0xC000) == 0xC000) {$info = 's';     } // Socket
		else if (($perms & 0xA000) == 0xA000) {$info = 'l'; } // Symbolic Link
		else if (($perms & 0x8000) == 0x8000) {$info = '-'; } // Regular
		else if (($perms & 0x6000) == 0x6000) {$info = 'b'; } // Block special
		else if (($perms & 0x4000) == 0x4000) {$info = 'd'; } // Directory
		else if (($perms & 0x2000) == 0x2000) {$info = 'c'; } // Character special
		else if (($perms & 0x1000) == 0x1000) {$info = 'p'; } // FIFO pipe
		else {$info = '?';} // Unknown
		// Owner
		$info .= (($perms & 0x0100) ? 'r' : '-');
		$info .= (($perms & 0x0080) ? 'w' : '-');
		$info .= (($perms & 0x0040) ?
		(($perms & 0x0800) ? 's' : 'x' ) :
		(($perms & 0x0800) ? 'S' : '-'));
		// Group
		$info .= (($perms & 0x0020) ? 'r' : '-');
		$info .= (($perms & 0x0010) ? 'w' : '-');
		$info .= (($perms & 0x0008) ?
		(($perms & 0x0400) ? 's' : 'x' ) :
		(($perms & 0x0400) ? 'S' : '-'));
		// Others
		$info .= (($perms & 0x0004) ? 'r' : '-');
		$info .= (($perms & 0x0002) ? 'w' : '-');
		$info .= (($perms & 0x0001) ?
		(($perms & 0x0200) ? 't' : 'x' ) :
		(($perms & 0x0200) ? 'T' : '-'));
		return $info;
	}
	
	/**
	 * @return boolean se o arquivo tiver permissão de escrita
	 */
	public function delete(){
		return delete($this->name);
	}
	/**
	 * @return boolean se o arquivo tiver permissão de escrita
	 */

	public function isDirectory(){
		return is_dir($this->getFilename());
	}
	/**
	 * Retorna TRUE em caso de sucesso ou FALSE em falhas.
	 *
	 * Tenta remover o diretório.
	 * O diretório tem que estar vazio e as permissões
	 * relevantes autorizarem a esta operação.
	 *
	 * @return boolean
	 */
	public function remove(){
		if($this->isDirectory() && $this->isWritable()){
			return rmdir($this->name);
		}
		if($this->isFile()){
			return unlink($this->name);
		}
		return false;
	}
	/**
	 * @return string com a descricao do caminho completo
	 */
	public function valueOf() {
		return (string) $this->getFilePermissions($this);
	}
	/**
	 * @return String
	 * O valor string do objeto File
	 */
	public function __toString() {
		return $this->name;
	}
	/**
	 * @return boolean true se forem iguais
	 * Compara para verificar se dois objetos File sao exatamente iguais
	 */
	public function equals(Object $obj) {
		if (!$obj instanceof File) {
			throw new Exception("Tipo de objeto inválido para comparação");
		}
		if ($this->name == $obj->getFilename()) {
			return true;
		}
		return false;
	}

	////////////////////////////////////////////////////////////////
	private function isDir($dir){
		// Checa se um arquivo ou diretório existe e nao tem permissao de Leitura
		if(!is_readable($dir) && file_exists($dir)){
			throw new Exception("Não tem permissão para acessar este diretório.");
		}
		if (is_dir($dir)) {
			if ($structDir = opendir($dir)) {
				while (($filename = readdir($structDir)) !== false) {
					if(is_file($dir.$filename)){
						$this->filelist[]=$filename;
					}
					if(is_dir($dir.$filename)){
						$this->dirlist[]=$filename;
					}
				}
				closedir($structDir);
			}
		}
		return true;
	}
}
?>