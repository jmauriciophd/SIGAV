<?php
/**
 *Class escrita para encapsular metodos escritores
 *de arquivo, aumentar a abstracao do que se faz num nivel mais baixo
 * no processamento de arquivo. Precisa du um
 *objeto File para composicao
 */
class FileWriter {
    private $file;
    private $fileHandler;
    public function FileWriter(File $file) {
        $this->file	= $file;
        if(!file_exists("./")){
            throw new Exception ("Arquivo não poderá ser criado no caminho informado.");
        }
        try{
            $this->fileHandler = $this->file->open();
        } catch (Exception $e){
            echo $e->getMessage()."<br>";
            throw new Exception("Não foi possível abrir arquivo para escrita.");
        }

    }
    /**
     * @param String  $str
     * @return boolean
     */
    public function write($str) {
        try {
            fwrite($this->fileHandler, $str);
            return true;
        } catch (Exception $ex) {
            throw new Exception("Não foi possível gravar");
        }
    }

    public function println($str) {
        try {
            fwrite($this->fileHandler, $str."\n\r");
            return true;
        } catch (Exception $ex) {
            throw new Exception("Não foi possível gravar");
        }
    }

    public function flush(){
        return fflush($this->file->close());
    }

    public function close(){
        return $this->file->close();
    }

    public function append($str){
        try {
            (string) $content = "";
            $content = $str;
            fwrite($file, $content);
            fclose($file);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}
?>