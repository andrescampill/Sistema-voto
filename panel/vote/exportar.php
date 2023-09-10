<?php
$titulopag = "Exportar a PDF - Sistema de Voto";
include $_SERVER['DOCUMENT_ROOT'] . '/config/class.php';
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
require $_SERVER['DOCUMENT_ROOT'] . '/tools/fpdf/fpdf.php';
setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
date_default_timezone_set('Europe/Madrid');
$currentdate = strftime("%A %d de %B de %Y a las %H:%M:%S");
$id = $_GET['id'];
$sql = "SELECT * FROM vote WHERE id = '$id'";
$resultado = mysqli_query($conec, $sql);
$data = $resultado->fetch_assoc();
$titulo = $data["titulo"];
$texto = $data["texto"];
$activa = $data["activa"];
$total = $data["si"] + $data["no"] + $data["abs"];
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/pdf-header.png', 10, 9, 50);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 14);
        // Título
        $this->Cell(00, 10, 'CERTIFICADO DE VOTACION', 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }
    function Tabla()
    {
        $conec = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $id = $_GET['id'];
        $sql = "SELECT * FROM vote WHERE id = '$id'";
        $resultado = mysqli_query($conec, $sql);
        $data = $resultado->fetch_assoc();
        $titulo = $data["titulo"];
        $texto = $data["texto"];
        $activa = $data["activa"];
        $total = $data["si"] + $data["no"] + $data["abs"];
        $oper = json_decode($data["op"], true);
        $this->Cell(50, 7, "ID: ", 1,);
        $this->Cell(90, 7, $_GET["id"], 1,);
        $this->Ln();
        $this->Cell(50, 7, "Titulo: ", 1,);
        $this->Cell(90, 7, $titulo, 1,);
        $this->Ln();
        $this->Cell(50, 7, "Descripcion: ", 1,);
        $this->Cell(90, 7, $texto, 1,);
        $this->Ln();
        $this->Cell(50, 7, "Activa: ", 1,);
        $this->Cell(90, 7, "$activa (0 es inactiva, 1 es activa)*", 1,);
        $this->Ln();
        $this->Cell(50, 7, "Total de votos: ", 1,);
        $this->Cell(90, 7, "$total", 1,);
        $this->Ln();
        $this->Cell(50, 7, "Tipo: ", 1,);
        $this->Cell(90, 7, $data["type"], 1,);
        if ($data["type"] == "per") {
            $this->Ln();
            $this->Cell(50, 7, "Numero maximo a elegir: ", 1,);
            $this->Cell(90, 7, $data["max"], 1,);
            $totalopc = '0';
            foreach ($oper as $opcion) {
                foreach ($opcion as $opcion => $value) {
                    $totalopc = $totalopc + $value;
                }
            }
            foreach ($oper as $opcion) {
                foreach ($opcion as $opcion => $value) {
                $this->Ln();
                $this->Cell(50, 7, $opcion, 1,);
                $this->Cell(20, 7, $value, 1,);
                if ($totalopc != 0) {
                    $this->Cell(70, 7, '' . number_format($value / $totalopc * 100, 2) . '%', 1,);
                } else {
                    $this->Cell(70, 7, number_format($value / $totalopc * 100 * 0, 2) . '%', 1);
                }
            }}
        } {
        }
    }
}

// Creación del objeto de la clase heredada
$txt = 'El Sistema de Voto digital de la Federacion Murciana de Asociaciones de Estudiantes (FEMAE), informa que a fecha de ' . $currentdate . ', se encuentran en el sistema electronico de votación la votacion con los siguientes resultados:';
$txt2 = "Y para que conste a los efectos oportunos, se firma y sella el presente certificado:";
$txt3 = 'En, Murcia, Region de Murcia a ' . $currentdate . '.';
$fecha = strval($_GET["time"]);
$dir = 'Cert'.$fecha.'.pdf';
$nombrepdf = 'Certificado'. $fecha. '.pdf';
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetTitle(" ");
$pdf->SetAuthor(" ");
$pdf->SetSubject(" ");
$pdf->SetCreator(" ");
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 12);
$pdf->MultiCell(0, 5, $txt);
$pdf->Ln();
$pdf->Tabla();
$pdf->Ln(50);
$pdf->MultiCell(0, 5, $txt2);
$pdf->Ln(20);
$pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/pdf-header.png', 50, 180, 50);
$pdf->MultiCell(0, 5, $txt3);
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . '/assets/certs/'.$nombrepdf.'', 'F');
$hash = hash_file('md5', $pdf->Output());
//$pdf->Cell(00, 10, "Hash: $hash", 0, 0, 'C');
$pdf->Output('I', $nombrepdf);
?>
<link rel="stylesheet" href="/styles/info.php.css">
<?php

?>