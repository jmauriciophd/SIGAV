<?php
require_once dirname(__FILE__) . "/../libloader.php";
/**
* Classe utilitaria.
* @author Rafael Dias
*/
class Util
{
	public function Util()
	{
	}
	
	public static function formataDataMysql($data)
	{
		return implode("-", array_reverse(explode("/", $data)));
	}

	public static function formataDataPtBr($data)
	{
		return implode("/",array_reverse(explode("-",$data)));
	}
	
	public static function removeTracosPontos($valor)
	{
		return preg_replace("/\D+/", "", $valor);
	}
	
	public static function exibirValor($valor)
	{
		if(!empty($valor)){
			echo $valor;
		} else{
			echo '';
		}
	}
	
	public static function editarDadosFormulario($valorGet){
		return (isset($_GET['editar']) && isset($_GET[$valorGet]) && !empty($_GET[$valorGet]));
	}
	
	public static function exibirMsg($artigo, $entidade){
			if (isset($_GET["sucess"]) || isset($_GET["sucessUpdate"]) || isset($_GET["sucessDelete"])){
				  echo "<div id='msgSucess'>";
				  echo "<img src='../../img/icons/button_yes.png' width='17px' height='17px' alt='Sucesso'>";
				  echo " $artigo $entidade foi ";
				  echo (isset($_GET["sucessDelete"])) ? "excluid$artigo" : ((isset($_GET["sucess"])) ? "cadastrad$artigo" : "atualizad$artigo");
				  echo " com sucesso.</div>"; 
			} elseif (isset($_GET["error"]) || isset($_GET["errorUpdate"]) || isset($_GET["errorDelete"])){
				  echo "<div id='msgError'>";
				  echo "<img src='../../img/icons/button_no.png' width='17px' height='17px' alt='Erro'>";
				  echo " Erro: Não foi possivel "; 
				  echo (isset($_GET["errorDelete"])) ? "excluir" : ((isset($_GET["error"])) ? "cadastrar" : "atualizar");
				  echo " $artigo $entidade.</div>";
			} elseif (isset($_GET["msgSucess"])){
				  echo "<div id='msgSucess'>";
				  echo "<img src='../../img/icons/button_yes.png' width='17px' height='17px' alt='Sucesso'> ";
				  echo $_GET["msgSucess"]; 
				  echo "</div>";
			} elseif (isset($_GET["msgError"])){
				  echo "<div id='msgError'>";
				  echo "<img src='../../img/icons/button_no.png' width='17px' height='17px' alt='Erro'> ";
				  echo $_GET["msgError"]; 
				  echo "</div>";
			} 
	}
	
	public static function exibirMsgSucessError($msg, $tipo){
		if($msg != "" && $tipo != ""){
			if($tipo == 'sucess'){
				$id="msgSucess";
				$img="button_yes.png";
				$alt="Sucesso";
			} elseif ($tipo == 'error'){
			    $id="msgError";
				$img="button_no.png";
				$alt="Erro";
			}
			echo "<div id='".$id."'>";
			echo "<img src='../../img/icons/".$img."' width='17px' height='17px' alt='".$alt."'>  &nbsp;";
		    echo $msg;
		    echo "</div>"; 
		}
	}
	
	public static function alert($msg){
			echo "<script language= 'JavaScript'> alert('".$msg."') </script>";
	}
	
	public static function redirecionaPaginaJS($url){
			echo "<script language= 'JavaScript'> top.location.href='".$url."' </script>";
	}
	
	public static function redirecionaPaginaAjax($url){
			Util::redirecionaPaginaPHP('../view/forms/menu/menu.php?url='.$url);
	}
	
	public static function redirecionaPaginaPHP($url){
			header("Location: $url");
	}
	
	public static function redirecionaPaginaHTML($url){
			echo '<meta http-equiv="refresh" content="0;'.$url.'">';
	}
	
	public static function iniciaSessao(){
		if(!isset($_SESSION)){
			  session_start(); 
		}
	}
	
	public static function notEmpty($valor){
		return (isset($valor) && $valor != null && $valor != "");
	}
	
	public static function subtrairData($data, $v, $t="a"){
	  list($a, $m, $d) = explode("-", $data);
	  switch($t){
	    case "d":
	      $r = mktime(0,0,0,$m,($d-$v),$a);
	    break;
	    case "m":
	      $r = mktime(0,0,0,($m-$v),$d,$a);
	    break;
	    case "a":
	      $r = mktime(0,0,0,$m,$d,($a-$v));
	    break;
	  }
	  return date("Y-m-d",$r);
	}
	
	public static function somarData($data, $v, $t="a"){
	  list($a, $m, $d) = explode("-", $data);
	  switch($t){
	    case "d":
	      $r = mktime(0,0,0,$m,($d+$v),$a);
	    break;
	    case "m":
	      $r = mktime(0,0,0,($m+$v),$d,$a);
	    break;
	    case "a":
	      $r = mktime(0,0,0,$m,$d,($a+$v));
	    break;
	  }
	  return date("Y-m-d",$r);
	}
	
	public static function getNomeArquivo(){
		$pageExecute = $_SERVER['SCRIPT_NAME'];
		$nome_arquivo = explode("/", $pageExecute);
		return "../".$nome_arquivo[4]."/".$nome_arquivo[5];
	}
	
	public static function selecionar($opcao, $valor){
		$selected = "";
		if($opcao == $valor){
			$selected = "selected='selected'";
		}
		return $selected;
	}
	
	public static function marcarRadioButton($opcao, $valor){
		if($opcao == $valor){
			echo "checked='checked'";
		} 
	}
	
	public static function listaEstadosCivis($options = array()){
		 // Arrays com as UF e siglas
         $arrData = array('S' => 'Solteiro(a)', 'C' => 'Casado(a)', 'D' => 'Divorciado(a)', 'V' => 'Víuvo(a)');
                       
         // Ordena sem alterar os indices
         asort( $arrData, SORT_STRING );
                        
        // Faz um merge com os arrays
        return array_merge($arrData, $options);
	}
    
	public static function listaFormaPagamentos($options = array()){
		 // Arrays com as UF e siglas
         $arrData = array(
         'B' => 'Boleto',
         'D' => 'Dinheiro',
         'C' => 'Cheque', 
         'CC' => 'Cartao de Crédito', 
         'CD' => 'Cartao de Débito');
                       
         // Ordena sem alterar os indices
         asort( $arrData, SORT_STRING );
                        
        // Faz um merge com os arrays
        return array_merge($arrData, $options);
        
	}
     public static function listaQtdParcelas($options = array(), $ordenar = false){
		 // Arrays com as UF e siglas
        $arrData = array('1'  => '1',
				         '2'  => '2', 
				         '3'  => '3', 
				         '4'  => '4',
				         '5'  => '5',
				         '6'  => '6', 
				         '7'  => '7', 
				         '8'  => '8',
				         '9'  => '9',
				         '10' => '10', 
				         '11' => '11', 
				         '12' => '12'    
         );

          // Ordena sem alterar os indices
         if($ordenar)
         asort( $arrData, SORT_STRING );
                        
        // Faz um merge com os arrays
        return array_merge($arrData, $options);
	}
	
	public static function listaGrauInstrucao($options = array()){
		 // Arrays com as UF e siglas
         $arrData = array('1' => 'Ensino Fundamental Completo', 
         				  '2' => 'Ensino Fundamental Incompleto', 
         				  '3' => 'Ensino Médio Completo', 
         				  '4' => 'Ensino Médio Incompleto',
					      '5' => 'Ensino Superior Completo',
					      '6' => 'Ensino Superior Incompleto',
					      '7' => 'Ensino Profissionalizante/Técnico'
         				 );
         // Ordena sem alterar os indices
         asort( $arrData, SORT_STRING );
                        
        // Faz um merge com os arrays
        return array_merge($arrData, $options);
	}
	
	public static function listaEstadosBrasileiro($options = array()){
		 // Arrays com as UF e siglas
                        $arrData = array(
                                'AM' => 'AMAZONAS',
                                'AC' => 'ACRE',
                                'AL' => 'ALAGOAS',
                                'AP' => 'AMAPA',
                                'CE' => 'CEARÁ',
                                'DF' => 'DISTRITO FEDERAL',
                                'ES' => 'ESPIRITO SANTO',
                                'MA' => 'MARANHÃO',
                                'PR' => 'PARANÁ',
                                'PE' => 'PERNAMBUCO',
                                'PI' => 'PIAUÍ',
                                'RN' => 'RIO GRANDRE DO NORTE',
                                'RS' => 'RIO GRANDE DO SUL',
                                'RO' => 'RONDÔNIA',
                                'RR' => 'RORAIMA',
                                'SC' => 'SANTA CATARINA',
                                'SE' => 'SERGIPE',
                                'TO' => 'TOCATINS',
                                'PA' => 'PARÁ',
                                'BH' => 'BAHIA',
                                'GO' => 'GOIÁIS',
                                'MT' => 'MATO GROSSO',
                                'MS' => 'MATO GROSSO DO SUL',
                                'RJ' => 'RIO DE JANEIRO',
                                'SP' => 'SÃO PAULO',
                                'MG' => 'MINAS GERAIS',
                                'PB' => 'PARAIBA',
                        );
                       
                        // Ordena sem alterar os indices
                        asort( $arrData, SORT_STRING );
                        
                        // Faz um merge com os arrays
                        $listaEstados = array_merge($arrData, $options);
                        
                        return $listaEstados;
	}
	
	public static function montarOpcoesSelect($options = array(), $valor = "", $tipoLabel = 1){
			foreach ($options as $value => $label){
				if($tipoLabel == 1){
					echo "<option value='" . $value . "' " . Util::selecionar($value, $valor) . " >" . $label . "</option>";
				} else if($tipoLabel == 2){
					echo "<option value='" . $value . "' " . Util::selecionar($value, $valor) . " >" . $value . "</option>";
				} else if($tipoLabel == 3){
					echo "<option value='" . $label . "' " . Util::selecionar($label, $valor) . " >" . $label . "</option>";
				}
			}
	}

	public static function includeArquivosJs($listaArquivos = array()){
		foreach ($listaArquivos as $indice => $arquivo) {
			echo "<script type='text/javascript' src='../../js/".$arquivo."' charset='iso-8859-1'></script>";
		}
	}
	
	public static function includeArquivosCss($listaArquivos = array()){
		foreach ($listaArquivos as $indice => $arquivo) {
			echo "<link rel='stylesheet' type='text/css' href='../../css/".$arquivo."' />";
		}
	}
	
 	public static function moeda($get_valor, $tipo = 0) {
 		$get_valor = ($get_valor == "") ? "0.00" : $get_valor;
 		//0 = grava e 1 = exibe
 		if($tipo == 0){
                $source = array('R$', '.', ','); 
                $replace = array('', '', '.');
                $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
                return $valor; //retorna o valor formatado para gravar no banco
 		} else if($tipo == 1){
                return "R$ " . number_format($get_valor, 2, ',', '.'); //retorna o valor para exibi no formato 9.999,99
 		}  
    }
    
	/**
	* Função para gerar senhas aleatórias
	*
	* @author    Thiago Belem <contato@thiagobelem.net>
	*
	* @param integer $tamanho Tamanho da senha a ser gerada
	* @param boolean $maiusculas Se terá letras maiúsculas
	* @param boolean $numeros Se terá números
	* @param boolean $simbolos Se terá símbolos
	*
	* @return string A senha gerada
	*/
	public static function gerarSenha($tamanho = 6, $maiusculas = true, $numeros = true, $simbolos = true)
	{
		$lmin = 'abcdefghijklmnopqrstuvwxyz';
		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%*-';
		$retorno = '';
		$caracteres = '';
		
		$caracteres .= $lmin;
		if ($maiusculas) $caracteres .= $lmai;
		if ($numeros) $caracteres .= $num;
		if ($simbolos) $caracteres .= $simb;
		
		$len = strlen($caracteres);
		for ($n = 1; $n <= $tamanho; $n++) {
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand-1];
		}
		return $retorno;
	}
    
	public static function enviarEmail($para, $nome, $assunto, $mensagem){
		$mail = new PHPMailer(); // INICIA A CLASSE PHPMAILER
		
		$mail->IsSMTP(); //ESSA OPÇÃO HABILITA O ENVIO DE SMTP
		
		// Define o método de envio
		$mail->Mailer     = "smtp";
		 
		// Define que a mensagem poderá ter formatação HTML
		$mail->IsHTML(true); //
		 
		// Define que a codificação do conteúdo da mensagem será utf-8
		$mail->CharSet    = "utf-8";
		 
		// Define que os emails enviadas utilizarão SMTP Seguro tls
		$mail->SMTPSecure = "tls";
		
		$mail->Host = "smtp.gmail.com"; //SERVIDOR DE SMTP, USE smtp.SeuDominio.com OU smtp.hostsys.com.br 
		
		//Define a porta utilizada pelo Gmail para o envio autenticado
		$mail->Port = "587"; 
		
		$mail->SMTPAuth = "true"; //ATIVA O SMTP AUTENTICADO
		
		$mail->Username = "sistemasigav@gmail.com"; //EMAIL PARA SMTP AUTENTICADO (pode ser qualquer conta de email do seu domínio)
		
		$mail->Password = "jovemmaria"; //SENHA DO EMAIL PARA SMTP AUTENTICADO
		
		$mail->From = "rafadias05@gmail.com"; //E-MAIL DO REMETENTE 
		
		$mail->FromName = "SIGAV"; //NOME DO REMETENTE
		
		$mail->AddAddress($para, $nome); //E-MAIL DO DESINATÁRIO, NOME DO DESINATÁRIO --> AS VARIÁVEIS ALI PODEM FAZER REFERÊNCIA A DADOS VINDO DE $_GET OU $_POST, OU AINDA DO BANCO DE DADOS
		
		$mail->WordWrap = 50; // ATIVAR QUEBRA DE LINHA
		
		$mail->IsHTML(true); //ATIVA MENSAGEM NO FORMATO HTML
		
		$mail->Subject = $assunto; //ASSUNTO DA MENSAGEM
		
		//MENSAGEM NO FORMATO HTML, PODE SER TEXTO OU IMAGEM
		$mail->Body =  $mensagem;
		
		// verifica se está tudo ok com oa parametros acima, se nao, avisa do erro. Se sim, envia.
		$resp = $mail->Send();
		
		return $resp;
	}
	
	public static function exibirStatusVestuario($codigoStatus){
		if($codigoStatus == 1){
			return "Disponível";
		} else {
			return "Sem status";
		}
	}
	
	public static function dataPorExtenso($exibirSemana = false){
		// leitura das datas
		$dia = date('d');
		$mes = date('m');
		$ano = date('Y');
		$semana = date('w');
		
		// configuração mes
		switch ($mes){
			case 1: $mes = "JANEIRO"; break;
			case 2: $mes = "FEVEREIRO"; break;
			case 3: $mes = "MARÇO"; break;
			case 4: $mes = "ABRIL"; break;
			case 5: $mes = "MAIO"; break;
			case 6: $mes = "JUNHO"; break;
			case 7: $mes = "JULHO"; break;
			case 8: $mes = "AGOSTO"; break;
			case 9: $mes = "SETEMBRO"; break;
			case 10: $mes = "OUTUBRO"; break;
			case 11: $mes = "NOVEMBRO"; break;
			case 12: $mes = "DEZEMBRO"; break;
		}
		
		// configuração semana
		switch ($semana) {
			case 0: $semana = "DOMINGO"; break;
			case 1: $semana = "SEGUNDA FEIRA"; break;
			case 2: $semana = "TERÇA-FEIRA"; break;
			case 3: $semana = "QUARTA-FEIRA"; break;
			case 4: $semana = "QUINTA-FEIRA"; break;
			case 5: $semana = "SEXTA-FEIRA"; break;
			case 6: $semana = "SÁBADO"; break;

		}
		if($exibirSemana)
			print ("$semana, $dia de $mes de $ano.");
		else
		    print ("$dia de $mes de $ano.");
	}

}

?>