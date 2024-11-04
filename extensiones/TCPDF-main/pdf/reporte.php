<?php
require_once('tcpdf_include.php');

// Crear nueva instancia de TCPDF
$pdf = new TCPDF();

// Establecer información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Reporte PDF');

// Añadir una página
$pdf->AddPage();

// Establecer el contenido del PDF
$html = '<h1>Reporte</h1>';
$html .= '<table border="1" cellpadding="4">';
$html .= '<tr><th>Nombre</th><th>Edad</th><th>Ciudad</th></tr>';

// Aquí deberías obtener los datos de tu base de datos
// Por simplicidad, se usan datos de ejemplo
$html .= '<tr><td>Juan</td><td>30</td><td>Barcelona</td></tr>';
$html .= '<tr><td>Maria</td><td>25</td><td>Madrid</td></tr>';

$html .= '</table>';

// Imprimir contenido HTML en el PDF
$pdf->writeHTML($html);

// Descargar el PDF
$pdf->Output('reporte.pdf', 'I');
?>
