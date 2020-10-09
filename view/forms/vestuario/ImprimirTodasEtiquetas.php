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
$ehet = "3,2"; // Espaзo horizontal entre as Etiquetas (mm)
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
	$codigo = "CУDIGO: " .$estoque->getCodigoVestuario();
	$nome = "" . $vestuario->getNome();
	
	if($linha == "10") {
		$pdf->AddPage();
		$linha = 0;
	}
	
	if($coluna == "3") { // Se for a terceira coluna
		$coluna = 0; // $coluna volta para o valor inicial
		$linha = $linha +1; // $linha й igual ela mesma +1
	}
	
	if($linha == "10") { // Se for a ъltima linha da pбgina
		$pdf->AddPage(); // Adiciona uma nova pбgina
		$linha = 0; // $linha volta ao seu valor inicial
	}
	
	$posicaoV = $linha*$aeti;
	$posicaoH = $coluna*$leti;
	
	if($coluna == "0") { // Se a coluna for 0
		$somaH = $mesq; // Soma Horizontal й apenas a margem da esquerda inicial
	} else { // Senгo
		$somaH = $mesq+$posicaoH; // Soma Horizontal й a margem inicial mais a posiзгoH
	}
	
	if($linha =="0") { // Se a linha for 0
		$somaV = $msup; // Soma Vertical й apenas a margem superior inicial
	} else { // Senгo
		$somaV = $msup+$posicaoV; // Soma Vertical й a margem superior inicial mais a posiзгoV
	}
	
	$pdf->Text($pdf->Image('../../img/etiqueta-azul.jpg', $somaH, $somaV, 60, 20));
	$pdf->Text($somaH+6,$somaV+10,$codigo); 
	$pdf->Text($somaH+6,$somaV+13,$nome);
	$coluna = $coluna+1;
}

$pdf->Output();
} else {
	echo "ID Vestuбrio nгo informado ou invбlido!";
}
?>