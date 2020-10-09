<?php
require_once dirname(__FILE__) . "/../libloader.php";

/**
* Classe que controla acoes do Perfil.
* @author Rafael Dias
*/
class PerfilController extends AbstractController
{
	private $perfil = null;
	private $perfilDao = null;
	
	/** Construtor da classe */
	function __construct($operacao = "")
	{
		parent::AbstractController($operacao, "tb_perfil");
		$this->perfilDao = new PerfilDao();
		$this->preencheDadosPerfil();
	}
	
	private function preencheDadosPerfil()
	{
		//cria um novo objeto Perfil
		$this->perfil = new Perfil();
		$this->perfil->setId($this->getValueForm("id"));
		$this->perfil->setNome($this->getValueForm("perfil"));
		$this->perfil->setDescricao($this->getValueForm("descricao"));
	}
	
	/**
	* Retorna o valor da propriedade $perfil.
	* @access public
	* @return Perfil
	*/
	public function getPerfil()
	{
		return $this->perfil;
	}
	
	public function inserir()
	{
		if($this->nomePerfilJaExiste($this->perfil->getNome())){ 
			$msg = "O nome do perfil já existe.<br/>Por favor, informe outro nome para o perfil.";
       		$this->url = "../perfil/ManterPerfil.php?msgError=".$msg; 
	    } else { 
			$id = $this->perfilDao->inserir($this->perfil);
			if($id != 0 && $id != ""){
				$this->gravarLog($id);
				$this->url = "../perfil/ManterPerfil.php?sucess&editar&id=".$id;
			} else{
				$this->url = "../perfil/ManterPerfil.php?error";
			}
	    }
		
		echo $this->url;
	}
	
	public function atualizar()
	{
		if($this->perfilDao->alterar($this->perfil) == true){
			$this->gravarLog($this->perfil->getId());
			$this->url = $this->url."?sucessUpdate&editar&id=" . $this->perfil->getId();
		} else {
			$this->url = $this->url."?errorUpdate&editar&id=" . $this->perfil->getId();
		}
		
		echo $this->url;
	}
	
	public function excluir()
	{
		if($this->perfilDao->excluir($this->perfil->getId())){
			$this->gravarLog($this->perfil->getId());
			$url = "../perfil/ManterPerfil.php?sucessDelete";
		} else {
			$url = "../perfil/ManterPerfil.php?errorDelete";
		}
		
		echo $url;
	}
	
	public function nomePerfilJaExiste($nome){
        $perfil = $this->perfilDao->consultarPerfilPorNome($nome);
        if($perfil != null && $perfil->getNome() == $nome){
        	return true;
        } else {
        	return false;
        }
	}
	
	public function consultarTodosPerfis()
	{
		$listaPerfis = new ArrayList();
		$result = $this->perfilDao->consultarTodosPerfis();
		$tamanhoLista = 0;
		
		if($result != null || $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i = 0; $i < $tamanhoLista; $i++){
					  $dados = $result[$i]->getElements();
				 	  
					  $perfil = new Perfil();	
					  $perfil->setId($dados[0]);
					  $perfil->setNome($dados[1]);
					  $perfil->setDescricao($dados[2]);
				 	  
				 	  $listaPerfis->add($perfil, $i);
			}
		}
		
		return $listaPerfis;
	}	
	
	public function consultarPerfilPorId($id)
	{
		return $this->perfilDao->consultarPerfilPorId($id);
	}	
	
	public function carregarComboPerfil($valor = ""){
		$listaPerfil = $this->consultarTodosPerfis();
		$selectDinamico = "<option value='' selected='selected'>Selecione um Perfil</option>";
		
		if($listaPerfil == null || $listaPerfil->getSize() <= 0){
		    $selectDinamico .= "<option value=''>Nenhum Perfil cadastrado.</option>";
		} else {
			foreach ($listaPerfil->getElements() as $indice => $perfil){
			    $selectDinamico .= "<option value='" . $perfil->getId() . "' " . Util::selecionar($perfil->getId(), $valor) . " >" . $perfil->getNome() . "</option>";
			}
		}
		
		return $selectDinamico;
	}
	
}

    $request = new Request();
	$operacao = $request->getParameter("operacao");
	
	if($operacao != null || $operacao != ""){
		$perfilController  = new PerfilController();
		if($operacao == "cadastrar"){
			$perfilController->inserir();
		} elseif ($operacao == "atualizar"){
			$perfilController->atualizar();
		} elseif ($operacao == "excluir"){
			$perfilController->excluir();
		} elseif ($operacao == "pesquisar"){
			$perfilController->pesquisar();
		} elseif ($operacao == "carregarPerfilParaEdicao"){
			echo $perfilController->url."?editar&id=".$request->getParameter("idPerfilLinha");
		} else{
			$perfilController->redirecionaPagina("javascript:history.go(-1)");
		} 
	}
?>