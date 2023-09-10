<?php
$titulopag = "Exportar a PDF - Sistema de Voto";
include $_SERVER['DOCUMENT_ROOT'] . '/config/class.php';
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
require $_SERVER['DOCUMENT_ROOT'] . '/tools/fpdf/fpdf.php';
setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
date_default_timezone_set('Europe/Madrid');
$fecha = date("dmoHis");
$nombrepdf = 'Certificado'. $fecha. '.pdf';
$currentdate = strftime("%A %d de %B de %Y a las %H:%M:%S");
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(00, 10, 'Nombre del archivo: '.$_GET["file"], 0, 0, 'C');
$pdf->ln();
$hash = hash_file('sha1', $_SERVER['DOCUMENT_ROOT'] . '/assets/certs/'.$_GET["file"]);
$pdf->Cell(00, 10, "Hash (md5): $hash", 0, 0, 'C');
$pdf->Output('I', 'Certificado_Exportado.pdf');
?>