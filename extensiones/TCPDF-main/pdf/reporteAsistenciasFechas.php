<?php

require_once "../../../modelos/asistencia.modelo.php"; // Modelo de asistencia
require_once "../pdf/tcpdf_include.php";

// Obtener los parámetros del URL
$fechaInicio = $_GET['fechaInicio'];
$fechaFin = $_GET['fechaFin'];

// Validar que las fechas no estén vacías
if (empty($fechaInicio) || empty($fechaFin)) {
    die("Error: Las fechas de inicio y fin no deben estar vacías. Por favor, verifique la información proporcionada.");
}

// Llamar al método para obtener los datos de asistencias
$respuesta = ModeloAsistencia::mdlImprimirReporteAsistenciasFechas($fechaInicio, $fechaFin);

class MYPDF extends TCPDF
{
    public function Header()
    {
        $this->SetY(15);

        $bloque1 = <<<EOF
            <table style="width:100%; font-size:8px;">
                <tr>
                    <td style="width:20%; vertical-align:top;">
                        <img src="../pdf/images/logoN.png" alt="Logo Morocho" width="100">
                    </td>
                    <td style="width:55%; vertical-align:top; text-align:right;">
                        <strong>NIT:</strong> 71.759.963-9 | 
                        <strong>Dirección:</strong> Av. Cuarto Centenario | 
                        <strong>Teléfono:</strong> 3 9232024
                    </td>
                    <td style="width:25%; vertical-align:top; text-align:right;">
                        <strong>Nombre de la Empresa:</strong> BARRACA NENECO
                    </td>
                </tr>
            </table>
        EOF;

        $this->writeHTML($bloque1, false, false, false, false, '');
        $this->Ln(5);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Generado el: ' . date('d-m-Y H:i:s'), 0, 0, 'R');
    }
}

// Crear el PDF en formato vertical (tamaño Carta)
$pdf = new MYPDF('P', PDF_UNIT, 'LETTER', true, 'UTF-8', false);
$pdf->SetMargins(10, 30, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Título y fecha del reporte
$html = '<h2 style="text-align:center;">Reporte de Asistencias</h2>';
$html .= '<p style="text-align:center;">Desde: ' . date('d-m-Y', strtotime($fechaInicio)) . ' Hasta: ' . date('d-m-Y', strtotime($fechaFin)) . '</p>';

// Generar el contenido del reporte con formato alternado
$html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; font-size:10px; border-collapse: collapse; margin-top: 10px;">';

foreach ($respuesta as $fila) {
    // Primera fila con la fecha y horas
    $html .= '<tr>
                <td style="background-color: #ffcc00;"><strong>Código:</strong> ' . $fila['id'] . '</td>
                <td><strong>CI:</strong> ' . $fila['ci'] . '</td>
                <td><strong>Nombre:</strong> ' . $fila['nombre'] . '</td>
                <td><strong>Apellidos:</strong> ' . $fila['apellidop'] . ' ' . $fila['apellidom'] . '</td>
                <td colspan="3"><strong>Cargo:</strong> ' . $fila['nombre_cargo'] . '</td>
              </tr>';
    // Segunda fila con el código y datos del empleado
    $html .= '<tr>
                <td><strong>Fecha:</strong> ' . date('d-m-Y', strtotime($fila['fecha'])) . '</td>
                <td><strong>Entrada 1:</strong> ' . $fila['entrada1'] . '</td>
                <td><strong>Salida 1:</strong> ' . $fila['salida1'] . '</td>
                <td><strong>Entrada 2:</strong> ' . ($fila['entrada2'] ?? 'N/A') . '</td>
                <td><strong>Salida 2:</strong> ' . ($fila['salida2'] ?? 'N/A') . '</td>
                <td><strong>Horas:</strong> ' . $fila['horas'] . '</td>
                <td><strong>Extras:</strong> ' . $fila['extras'] . '</td>
              </tr>';
}

$html .= '</table>';

// Escribir el contenido en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Salida del PDF
$pdf->Output('reporte_asistencias.pdf', 'I');
