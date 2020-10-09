<?php
/**
*  LocalDir
*  Reads the contents of a directory in the local filesystem
*/
class LocalDir extends FileList {
    /**
    * LocalDir constructor
    * Opens local directory
    *
    * @param string path (filesystem path to directory)
    */
    function LocalDir($path) {
        parent::FileList($path);
        $this->handle = opendir($this->path);
    }
 
    /**
    * LocalDir::read()
    * Ler o conteudo do diretorio
    *
    * @return void
    */
    public function read () {
        while ($file = readdir($this->handle)) {
            if (!is_dir($this->path.$file)) {
                $finfo=array();
                $finfo['name']=$file;
                $fname=explode('.',$file);
                if ( !empty ($fname[1]) ) {
                    $finfo['type']=$fname[1];
                } else {
                    $finfo['type']='???';
                }
                $finfo['size']=filesize($this->path.$file);
                $this->ls[]=$finfo;
            }
        }
    }
 
    /**
    * LocalDir::close()
    * Fecha o recurso do tratador
    * @return void
    */

    public function closedir()  {
     fclose($this->handle);
    }
}
?>