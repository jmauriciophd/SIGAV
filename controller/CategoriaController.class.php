<?php
require_once dirname(__FILE__) . "/../libloader.php";

/**
* Classe que controla acoes do usuario.
* @author Rafael Dias
*/
class CategoriaController extends AbstractController
{
	private $categoria = null;
	private $categoriaDao = null;
	
	/** Construtor da classe */
	function __construct($operacao = "")
	{
		parent::AbstractController($operacao, "tb_categoria");
		$this->categoriaDao = new CategoriaDao();
		$this->preencheDadosCategoria();
	}
	
	private function preencheDadosCategoria()
	{
		//obtem os valores vindo do formulario via post ou get
		$codigo = $this->getValueForm("codigo");
		$descricao = $this->getValueForm("descricao");
		//retira aspas duplas e simples
		$codigo = preg_replace('/(\'|")/', '', $codigo);
		$descricao = preg_replace('/(\'|")/', '', $descricao);
		//cria um novo objeto Categoria
		$this->categoria = new Categoria();
		$this->categoria->setCodigo(trim($codigo));
		$this->categoria->setDescricao(trim($descricao));
	}
	
	/**
	* Retorna o valor da propriedade $Categoria.
	* @access public
	* @return Categoria
	*/
	public function getCategoria()
	{
		return $this->categoria;
	}
	
	public function inserir()
	{
		$codigo = trim($this->getValueForm("codigo"));
		$descricao = trim($this->getValueForm("descricao"));
		
		if($this->codigoCategoriaJaExiste($codigo) && $this->descricaoCategoriaJaExiste($descricao)){ 
       		 echo "O código ($codigo) e a descrição ($descricao) da categoria informada já existe."; 
	    } elseif($this->codigoCategoriaJaExiste($codigo)){ 
       		 echo "O código da categoria ($codigo) informada já existe."; 
	    } elseif($this->descricaoCategoriaJaExiste($descricao)){ 
       		 echo "A descrição da categoria ($descricao) informada já existe."; 
	    } elseif($this->categoriaDao->inserir($this->categoria) == true){
	    	$this->gravarLog($codigo);
			echo "Categoria cadastrada com sucesso.";
	    } else {
	    	echo "ERRO: Não foi possivel cadastrar a categoria.";
	    }
	}
	
	public function codigoCategoriaJaExiste($codigo){
        $categoria = $this->categoriaDao->consultarCategoriaPorCodigo($codigo);
        if($categoria != null && $categoria->getCodigo() == $codigo){
        	return true;
        } else {
        	return false;
        }
	}
	
	public function descricaoCategoriaJaExiste($descricao){
        $categoria = $this->categoriaDao->consultarCategoriaPorDescricao($descricao);
        if($categoria != null && $categoria->getDescricao() == $descricao){
        	return true;
        } else {
        	return false;
        }
	}
	
	public function consultarTodasCategorias()
	{
		$listaCategoria = new ArrayList();
		$result = $this->categoriaDao->consultarTodasCategorias();
		$tamanhoLista = 0;
		
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i = 0; $i < $tamanhoLista; $i++){
					$dados = $result[$i]->getElements();

					$categoria = new Categoria();
					$categoria->setCodigo($dados[0]);
					$categoria->setDescricao($dados[1]);

					$listaCategoria->add($categoria, $i);
			}
		}
		
		return $listaCategoria;
	}	
	
	public function alterar()
	{
		if($this->descricaoCategoriaJaExiste($this->categoria->getDescricao())){ 
       		 echo "A descrição da categoria (".$this->categoria->getDescricao().") informada já existe."; 
	    } else if($this->categoriaDao->alterar($this->categoria) == true){
			$this->gravarLog($this->categoria->getCodigo());
			echo 'Categoria atualizada com sucesso.';
		}
	}
	
	public function excluir()
	{
		if($this->categoriaDao->excluir($this->categoria->getCodigo())){
			$this->gravarLog($this->categoria->getCodigo());
			echo 'Categoria excluida com sucesso.';
		}
	}
	
	public function carregarComboCategoria($valor = ""){
		$listaCategoria = $this->consultarTodasCategorias();
		$selectDinamico = "<option value='' selected='selected'>Selecione uma Categoria</option>";
		
		if($listaCategoria == null || $listaCategoria->getSize() <= 0){
		    $selectDinamico .= "<option value=''>Nenhuma categoria cadastrada.</option>";
		} else {
			foreach ($listaCategoria->getElements() as $indice => $categoria){
			    $selectDinamico .= "<option value='" . $categoria->getCodigo() . "' " . Util::selecionar($categoria->getCodigo(), $valor) . " >" . $categoria->getDescricao() . "</option>";
			}
		}
		
		return $selectDinamico;
	}
	
}
   
    $request = new Request();
	$operacao = $request->getParameter("operacao");
	
	if($operacao != null || $operacao != ""){
		$categoriaController  = new CategoriaController();
		if($operacao == "cadastrar"){
			$categoriaController->inserir();
		} elseif ($operacao == "alterar"){
			$categoriaController->alterar();
		} elseif ($operacao == "excluir"){
			$categoriaController->excluir();
		} else{
			$categoriaController->redirecionaPagina("javascript:history.go(-1)");
		}
	}
?>