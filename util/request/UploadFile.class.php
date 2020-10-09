<?php
/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL-2008
 * @access public
 * @package request
 *
 * @info
 * Classe especialista implementada unicamente para encapsular atributos de
 * um arquivo que for enviado por um cliente web.
 * Inicialmente desenvolvida para ser integrada a uma classe UploadRequest
 * mas tambem pode ser receber um array com as mesmas informacoes de $_FILES;
 *
 * @deficiencia
 *
 * Altamente especialista, embora poss�vel nao recomendado seu uso isolado.
 * Foi implementada dessa forma para suprir a incapacidade do PHP de funcionar com
 * classes internas (inner classe) fato que � possivel com outras linguagens
 * como java.
 * Infelizmente se usada de forma isolada so pode processar um arquivo por vez,
 * enquanto com o uso de UploadRequest podemos gerenciar, qualquer quantidade de
 * arquivos.
 */
class UploadFile{
    private $uploadKey       = null;
    private $extension= null;
    private static $allowed  = null;
    /**
     * deve receber um array com as informa��es de cada
     * arquivo passado para upload encapsulando assim
     * o conhecimento sobre apenas um arquivo, segue a uma interface
     * comum e bem estrutura. Aumenta a granularidade e d� a
     * possibiliade de usar um iterator sem ter que aumentar a interface
     * de UploadRequest que s� deve saber processar a requisi��o.
     *
     * @param array $fileProperties
     * @param array $allowed
     * @throws Exception
     */
    public function __construct(array $fileProperties,array $allowed){
        self::$allowed = $allowed;
        //verifica se e' um array e se traz a estrutura interna de $_FILES
        if(is_array($fileProperties) && array_key_exists("name",$fileProperties)){
            foreach ($fileProperties as $key => $value) {
                $this->uploadKey[$key]  = $value;
            }
        }else{
            throw new Exception("Par�metro incorreto no construtor de UploadFile().");
        }
    }

    /**
     * Recupera o nome do arquivo enviado pelo cliente web.
     * @return string
     */
    public function getFilename(){
        return $this->uploadKey["name"]  ;
    }
    /**
     *Recupera o nome do arquivo enviado pelo cliente web
     * codificado em UTF-8, necessario em alguns sistemas de arquivos
     * @return string
     */
    public function UTF8EncodeFilename(){
        return utf8_encode($this->filename["name"]);
    }

    /**
     * Retorna o tipo MIME do arquivo enviado, � interessante para
     * facilitar facilmente bloqueios por tipo de arquivos, ou mesmo conversoes
     * de MIMETYPE
     *
     * @return string
     */
    public function getType(){
        //o uso de is_uploaded_file e' de extrema importancia para os dias atuais
        //e' uma regra de seguranca
        if(is_uploaded_file($this->getTempFilename())){
            return $this->uploadKey["type"] ;
        }
    }

    /**
     * Retorna verdeiro se algum erro  foi gerado durante o processo
     * de recebimento do arquivo.
     *
     * @return boolean
     */
    public function hasError(){
        if ($this->uploadKey["error"]> 0){
            return true;
        }
        return false;
    }

    /**
     * Retorna uma mensagem de erro gerado durante o processo
     * de recebimento do arquivo.
     *
     * @return string;
     */
    public function getErrorMessage(){
        switch ($this->uploadKey["error"]){
            case 1:
                return "Arquivo ".$this->getFilename()." excedeu limite m�ximo permitido pelo servidor.";
                break;
                 
            case 2:
                return "Arquivo ".$this->getFilename()." excedeu limite de permitido.";
                break;
                 
            case 3:
                return "Arquivo ".$this->getFilename()." parcialmente carregado.";
                break;

            case 4:
                return "N�o houve upload do arquivo " .$this->getFilename() .".";
                break;
                 
            default:
                return "Upload efetuado com sucesso.";
                break;

        };

    }
    /**
     * Recupera o nome tempor�rio do arquivo,
     * que � usado somente para manuten��o interna.
     * Este m�todo ode ser privado, mas como o PHP
     * apresenta livremente este parametro, resolvi
     * deix�lo publico;
     *
     * @return string
     */
    public function getTempFilename(){
        //verifica se o o nome passado � mesmo um arquivo
        if(is_file($this->uploadKey["tmp_name"])){
            return $this->uploadKey["tmp_name"] ;
        }else{
            $this->uploadKey["error"]=4;
            throw new Exception("Tentiva inv�lida. N�o � um arquivo.\n".
            $this->getErrorMessage());
        }
    }
    /**
     * Recupera o tamanho real do arquivo em bytes.
     *
     * @return integer
     */
    public function getFileSize(){
        //testa se este arquivo est� mesmo vindo de um upload
        if(is_uploaded_file($this->getTempFilename())){
            return $this->uploadKey["size"] ;
        }else{
            $this->uploadKey["error"]=4;
            throw new Exception("Seu sistema provavelmente est� sofrendo uma a��o de um usu�rio malicioso.\n".
            $this->getErrorMessage());
        }
    }
    /**
     * Move o arquivo enviado para o lugar de destino.
     * Ao mover exclui o arquivo tempor�rio
     * @param string $destiny
     * @param integer $index
     */
    public function moveFileTo($destiny){
        //testa se este arquivo est� mesmo vindo de um upload
        if(is_uploaded_file($this->getTempFilename())){
            //tenta transferir para o destino e se sair algo errado lan�a uma exce��o.
            if(!move_uploaded_file($this->getTempFilename(),$destiny)){
                throw new Exception("N�o foi poss�vel transferir o arquivo carregado.");
            }
        }else{
            $this->uploadKey["error"]=4;
            throw new Exception("Seu sistema provavelmente est� sofrendo uma a��o de um usu�rio malicioso.\n".
            $this->getErrorMessage());
        }
    }
    /**
     * Recupera a extens�o do arquivo.
     *
     * @return mixed
     */
    public function getExtension(){
        if(is_null($this->extension)){
            return false;
        }
        return $this->extension;
    }

    /**
     *
     * Faz um levantamento para decidir se pode ou nao fazer um upload
     * para o tipo de arquivo passado no construtor.
     *
     *  @return boolean
     *
     */
    public function canDoUpload(){
        //calcula a primeira ocorr�ncia de um ponto separador de extens�o
        //na ordem reversa
        $startPos = strrpos($this->getFilename(),".");
        $length = strlen($this->getFilename()) - $startPos;
        //posiciona o ponteiro na posicao e recupera somente a
        //extensao do arquivo.
        $file_ext = substr($this->getFilename(),$startPos+1,$length) ;
        //
        $this->extension = $file_ext;
        $notIn = 0;
        $allowed=" ";
        $yesYouCan="";
        //agora est� pronta para fazer uma verifica�ao
        //de padroes permitidos para upload, conforme desejado
        if(is_array(self::$allowed)){
            //entra numa iteracao, assim n�o ser� preciso criar os padr�es necess�rios
            //o objeto ser� capaz de se auto analizar se tornando polim�rfico
            //n�o haver� necessidade de reescrever para suportar novos tipo de extens�es
            foreach (self::$allowed as $allowed){
                $yesYouCan .="*.$allowed ";
                //Faz an�lise atraves de uma express�o regular simples
                //e em caso de falha incrementa a variavel $notIn
                if(!preg_match("/$allowed/",$file_ext) ){
                    $notIn++;
                }
                //no final, se nenhuma extens�o permitida for encontrada
                //o valor de $notIn ser� igual ao tamanho do vetor passado
                //com as extens�es e entao lan�ara uma exce��o
                if($notIn == count(self::$allowed)){
                    $this->uploadKey["error"]=4;
                    $tipo_permitido = "Os tipos permitdos s�o: $yesYouCan;";
                    throw new Exception("Um arquivo passado n�o � permitido pelo sistema!\n$tipo_permitido".
                    $this->getErrorMessage());
                }
            }
            return true;
        }
        return false;
    }
}
?>