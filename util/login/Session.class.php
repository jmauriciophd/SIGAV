<?php
class Session {
    private $sessionId;
    private $sessionName;
    private static $singleStruct = null;
    private $timeout = 0;
    private $savePath  ;
    private $encode = null;
    private $cookiesParam = array();
    private $ltime;
    private $path;
    private $domain;
    private $secure;
    /**
     * Construtor
     *
     * @param string $id
     * @param string $name
     * @return Session
     *
     */
    public function Session($path=null, $id=null, $name=null) {
    //prepara��o para cria��o de uma sessao ideal, com o menor
    //problema possivel. As fun��es do PHP e os nomes
    //nao costuma seguir uma padroniza��o e esta classe tenta resolver isso
        /***************************************************/
        $this->savePath = (is_string($path) && is_dir($path))?$path:session_save_path();

        $this->cookiesParam = session_get_cookie_params();
        $this->ltime  = $this->cookiesParam["lifetime"];
        $this->path   = $this->cookiesParam["path"];
        $this->domain = $this->cookiesParam["domain"];
        $this->secure = $this->cookiesParam["secure"];
        session_save_path($this->savePath);

        /***************************************************/
        $this->timeout=1200;
        $this->sessionName = (is_null($name)) ? session_name() : $name ;
        $this->sessionId   = (is_null($id))   ? session_id()   : $id;
        // $this->setCacheExpire();
        if(!isset($_SESSION) || is_null($_SESSION) || empty($_SESSION) ) {
            session_set_cookie_params($this->ltime,$this->path ,$this->domain, $this->secure);
            session_start();
        }
        //Garante a exist�ncia de apenas uma refer�ncia para dados de sess�o
        //Atrav�s de um SingleTon
        if(is_null(self::$singleStruct)) {
            self::$singleStruct = array();
            self::$singleStruct = $_SESSION ;
            //emcapsula
            $_SESSION   ;
        }

    }
    /**
     * Configurar o id de sess�o determinado pelo usuario
     * ao inv�s do padrao.
     *
     * @param string $id
     */
    public function setId($id=null) {
        if(is_string($id)) {
            $this->sessionId = md5($id);
            session_id($this->sessionId);
        }else {
            throw new Exception("Par�metro inv�lido em setSessionId() de Session.");
        }
    }
    /**
     * Recupera o valor do id da sess�o
     *
     * @return string
     */
    public function getId() {
    //Obt�m e/ou define o id de sess�o atual
        if(strlen($this->sessionId) > 0) {
            return $this->sessionId;
        }
        return null;
    }
    /**
     * Recupera o valor do nome dado a sess�o.
     *
     * @return string
     */
    public function getName() {
        if(strlen($this->sessionName) > 0) {
            return $this->sessionName;
        }else {
            return null;
        }
    }
    /**
     * Recupera valores de sess�o e os armazena internamente, devendo ser
     * lido por m�todos leitores.
     * @return void
     */
    private function restoreValues() {
        $this->sessionId = session_id();
        $this->sessionName = session_name();
        $this->usuarioLogado = session_decode();
    }
    /**
     * @FIXME
     */
    public function validate() {
        if (session_id() == $this->sessionId) {
            return true;
        }
        return false;

    }
    /**
     * Acrescenta um elemento a sess�o corrente
     *
     * @param string $item
     * @param string $itemName
     * @throw Exception
     */
    public function addItem($itemName=null,$item=null) {
        //echo $itemName ." - " .$item; //DEBUGAR
        if(is_string($item) && is_string($itemName)) {
            self::$singleStruct[$itemName] = $item;
        }else {
            $this->destroy();
            throw new Exception("Par�metro inv�lido em addItem() de Session.");
        }
    }
    /**
     * Acrescenta um elemento a sess�o corrente
     *
     * @param string $item
     * @param string $itemName
     * @return string
     * @throw Exception
     */
    public function getItem($item=null) {
        $item = (string)$item;
        if(array_key_exists($item,self::$singleStruct)) {
            return self::$singleStruct[$item];
        }
        return null;
        //else {
           // throw new Exception("�ndice inv�lido em getItem() de Session. Este �ndice n�o existe na Sess�o.");
        //}
    }

    /**
     * Acrescenta um elemento a sess�o corrente
     * @return Array
     */
    public function getItems() {
        if($this->getSize()) {
            return self::$singleStruct;
        }else {
            return null;
        }
    }
    /**
     * A quntidade Elementos na sess�o corrente
     *
     * @return integer
     */
    public function getSize() {
        return count(self::$singleStruct);
    }

    /**
     * Acrescenta um elemento a sess�o corrente
     *
     * @param string $itemName
     */
    public function removeItem($itemName=null) {
        $vec = array();
        //self::$singleStruct=null;
        //self::$singleStruct= array();
        //Percorre todo o elemento da estrutura de Session
        //na busca do nome do item desejado e o remove
        foreach (self::$singleStruct as $kName=>$vItem) {
            if($kName != $itemName) {
                $vec[$kName] = $vItem;
            }
        }
        // armazena o novo vetor sem o elemento ecncontrado
        //na estrutura interna
        self::$singleStruct = $vec;
        $vec = null;
    }

    /**
     * D� in�cio a sessao e armazena os dados no array de sess�o
     *@return void
     *
     */
    private function beginSession() {
        session_id($this->sessionId);
        session_name($this->sessionName);
    }

    /**
     * Destr�i todos os dados associados com a sess�o atual.
     * N�o anula qualquer vari�vel global que esteja associada com a
     * sess�o, nem anula cookies de sess�o.
     *
     *@return boolean
     */
    public function destroy() {
        return session_destroy();
    }
    /**
     * Configura o valor em minutos do novo tempo de expira��o
     * cache da sess�o. Se nenhum valor for passado � entao ser�
     * ajustado para seu valor padr�o que nesta classe.
     *
     * @param integer $minutes
     */
    public function setCacheExpire($minutes=0) {
        $this->timeout = ($minutes > 0) ? $minutes : $this->timeout;
        session_cache_expire($this->timeout);
    }
    /**
     * Retorna  o valor em minutos do tempo de expira��o
     * cache da sess�o.
     *
     * @return  integer
     */
    public function getCacheExpire() {
        return session_cache_expire();
    }

    /**
     * Se o $level for especificado,
     * o nome do limitador do cache atual � mudado para o novo valor.
     * Este valor poder� ser um integer na faixa de 0-3 ou uma string
     * com um dos valores:nocache,public,private,private_no_expire
     *
     *@param mixed $level
     */
    public function setCacheLimiter($level=0) {
        /*O limitador do cache controla HTTP headers enviados para o
         * cliente. Estes headers determinam pelas quais o
         * conte�do da p�gina pode ser guardado no cache.
         * Definindo o limitador do cache para nocache, por exemplo,
         * rejeitaria qualquer armazenamento no cache do cliente.
         *  Um valor como public, entretanto, permitiria o
         * armazenamento no cache. Ele tamb�m poderia ser definido
         * como private, que � um pouco mais restritivo do que public.
         * No modo private , Header expirado enviado para o cliente,
         * pode provocar confus�o para alguns para alguns navegadores
         * incluindo o Mozilla. Voc� pode evitar este problema com o modo
         *  private_no_expire. Header expirado nunca � enviado para o
         * cliente nesse modo.
         */
    //isto causa flexibilidade, reutiliza��o
    //maior capacidade de automa��o e pregui�a cerebral
        $cPriority=array("nocache","public","private","private_no_expire");
        if(is_int($level)) {
            $level = $cPriority[$level];
        }
        //agora � hora de finalmente configurar
        if(is_string($level)) {
            session_cache_limiter($level);
        }else {
            throw new Exception("Erro na passagem de par�metro de setCacheLImiter() em Session.");
        }

    }
    /**
     * Retorna o nome do atual limitador do cache.
     *
     * @return string
     */
    public function getCacheLimiter() {
        return session_cache_limiter();
    }


    /**
     * Executa o mesmo papel que writeClose(), isto � salva
     * a sess�o e grava, os dados em sua maior parte
     * acaba por ser meio desnecessario, j� que PHP
     * chama este tipo de metodo, ao final de cada script
     * em que ele n�o foi chamado.
     */
    public function save() {
        $_SESSION = self::$singleStruct;
        session_commit();
    }

    /**
     *
     *
     * @return boolean
     */
    public function encode() {
        $this->encode = session_encode();
    }

    /**
     * FIXME
     */
    public function decode() {
        return session_decode($this->encode);
    }

    /**
     * TODO: Documentar este metodo
     * @return void
     */
    public function setCookieParams($ltime,$path,$domain,$secure) {
        session_set_cookie_params($ltime,$path,$domain,$secure);
        $this->cookiesParam = session_get_cookie_params();
    }
    /**
     * TODO: Documentar este metodo
     * @return string
     */
    public function getCookieParams() {
        $this->cookiesParam = session_get_cookie_params();
        return $this->cookiesParam;
    }
    /**
     * TODO: Documentar este metodo
     * @return void
     */
    public function setCookieLifetime($ltime) {
        session_set_cookie_params($ltime,$this->path,$this->domain,$this->secure);
        $this->ltime = $ltime;
    }
    /**
     * TODO: Documentar este metodo
     * @return void
     */
    public function setCookiePath($path) {
        session_set_cookie_params($this->ltime,$path,$this->domain,$this->secure);
        $this->path = $path;
    }
    /**
     * TODO: Documentar este metodo
     * @return void
     */
    public function setCookieDomain($domain) {
        session_set_cookie_params($this->ltime,$this->path,$domain,$this->secure);
        $this->domain = $domain;
    }
    /**
     * TODO: Documentar este metodo
     * @return void
     */
    public function setCookieSecure($secure) {
        session_set_cookie_params($this->ltime,$this->path,$this->domain,$secure);
        $this->secure = $secure;
    }
    /**
     * TODO: Documentar este metodo
     * @return string
     */
    public function getCookieLifetime() {
        return $this->ltime;
    }
    /**
     * TODO: Documentar este metodo
     * @return string
     */
    public function getCookiePath() {
        $this->path = $path;
    }
    /**
     * TODO: Documentar este metodo
     * @return string
     */
    public function getCookieDomain() {
        return $this->domain ;
    }
    /**
     * TODO: Documentar este metodo
     * @return string
     */
    public function getCookieSecure() {
        return $this->secure ;
    }
    /**
     * Verifica se a sess�o � v�lida, e se n�o for lan�a um excess�o.
     * @return boolean
     * @throws Exception;
     */

    public function isValid () {
        if(isset(self::$singleStruct) && count(self::$singleStruct) > 0) {
            return true;
        }
        return false;
    //  throw new Exception("Esta sess�o n�o � v�lida.");
    }
    public function moduleName() {

    } //Obt�m e/ou define o m�dulo da sess�o atual
    /**
     * @FIXME
     */
    public function regenerateId() {
        session_regenerate_id();
    } //Atualiza o id da sess�o atual com um novo gerado

    /**
     * Registrar uma ou mais vari�veis globais na sess�o atual
     *
     *         OBSOLETO
     */
    //public function register(){
    //session_register();
    //}

    public function savePath() {

    } //Obt�m e/ou define o save path da sess�o atual

    public function setSaveHandler() {

    }
    /**
     * Cria uma sess�o (ou resume a sess�o atual baseada numa id
     * de sess�o sendo passada via uma vari�vel GET ou um cookie.
     *
     *
     */
    public function start() {
        if(!isset($_SESSION)) {
            return session_start();
        }

    } //Inicia dados de sess�o

    public function sessionUnset () {

    } //Libera todas as vari�veis de sess�o
    /**
     * Executa o mesmo papel que save(), isto � salva
     * a sess�o e grava, os dados em sua maior parte
     * acaba por ser meio desnecessario, j� que PHP
     * chama este tipo de metodo, ao final de cada script
     * em que ele n�o foi chamado.
     */
    public function writeClose() {

}//Escreve dados de sess�o e termina a sess�o




}
?>
