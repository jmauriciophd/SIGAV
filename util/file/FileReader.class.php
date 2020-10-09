<?php

class FileReader extends Object  {

  private $file;
  private $fileContent;

  public function FileReader($file) {
    $this->file	= $file;
    if(!file_exists($this->file)){
      throw new Exception ("Arquivo não existe no caminho informado.");
    }
    if(is_readable("./")){
      $file = fopen($this->file, "r");
      $filesize = (filesize($this->file) > 0) ? filesize($this->file) : 1 ;
      $this->fileContent = fread($file, $filesize);
      fclose($file);
    }else{
      throw new Exception("Nao foi possivel abrir arquivo para leitura");
    }

  }
  /**
   * Ler um arquivo completo e retorna todo seu conteudo
   * @return string
   */
  public function readTextFile() {
    try {
      return  $this->fileContent;
    } catch (Exception $e) {
      throw new Exception("Erro na tentativa de ler arquivo");
    }
  }

  /**
   * Retorna uma array de linhas do arquivo, para ser usado num iterator
   * @return array
   *
   */

  public function readLines() {
    $lineArray = array ();
    if($this->fileContent){
      $lineArray = explode("\n", $this->fileContent);
      return $lineArray;
    } else {
      throw new Exception($e->getMessage());
    }
  }

}
?>