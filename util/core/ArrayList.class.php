<?php

class ArrayList extends Object implements Listable {
    private $hasNext=-1;
    private $assocArray = null;
    private $localIndexer=-1;
    /**
     * Serve para armazenar o objetos que ser�o adicionados
     * @access private
     *
     */
    private $collection;
    private $size;
    /**
     *@category Construtor
     *Inicializa a collection com um vetor vazio;
     */
    public function __construct() {
        $this->collection = array();
        $this->assocArray = array();
        $this->size = 0;
    }
    /**
     * Desloca o ponteiro para o inicio da lista
     *@return void
     */
    public function reset() {
        $this->hasNext=-1;
    }
    /**
     * Adiciona um valor ao elemento da sequencia de vetorial
     * do objeto ArrayList
     *@param mixed $value
     *@param string $assoc
     *
     */
    public function add($value=null, $assoc=null) {
    //a fim de evitar a sobrecarga no sistema este
    //metodo so permitir� usar indices associativos
    //ou numericos por vez, a ordem dessas condicionais deve
    //ser considerada. DO NOT TOUCH!
        if(!is_null($assoc) && is_string($assoc)) {
            $this->assocArray["$assoc"]= $this->size;
        }
        if(!is_null($value)) {
            $this->collection[$this->size] = $value;
            $this->size++;
        }

    }
    /**
     *
     *Descricao
     * Este metodo deve receber  um integer ou
     *uma string de busca a fim de remover o item selecionado
     *se mais de uma combina��o for encontrada, todas ser�o
     *removidas
     * FIXME
     * @param mixed $whatToRemove
     *
     */
    public function remove($whatToRemove=null) {
        $reposit = array ();
        $currentSize=0;
        //busca pelo primeiro indice e remove
        if (is_int($whatToRemove) && $whatToRemove< $this->size) {
            for($index=0; $index< $this->size;$index++) {
                if ($whatToRemove!= $index) {
                    $reposit[] =  $this->collection[$index];
                }
            }
            $this->collection = $reposit;
            $this->size--;
            return true;
        }
        //busca por todas as coincidencias e as remove da lista
        if (is_string($whatToRemove)) {
            $removeable = $whatToRemove ;
            for($index=0; $index < $size ;$index++) {
                $content = $this->collection[$index];
                $position = strpos($content,$removeable);
                if ($position === false) {
                    $reposit[] =  $this->collection[$index];
                    $currentSize++;
                }
            }
            $this->collection = $reposit;
            $this->size =   $currentSize;
            return true;
        }
        return false;
    }
    /**
     * @return mixed
     * restaura o valor da elemento na posicao dada
     * @param mixed $whereIs
     */
    public function contentAt($whereIs=null) {
        if (is_int($whereIs) || is_string($whereIs)) {
            $index =(is_int($whereIs)) ? $whereIs : $this->assocArray[$whereIs];
            return $this->collection[$index];
        } else {
            throw new Exception("Par�metro do tipo inv�lido em contentAt(); ");
        }
    }
	/* @return  mixed
	 * retorna a primeira ocorrencia do conteudo passado como par�metro de busca
	 */
    public function search($findvalue, $casesensitive=true) {
        $i=0;
        if (is_string($findvalue)) {
            reset($this->collection);
            do {
                $content = current($this->collection);
                if($casesensitive==false ) {
                    $content  = strtolower($content);
                    $findvalue= strtolower($findvalue);
                }
                $position = strpos($content,$findvalue);
                if($position!==false) {
                    return $i;
                }
                $i++;
            }while(next($this->collection));
        }else {
            throw new Exception("Passagem de par�metro inv�lido em search();");
        }
        return -1;
    }
    /**
     * @return boolean
     * Esvazia o array.
     */
    public function cleanArray() {
        $this->collection = array();
        $this->size=0;
        return true;
    }
    /**
     * Um inteiro informando o tamanho do ArrayList
     *@return int
     */
    public function getSize() {
        return  $this->size;
    }
    /**
     * @return array
     */
    public function getElements() {
        return $this->collection;
    }
    /**
     * Verifica a exist�ncia de itens na lista.
     *
     * @return boolean
     */
    public function hasNext() {
        if($this->hasNext < ($this->size-1) && $this->size > 0 ) {
            $this->hasNext++;
            return true	;
        }
        return false;
    }
    /**
     * Recupera o valor do elemento na posi��o fuutra
     * @return ArrayList
     *
     */
    public function getNext() {
        if($this->size > 0 ) {
            return $this->contentAt($this->hasNext);
        }
        return null;
    }
    /**
     * Retorna o ultimo elemento contido
     * no ArrayList
     *
     * @return ArrayList
     */
    public function getFirst() {
        if($this->size > 0 ) {
            $this->hasNext=0;
            return $this->contentAt(0);
        }
        return false;
    }
    /**
     * Retorna o ultimo elemento contido
     * no ArrayList
     *
     * @return Object
     */
    public function getLast() {
        if($this->size > 0 ) {
            return $this->contentAt($this->size-1);
        }
        return false;
    }
    /**
     * Informa a posicao do cursor interno
     *
     *@return integer
     */
    public function getIndex() {
        return $this->hasNext;
    }
    /**
     * Retorna a posicao em atual do do elemto iterado.
     * Ao final o calor ser� igual ao tamanho total de
     * posic�es do ArrayList
     * Isto difere de getIndex que ao final retorna o tamanho do
     * ArrayList -1;
     *
     * @return integer
     */
    public function getPosition() {
        return ($this->hasNext+1);
    }

    public function __destruct() {
    // echo "estou sendo destruido<br>";
    }
}
?>