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
    //preparação para criação de uma sessao ideal, com o menor
    //problema possivel. As funções do PHP e os nomes
    //nao costuma seguir uma padronização e esta classe tenta resolver isso
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
        //Garante a existência de apenas uma referência para dados de sessão
        //Através de um SingleTon
        if(is_null(self::$singleStruct)) {
            self::$singleStruct = array();
            self::$singleStruct = $_SESSION ;
            //emcapsula
            $_SESSION   ;
        }

    }
    /**
     * Configurar o id de sessão determinado pelo usuario
     * ao invés do padrao.
     *
     * @param string $id
     */
    public function setId($id=null) {
        if(is_string($id)) {
            $this->sessionId = md5($id);
            session_id($this->sessionId);
        }else {
            throw new Exception("Parâmetro inválido em setSessionId() de Session.");
        }
    }
    /**
     * Recupera o valor do id da sessão
     *
     * @return string
     */
    public function getId() {
    //Obtém e/ou define o id de sessão atual
        if(strlen($this->sessionId) > 0) {
            return $this->sessionId;
        }
        return null;
    }
    /**
     * Recupera o valor do nome dado a sessão.
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
     * Recupera valores de sessão e os armazena internamente, devendo ser
     * lido por métodos leitores.
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
     * Acrescenta um elemento a sessão corrente
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
            throw new Exception("Parâmetro inválido em addItem() de Session.");
        }
    }
    /**
     * Acrescenta um elemento a sessão corrente
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
           // throw new Exception("Índice inválido em getItem() de Session. Este índice não existe na Sessão.");
        //}
    }

    /**
     * Acrescenta um elemento a sessão corrente
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
     * A quntidade Elementos na sessão corrente
     *
     * @return integer
     */
    public function getSize() {
        return count(self::$singleStruct);
    }

    /**
     * Acrescenta um elemento a sessão corrente
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
     * Dá início a sessao e armazena os dados no array de sessão
     *@return void
     *
     */
    private function beginSession() {
        session_id($this->sessionId);
        session_name($this->sessionName);
    }

    /**
     * Destrói todos os dados associados com a sessão atual.
     * Não anula qualquer variável global que esteja associada com a
     * sessão, nem anula cookies de sessão.
     *
     *@return boolean
     */
    public function destroy() {
        return session_destroy();
    }
    /**
     * Configura o valor em minutos do novo tempo de expiração
     * cache da sessão. Se nenhum valor for passado é entao será
     * ajustado para seu valor padrão que nesta classe.
     *
     * @param integer $minutes
     */
    public function setCacheExpire($minutes=0) {
        $this->timeout = ($minutes > 0) ? $minutes : $this->timeout;
        session_cache_expire($this->timeout);
    }
    /**
     * Retorna  o valor em minutos do tempo de expiração
     * cache da sessão.
     *
     * @return  integer
     */
    public function getCacheExpire() {
        return session_cache_expire();
    }

    /**
     * Se o $level for especificado,
     * o nome do limitador do cache atual é mudado para o novo valor.
     * Este valor poderá ser um integer na faixa de 0-3 ou uma string
     * com um dos valores:nocache,public,private,private_no_expire
     *
     *@param mixed $level
     */
    public function setCacheLimiter($level=0) {
        /*O limitador do cache controla HTTP headers enviados para o
         * cliente. Estes headers determinam pelas quais o
         * conteúdo da página pode ser guardado no cache.
         * Definindo o limitador do cache para nocache, por exemplo,
         * rejeitaria qualquer armazenamento no cache do cliente.
         *  Um valor como public, entretanto, permitiria o
         * armazenamento no cache. Ele também poderia ser definido
         * como private, que é um pouco mais restritivo do que public.
         * No modo private , Header expirado enviado para o cliente,
         * pode provocar confusão para alguns para alguns navegadores
         * incluindo o Mozilla. Você pode evitar este problema com o modo
         *  private_no_expire. Header expirado nunca é enviado para o
         * cliente nesse modo.
         */
    //isto causa flexibilidade, reutilização
    //maior capacidade de automação e preguiça cerebral
        $cPriority=array("nocache","public","private","private_no_expire");
        if(is_int($level)) {
            $level = $cPriority[$level];
        }
        //agora é hora de finalmente configurar
        if(is_string($level)) {
            session_cache_limiter($level);
        }else {
            throw new Exception("Erro na passagem de parâmetro de setCacheLImiter() em Session.");
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
     * Executa o mesmo papel que writeClose(), isto é salva
     * a sessão e grava, os dados em sua maior parte
     * acaba por ser meio desnecessario, já que PHP
     * chama este tipo de metodo, ao final de cada script
     * em que ele não foi chamado.
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
     * Verifica se a sessão é válida, e se não for lança um excessão.
     * @return boolean
     * @throws Exception;
     */

    public function isValid () {
        if(isset(self::$singleStruct) && count(self::$singleStruct) > 0) {
            return true;
        }
        return false;
    //  throw new Exception("Esta sessão não é válida.");
    }
    public function moduleName() {

    } //Obtém e/ou define o módulo da sessão atual
    /**
     * @FIXME
     */
    public function regenerateId() {
        session_regenerate_id();
    } //Atualiza o id da sessão atual com um novo gerado

    /**
     * Registrar uma ou mais variáveis globais na sessão atual
     *
     *         OBSOLETO
     */
    //public function register(){
    //session_register();
    //}

    public function savePath() {

    } //Obtém e/ou define o save path da sessão atual

    public function setSaveHandler() {

    }
    /**
     * Cria uma sessão (ou resume a sessão atual baseada numa id
     * de sessão sendo passada via uma variável GET ou um cookie.
     *
     *
     */
    public function start() {
        if(!isset($_SESSION)) {
            return session_start();
        }

    } //Inicia dados de sessão

    public function sessionUnset () {

    } //Libera todas as variáveis de sessão
    /**
     * Executa o mesmo papel que save(), isto é salva
     * a sessão e grava, os dados em sua maior parte
     * acaba por ser meio desnecessario, já que PHP
     * chama este tipo de metodo, ao final de cada script
     * em que ele não foi chamado.
     */
    public function writeClose() {

}//Escreve dados de sessão e termina a sessão




}
?>
