<?php
require_once dirname(__FILE__) . "/../libloader.php";

/**
* Classe que controla acoes do usuario.
* @author Jose Mauricio
*/
class PermissaoController extends AbstractController
{
	private $listaPermissoes;
	private $permissaoDao;
	
	/** Construtor da classe */
	function __construct($operacao = "")
	{
		parent::AbstractController($operacao, "tb_permissao_acesso");
		$this->permissaoDao = new PermissaoDao();
		if($operacao == "cadastrar")
			$this->preencheDadosPermissao();
	}
	
	private function preencheDadosPermissao()
	{   
		//obtem os valores vindo do formulario via post ou get
		$idPermissao = $this->getValueForm("id_permissao");
        $qtdeAplicacoes = $this->getValueForm("qtdeAplicacoes");
        $idAplicacao = $_POST["aplicacao"];
        
        $acesso   = $_POST["acesso"];
		$consulta = $_POST["consulta"];
		$cadastra = $_POST["cadastra"];
		$atualiza = $_POST["altera"];
		$exclui   = $_POST["exclui"];
        $imprimi  = $_POST["imprimi"];
        
        $perfil = new Perfil();
        $perfil->setId($this->getValueForm("perfil"));
        

        $this->listaPermissoes = new ArrayList();
        
        for($i = 0; $i < $qtdeAplicacoes; $i++){
        	$aplicacao = new Aplicacao();
      		$aplicacao->setId($idAplicacao[$i]);
      		
			$permissao = new Permissao();
			$permissao->setId($idPermissao);
			$permissao->setPerfil($perfil);
			$permissao->setAplicacao($aplicacao);
			
			if($this->checkboxSelecionado($acesso, $aplicacao->getId()))
				$permissao->setAcessa('S');
			
	    	if($this->checkboxSelecionado($cadastra, $aplicacao->getId()))
		    	$permissao->setCadastra('S');
		    
		    if($this->checkboxSelecionado($atualiza, $aplicacao->getId()))
		    	$permissao->setAtualiza('S');
		   
	    	if($this->checkboxSelecionado($exclui, $aplicacao->getId()))
		    	$permissao->setExclui('S');
		    
		    if($this->checkboxSelecionado($consulta, $aplicacao->getId()))
		    	$permissao->setConsulta('S');
		    
		    if($this->checkboxSelecionado($imprimi, $aplicacao->getId()))
		    	$permissao->setImprimi('S');
	    	
	    	//echo "<br/>".$permissao->toString();
	    	$this->listaPermissoes->add($permissao, $i);
	    }
	    
     }
	
     public function checkboxSelecionado($array, $id_aplicacao){
     		foreach($array as $key => $value) {
	            if($value == $id_aplicacao){
		    		return true;
	            }
        	}
        	return false;
     }
       
	/**
	* Retorna o valor da propriedade $listaPermissoes
	* @access public
	* @return Usuario
	*/
	public function getListaPermissoes()
	{
		return $this->listaPermissoes;
	}
	
	public function inserir()
	{
		$erro = false;
		foreach ($this->listaPermissoes->getElements() as $indice => $permissao) {
			if($this->permissaoDao->consultarPermissaoPorId($permissao->getPerfil()->getId(), $permissao->getAplicacao()->getId()) == null){
				$result = $this->permissaoDao->inserir($permissao);
				$idPermissao = $result;
			} else {
				$result = $this->permissaoDao->alterar($permissao);
				$idPermissao = $permissao->getId();
			}
			if($result == 0 || $result == false){
			    $erro = true;
			    $msg = "<div id='msgError'><img src='../../img/icons/button_no.png' width='17px' height='17px' alt='Erro'>";
				$msg = "N&atilde;o foi possivel dar permiss&atilde;o de acesso para a aplica&ccedil;&atilde;o " . 
						$permissao->getAplicacao()->getNomeAplicacao() . "</div>";
			} else {
				$this->gravarLog($idPermissao);
			}
		}
		
		if(!$erro){
			$msg = "<div id='msgSucess'><img src='../../img/icons/button_yes.png' width='17px' height='17px' alt='Sucesso'>";
			$msg .= "As permiss&otilde;es de acesso selecionadas foram concedidas com sucesso. </div>";
		}
		
		echo $msg;
	}
	
    public function consultarPermissaoPorPerfil($id)
	{
		$listaPermissao = new ArrayList();
		$result = $this->permissaoDao->consultarPermissaoPorPerfil($id);
		$tamanhoLista = 0;
		
		if($result != null && $result->getSize() > 0){
			$tamanhoLista = $result->getSize();
			$result = $result->getElements();
			
			for ($i=0; $i < $tamanhoLista; $i++){
				$dados = $result[$i]->getElements();
				
				$perfil = new Perfil();
				$perfil->setId($dados[7]);
				$perfil->setNome($dados[8]);
				$perfil->setDescricao($dados[9]);
				
				$aplicacao = new Aplicacao();
				$aplicacao->setId($dados[10]);
				$aplicacao->setNomeArquivo($dados[11]);
				$aplicacao->setNomeAplicacao($dados[12]);
				$aplicacao->setModulo($dados[13]);
				$aplicacao->setDescricao($dados[14]);
				
				$permissao = new Permissao();	
				$permissao->setId($dados[0]);
				$permissao->setAcessa($dados[1]);
				$permissao->setConsulta($dados[2]);
				$permissao->setCadastra($dados[3]);
				$permissao->setAtualiza($dados[4]);
				$permissao->setExclui($dados[5]);
	            $permissao->setImprimi($dados[6]);
	            $permissao->setPerfil($perfil);
		    	$permissao->setAplicacao($aplicacao);
		    	
		    	$listaPermissao->add($permissao,$i);
			}
	   }
		
	   return $listaPermissao;
	}
	
	public static function desabilitarBotao($aplicacao, $operacao){
    	$permissaoController = $permissaoController = new PermissaoController();
		$permissoes = $permissaoController->consultarPermissaoPorPerfil($_SESSION['ID_PERFIL_USUARIO']);
		
		foreach ($permissoes->getElements() as $indice => $permissao){
			if($aplicacao == $permissao->getAplicacao()->getNomeAplicacao()) {
				if(($operacao == "cadastrar" && $permissao->getCadastra() == 'S') ||
					($operacao == "atualizar" && $permissao->getAtualiza() == 'S') ||
				     ($operacao == "excluir" && $permissao->getExclui() == 'S') ||
				      ($operacao == "imprimir" && $permissao->getImprimi() == 'S')) {
						echo "class='botao'";
				} else {
					echo "class='botaoDesabilitado' disabled='disabled'";
				}
					
				break;
			}
		}
    }
    
}
    $request = new Request();
	$operacao = $request->getParameter("operacao");
	
	if($operacao != null || $operacao != ""){
		$permissaoController  = new PermissaoController($operacao);
		if($operacao == "cadastrar"){
			$permissaoController->inserir();
		} elseif ($operacao == "exibirDadosPermissao"){
			$listaPermissao = $permissaoController->consultarPermissaoPorPerfil($request->getParameter("id_perfil"));
			$permissoes = null;
			foreach ($listaPermissao->getElements() as $indice => $permissao){
				$perfil = array('id_perfil' => $permissao->getPerfil()->getId(), 'nome' => $permissao->getPerfil()->getNome(), 'descricao' => $permissao->getPerfil()->getDescricao());
				$permissoes[$indice] = array('perfil' => $perfil, 'acessa' => $permissao->getAcessa(), 
				                'consulta' => $permissao->getConsulta(), 'cadastra' => $permissao->getCadastra(),
								'altera' => $permissao->getAtualiza(), 'exclui' => $permissao->getExclui(),      
								'imprimi' => $permissao->getImprimi(), 'id_permissao' => $permissao->getId());
			}
			
			$json = json_encode($permissoes);
			echo $json;	 
		}
	}
	
?>