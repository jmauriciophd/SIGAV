<?php
require_once dirname(__FILE__) . "/../../../libloader.php";
if(isset($_GET["codigo"]) && isset($_GET["vestuario"])) {
// Variaveis de Tamanho
$mesq = "5"; // Margem Esquerda (mm)
$mdir = "5"; // Margem Direita (mm)
$msup = "12"; // Margem Superior (mm)
$leti = "72"; // Largura da Etiqueta (mm)
$aeti = "27"; // Altura da Etiqueta (mm)
$ehet = "3,2"; // Espaço horizontal entre as Etiquetas (mm)
$pdf=new FPDF('P','mm','Letter'); // Cria um arquivo novo tipo carta, na vertical.
$pdf->Open(); // inicia documento
$pdf->AddPage(); // adiciona a primeira pagina
$pdf->SetMargins('5','12,7'); // Define as margens do documento
$pdf->SetAuthor("SIGAV"); // Define o autor
$pdf->SetFont('helvetica','',7); // Define a fonte
$pdf->SetDisplayMode();

$codigo = "CÓDIGO: " .$_GET["codigo"];
$nome = "" . $_GET["vestuario"];

$pdf->Text($pdf->Image('../../img/etiqueta-azul.jpg', 10, 10, 60, 20));
$pdf->Text(16, 20, $codigo); 
$pdf->Text(16, 23, $nome);

$pdf->Output();
} else {
	echo "Código ou nome do vestuário não informado!";
}
?>