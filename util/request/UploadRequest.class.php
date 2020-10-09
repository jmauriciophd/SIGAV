<?php
/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - Pode ser distribuída livremente
 *
 * @note:
 *
 * O objetivo principal desta classe e de suas composições é criar
 * a possibilidade de iterar polimorficamente atraves de mais de um
 * arquivo sendo realizado upload. O PHP inicialmente nos oferece
 * uma forma bastante performática, porém inadequada para iterar ou
 * substituir ou recuperar um arquivo facilmente sem a necessiadade
 * sequer de conhecer o nome do elemento existe em formulário de um
 * cliente cada.
 *
 * @como funciona:
 *
 * Ao receber uma requisição com o envio de um ou mais arquivos simultaneos
 * o PHP armazena na variável global $_FILES os dados referentes aos arquivos
 * enviados. Dai cada arquivo e encapsulado em um UploadFile atraves de UploadRequest
 * Para recuperar as informacoes dos arquivos faz-se atraves da interface de
 * UploadRequest que fornece UploadFile, agora finalmente podemos usar adequadamente
 * e devidamente encapsulada os atributos de cada arquivo individualmente, abstraindo-se
 * valores como o nome do elemento file que compoe o formulario.
 * Com essa abstracao esta classe esta' pronta para ser usada em webservices.
 *
 * @participantes
 *
 * Desta abastracao participam de forma a causar um dependencia rigorosa as seguintes:
 *
 * classe UploadFile
 * classe ArrayObject
 * classe ArrayIterator
 * Cada uma destas classe vive independentemente, porem UploadRequest e' uma classe
 * cliente e nao pode ser usada sem elas.
 *
 * @deficiencia :
 * por esta classe ser uma extensao de Request nao deveria ter tanta dependencia,
 * mas como PHP nao da' suporte a classe internas foi a maneira que pode ser usada
 * no momento para a tecnologia corrente. Talvez no futuro esse padrao seja resolvido
 * com uma melhoria no PHP.
 */

class  UploadRequest {
	private static $fileUpload = null;
	private $iterator     = null;
	private $arrayObject  = null;
	private $request      = null;
	private $size         = 0 ;
	private $reqSize      = 0 ;

	/**
	 * Inicializa um vetor com objetos UploadFile, cada um elemento
	 * representando arquivo enviado pelo cliente. Em seguida inicializa
	 * um ArrayObject a fim de iterar polimorficamente atraves de
	 * todos os arquivos.
	 * @param array $allowedType
	 */
	public function UploadRequest(Request $request, array $allowedType=null){
		$this->request = $request;
		$this->size = 0;
		$this->reqSize= $request->getRequestSize();
		if(isset($_FILES) && count($_FILES) > 0){
			//tipa falsamente o vetor
			self::$fileUpload=(self::$fileUpload==null) ? array() : self::$fileUpload ;
			// Faz um copia local
			$LOCALFILES =$_FILES;
			// Encerra o processo de encapsulamento
			$_FILES = NULL;
			foreach ($LOCALFILES as $key => $fileProperties) {
				//armazena tantos objetos UploadFile quanto forem
				//enviados pelo cliente, cada elemento 'e referenciado
				//pelo nome do elemento que suporta o arquivo
				$uploadFile= new UploadFile($fileProperties,$allowedType);
				if(!$uploadFile->hasError() && $uploadFile->canDoUpload()){
					//armazena um objeto que tem cada caracteristica de
					//de um arquivo enviado
					self::$fileUpload[$key] = $uploadFile;
					$this->size++;
				}
			}
			//ArryObject é nativo do PHP 5+
			$this->arrayObject = new ArrayObject(self::$fileUpload);
			//recupera um iterador ArrayIterator a fim de percorrer
			//todos os objetos UploadFile
			$this->iterator    = $this->arrayObject->getIterator();
		}

	}
	  /**
     * Recupera a quantidade de campos recebidos
     * de um formulário HTML, somente os elementos File
     *
     * @return integer
     */
	public function getUploadSize(){
		return $this->size;
	}
	  /**
     * Recupera a quantidade de campos recebidos
     * de um formulário HTML, inclusive os elementos File
     *
     * @return integer
     */
	public function getRequestSize(){
		return ($this->size+$this->reqSize);
	}
	/**
	 * Cria um novo iterador a partir de uma instância de ArrayObject.
	 * Retorna o iterador do ArrayObject.
	 * @return ArrayIterator
	 */
	public  function getIterator(){
		return $this->iterator;
	}

	/**
	 * No caso de um UploadRequest retorna a primeira ocorrencia de $param
	 * @param string  $param
	 * @return string
	 */
	public function getParameter($param){
		if(self::$fileUpload != null ){
			if(array_key_exists($param,self::$fileUpload)){
				return self::$fileUpload[$param];
			}
		}
		//se as verificações acima falharem, faz uma busca na
		//classe ancestral
		return $this->request->getParameter($param);
	}

	/**
	 * Recupera a chave do objeto atual;
	 *@return mixed;
	 */
	public function getComponentName(){
		if($this->iterator!=null){
			return $this->iterator->key();
		}
		return null;
	}
	/**
	 * Retorna um UploadFile
	 * @return UploadFile
	 */
	public function getUploadFile(){
		if($this->iterator != null ){
			//recupera o valor atual
			$current = $this->iterator->current();
			//move o cursor um passo
			$this->iterator->next();
			//e retorna o valor atual
			return $current;
		}
	}
	/**
	 * Posiciona o ponteiro no primeiro elemento do iterador
	 *
	 */
	public function reset(){
		//verifica se iterador foi instanciado
		if($this->iterator!=null){
			// e move o cursor para o inicio do iterador
			return $this->iterator->rewind();
		}
	}
	/**
	 * Verifica a cada elemento da iteração se ainda é válido
	 *
	 * @return boolean
	 */
	public function hasUploadFile(){
		//verifica se o iterador foi instanciado, isto evita
		//uma mensagem de erro do PHP
		if($this->iterator!=null){
			//faz a analise se 'e valido e retorna seu resultado
			return $this->iterator->valid();
		}
	}
}

?>