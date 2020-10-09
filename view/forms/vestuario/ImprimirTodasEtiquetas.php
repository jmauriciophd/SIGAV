<?php
require_once dirname(__FILE__) . "/../../../libloader.php";
if(isset($_GET["id_vestuario"])) {
$vestuarioController = new VestuarioController();
$vestuario = $vestuarioController->consultarVestuarioPorId($_GET["id_vestuario"]);
$listaEstoque = $vestuario->getListaEstoque();
// Variaveis de Tamanho

$mesq = "5"; // Margem Esquerda (mm)
$mdir = "5"; // Margem Direita (mm)
$msup = "12"; // Margem Superior (mm)
$leti = "72"; // Largura da Etiqueta (mm)
$aeti = "27"; // Altura da Etiqueta (mm)
$ehet = "3,2"; // Espa�o horizontal entre as Etiquetas (mm)
$pdf=new FPDF('P','mm','Letter'); // Cria um arquivo novo tipo carta, na vertical.
$pdf->Open(); // inicia documento
$pdf->AddPage(); // adiciona a primeira pagina
$pdf->SetMargins('5','12,7'); // Define as margens do documento
$pdf->SetAuthor("Jonas Ferreira"); // Define o autor
$pdf->SetFont('helvetica','',7); // Define a fonte
$pdf->SetDisplayMode();

$coluna = 0;
$linha = 0;
//MONTA A ARRAY PARA ETIQUETAS
foreach ($listaEstoque->getElements() as $indice => $estoque) {
	$codigo = "C�DIGO: " .$estoque->getCodigoVestuario();
	$nome = "" . $vestuario->getNome();
	
	if($linha == "10") {
		$pdf->AddPage();
		$linha = 0;
	}
	
	if($coluna == "3") { // Se for a terceira coluna
		$coluna = 0; // $coluna volta para o valor inicial
		$linha = $linha +1; // $linha � igual ela mesma +1
	}
	
	if($linha == "10") { // Se for a �ltima linha da p�gina
		$pdf->AddPage(); // Adiciona uma nova p�gina
		$linha = 0; // $linha volta ao seu valor inicial
	}
	
	$posicaoV = $linha*$aeti;
	$posicaoH = $coluna*$leti;
	
	if($coluna == "0") { // Se a coluna for 0
		$somaH = $mesq; // Soma Horizontal � apenas a margem da esquerda inicial
	} else { // Sen�o
		$somaH = $mesq+$posicaoH; // Soma Horizontal � a margem inicial mais a posi��oH
	}
	
	if($linha =="0") { // Se a linha for 0
		$somaV = $msup; // Soma Vertical � apenas a margem superior inicial
	} else { // Sen�o
		$somaV = $msup+$posicaoV; // Soma Vertical � a margem superior inicial mais a posi��oV
	}
	
	$pdf->Text($pdf->Image('../../img/etiqueta-azul.jpg', $somaH, $somaV, 60, 20));
	$pdf->Text($somaH+6,$somaV+10,$codigo); 
	$pdf->Text($somaH+6,$somaV+13,$nome);
	$coluna = $coluna+1;
}

$pdf->Output();
} else {
	echo "ID Vestu�rio n�o informado ou inv�lido!";
}
?>