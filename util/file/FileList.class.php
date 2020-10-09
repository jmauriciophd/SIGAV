<?php 
/**
*  FileList
*  Abstract class for reading directories
*/
class FileList {
    protected $path; 
    protected $handle; 
    protected $ls; 
	
    /**
    * FileList constructor
    * @param string path (filesystem path to directory)
    */
    public function FileList ($path) {
        if ( strrpos($path,'/') != 0 ) {
            $this->path=$path.'/';
        } else {
            $this->path=$path;
        }
        $this->ls=array();
    }
 
    /**
    * FileList::read()
    * Abstract
    * ler o conteudo de um diretorio
    * @return void
    */
    abstract public function read();
    abstract public function close ();
    /**
    * FileList::getNext()
    * retorna o primeiro  elemento list
    * e retorna
    *
    * @return string
    */
    public function getNext () {
        return array_shift($this->ls);    
    }
     
}

?> 