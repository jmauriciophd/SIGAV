<?php
class Server {
    private $server;
    private $size;

    public function Server() {
        $this->size  = 0;
        $this->server=null;
        //metodo quase primata de encapsular o $_SERVER,
        //mas foi a forma que conhe�o, como o server � global
        //um forma externa poderia ser tentada para modificar os
        //valores dos elementos de server e para evitar isto esta classe
        //so ter� metodos publicantes, nunca escritores
        if (isset($_SERVER) && is_array($_SERVER)) {
            $this->server = $_SERVER;
            $this->size = count($_SERVER);
        }
        //Destroi a super global $_SERVER
       // $_SERVER = null;
    }

    /**
     * O conte�do do header User-Agent: da requisi��o atual, se houver.
     * É uma string denotando o agente de usuario pelo qual a pagina é acessada.
     * Um exemplo t�pico �: Mozilla/4.5 [en] (X11; U; Linux 2.2.9 i586).
     * Alem de outras coisas, voc� pode utilizar este valor com get_browser()
     * para personalizar a gera��o de suas p�ginas para as capacidades do
     * agente do usu�rio.
     *
     * @return string
     */
    public function getBrowser() {
        return  $this->execute("HTTP_USER_AGENT");
    }

    /**
     *  O conte�do do header Accept-Charset:
     * da requisi��o atual, se houver.
     * Exemplo: 'iso-8859-1,*,utf-8'.
     *
     * @return string
     */
    public function getHTTPCharset() {
        return  $this->execute("HTTP_ACCEPT_CHARSET");
    }
    /**
     * O conte�do do header Accept-Encoding:
     * da requisi��o atual, se houver.
     * Exemplo: 'gzip'.
     *
     * @return string
     */
    public function getHTTPEncoding() {
        return  $this->execute("HTTP_ACCEPT_ENCODING");
    }

    /**
     *  O conte�do do header Accept-Language:
     *  da requisi��o atual, se houver.
     *  Exemplo 'en'.
     *
     * @return string
     */
    public function getHTTPLanguage() {
        return  $this->execute("HTTP_ACCEPT_LANGUAGE");
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public function getContentLength() {
        return  $this->execute("REQUEST_LENGTH");
    }
    /**
     *  O conte�do do header Host: da requisi��o atual, se houver.
     *
     * @return string
     */

    public function getDNSlookup() {
        return  $this->execute("HTTP_HOST");
    }

    /**
     *  O diret�rio raiz sob onde o script atual � executado,
     * como definido no arquivos de configura��o do servidor.
     *
     * @return string
     */
    public function getDocumentRoot() {
        return  $this->execute("DOCUMENT_ROOT");
    }

    /**
     * Embora n�o n�o encapsule o vetor ser
     *
     * @return unknown
     */
    public function getEnvironments() {
        if(is_array($this->server)){
            return $this->server;
        }
        return null;
    }
    /**
     * O caminho absoluto o script atualmente em execu��o.
     *Nota: Se o script for executado pela CLI com um caminho relativo,
     *como file.php ou ../file.php, $_SERVER['SCRIPT_FILENAME'] ir� conter
     * o caminho relativo especificado pelo usu�rio.
     * @return string
     */
    public function getAbsolutePath() {
        return  $this->execute("SCRIPT_FILENAME");
    }
    
    /**
     *O n�mero de revis�o da especifica��o CGI que o servidor est� utilizando
     *
     * @return string
     */
    public function getGWInterface() {
        return  $this->execute("GATEWAY_INTERFACE");
    }
    /**
     *  O conte�do do header Accept: da requisi��o atual, se houver.
     *
     * @return string
     */
    public function getHTTPAcceptType() {
        return  $this->execute("HTTP_ACCEPT");
    }
    /**
     * O conte�do do header Connection:
     * da requisi��o atual, se houver.
     * Exemplo: 'Keep-Alive'.
     *
     * @return string
     */
    public function getHTTPConnection() {
        return  $this->execute("SERVER_CONNECTION");
    }

    /**
     * Enter description here...
     *
     * @return integer
     */
    public function getMaxLifetime() {
        return  $this->execute("HTTP_KEEP_ALIVE");
    }
    /**
     * Retorna o nome do arquivo que est� sendo chamado. Isto � o script em execu��o.
     *
     * @return string
     */
    public function getOwnName() {
        return  $this->execute("PHP_SELF");
    }
    /**
     * Retorna o valor da vari�vel de ambiente PATH
     *
     * @return string
     */
    public function getPathEnvironment() {
        return  $this->execute("PATH");
    }
    /**
     *  A query string (string de solicita��o),
     *  se houver, pela qual a p�gina foi acessada.
     *
     * @return string
     */

    public function getQueryString() {
        return  $this->execute("QUERY_STRING");
    }
    /**
     *  O endere�o da p�gina (se houver) atrav�s da qual o agente do usu�rio
     * acessou a p�gina atual.
     * Essa diretiva � informada pelo agente do usu�rio.
     * Nem todos os browsers geram esse header, e alguns ainda possuem a
     * habilidade de modificar o conte�do do HTTP_REFERER como recurso.
     * Em poucas palavras, n�o � confi�vel.
     *
     * @return string
     */
    public function getReferer() {
        if ($this->hasReferer()) {
            return  $this->execute("HTTP_REFERER");
        }
        return null;

    }
    /**
     * O nome do host que o usu�rio utilizou para chamar a p�gina atual.
     * O DNS reverso (lookup) do REMOTE_ADDR do usu�rio.
     * Nota:  Seu servidor web precisa estar configurado para criar essa vari�vel.
     * Por exemplo, no Apache voc� precisa colocar um HostnameLookups On
     * dentro do httpd.conf
     * @return string
     */
    public function getRemoteHostname() {
        return  $this->execute("REMOTE_HOST");
    }
    /**
     *  O endere�o IP de onde o usu�rio est� visualizando a p�gina atual.
     *
     * @return string
     */
    public function getRemoteIPAddress() {
        return  $this->execute("SERVER_ADDR");
    }
    /**
     *  A porta TCP na m�quina do usu�rio utilizada para comunica��o com o servidor web.
     *
     * @return string
     */
    public function getRemotePort() {
        return  $this->execute("REMOTE_PORT");
    }
    /**
     * Cont�m o m�todo de request utilizando para
     * acessar a p�gina. Geralmente 'GET', 'HEAD', 'POST' ou 'PUT'.
     *
     * @return string
     */

    public function getRequestMethod() {
        return  $this->execute("REQUEST_METHOD");
    }

    /**
     * O timestamp do in�cio da requisi��o. Disponivel desde vers�o PHP 5.1.0.
     *
     * @return long
     */

    public function getRequestTime() {
        return  $this->execute("REQUEST_TIME");
    }

    /**
     * Cont�m o m�todo de request utilizando para
     * acessar a p�gina. Geralmente 'GET', 'HEAD', 'POST' ou 'PUT'.
     *
     * @return string
     */
    public function getRequestType() {
        return  $this->execute("REQUEST_METHOD");
    }
    /**
     *  O valor fornecido pela diretiva SERVER_ADMIN (do Apache) no arquivo de
     * configura��o do servidor. Se o script est� sendo executado em um host
     * virtual, este ser� os valores definidos para aquele host virtual.
     *
     * @return string
     */
    public function getServerAdmin() {
        return  $this->execute("SERVER_ADMIN");
    }
    /**
     * O URI fornecido para acessar a p�gina atual, por exemplo, '/index.html'.
     *
     * @return string
     */
    public function getUri() {
        return  $this->execute("REQUEST_URI");
    }
    /**
     *  Cont�m o caminho completo do script atual. �til para p�ginas
     * que precisam apontar para elas mesmas (dinamicamente).
     * A constante __FILE__  cont�m o caminho completo e nome do arquivo (mesmo inclu�do) atual.
     *
     * @return string
     */
    public function getUrl() {
        return  $this->execute("SCRIPT_NAME");
    }
    /**
     *Define para um valor n�o vazio se o script foi requisitado
     * atrav�s do protocolo HTTPS.   Note que quando usando ISAPI com IIS,
     * o valor ser� off se a requisi��o n�o for feita por protocolo HTTPS.
     *TODO: testar em um servidor com https
     * @return string
     */
    public function hasHttps() {
        return  $this->execute("HTTPS");
    }

    /**
     * Retorna o metodo de solicita��o realizada pelo cliente
     *
     * @return string
     */

    public function getServerId() {
        return  $this->execute("UNIQUE_ID");
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public function getServerIPAddress() {
        return  $this->execute("SERVER_ADDR");
    }


    /**
     *  O nome host do servidor onde o script atual � executado.
     *  Se o script est� rodando em um host virtual, este ser� o
     *  valor definido para aquele host virtual.
     *
     * @return string
     */
    public function getServerName() {
        return  $this->execute("SERVER_NAME");
    }
    /**
     * A porta na m�quina servidora utilizada pelo servidor web para comunica��o.
     * Como default, este valor � '80'.
     * Utilizando SSL, entretanto, mudar� esse valor para a porta
     * de comunica��o segura HTTP.
     *
     * @return string
     */
    public function getServerPort() {
        return  $this->execute("SERVER_PORT");
    }
    /**
     * Nome e n�mero de revis�o do protocolo de informa��o pelo qual a
     * p�gina foi requerida, por exemplo 'HTTP/1.1';
     *
     * @return string
     */
    public function getServerProtocol() {
        return  $this->execute("SERVER_PROTOCOL");
    }
    /**
     *  String contendo a vers�o do servidor e nome do host virtual
     * que � adicionado �s p�ginas geradas no servidor, se ativo.
     *
     * @return string
     */
    public function getServerSignature() {
        return  $this->execute("SERVER_SIGNATURE");
    }

    /**
     *  A string de identifica��o do servidor,
     *  fornecida nos headers quando respondendo a requests.
     *
     * @return string
     */
    public function getServerSoftware() {
        return  $this->execute("SERVER_SOFTWARE");
    }
    /**
     * Retorna o tamanho do interno de Server()
     *
     * @return integer
     */
    public function getSize() {
        return $this->size;
    }
    /**
     * Enter description here...
     *
     * @return boolean
     */
    public function hasReferer() {
        $referer = array_key_exists("HTTP_REFERER",$this->server);
        if ($referer) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *Verifica internamente a exist�ncia de um indice
     *e no caso dele n�o existir lan�a uma exce��o
     *
     * @param string $value
     * @return string
     * @throws Exception
     */

    private  function execute($value){
        //debugar
       // echo("<pre>");
       // print_r ($this->server);
       // echo("</pre>");
         
        if(is_array($this->server) && array_key_exists($value,$this->server)){
            return $this->server[$value];
        }else{
            throw new Exception("indice ['{$value}'] nao foi localizado para este metodo.");
        }
    }

    /**
     *  Quando executando no Apache como m�dulo fazendo autentica��o HTTP
     * esta vari�vel � definida para o cabe�alho 'Authorization'
     * enviado pelo cliente (que voc� pode ent�o usar para fazer apropriada valida��o).
     *
     * @return string
     */
    public function getAuthDigest() {
        return  $this->execute("PHP_AUTH_DIGEST");
    }

    /**
     *  A string de identifica��o do servidor,
     *  fornecida nos headers quando respondendo a requests.
     *
     * @return string
     */
    public function getAuthenticationType() {
        return  $this->execute("AUTH_TYPE");
    }

    /**
     * Quando executando sob o Apache ou IIS (ISAPI no PHP 5)
     * como m�dulo e fazendo autentica��o HTTP, esta vari�vel
     * estar� definida com o username fornecido pelo usu�rio.
     *
     * @return string
     */
    public function getAuthUsername() {
        return  $this->execute("PHP_AUTH_USER");
    }

    /**
     * Quando executando sob o Apache ou IIS (ISAPI no PHP 5) como m�dulo e
     * fazendo autentica��o HTTP, esta vari�vel estar� definida
     * com a senha fornecida pelo usu�rio
     *
     * @return string
     */
    public function getAuthPassword() {
        return  $this->execute("PHP_AUTH_PW");
    }
    /**
     *  O caminho real do script relativo ao sistema de arquivos
     * (nao o document root), depois realizou todos os
     * mapeamentos de caminhos (virtual-to-real).
     *
     * @return string
     */
    public function getPathTranslated() {
        return  $this->execute("PATH_TRANSLATED");
    }
     


}
?>