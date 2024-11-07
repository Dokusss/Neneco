<?php

require_once "../../../modelos/asistencia.modelo.php"; // Modelo de asistencia
require_once "../pdf/tcpdf_include.php";

// Obtener los parámetros del URL
$fechaInicio = $_GET['fechaInicio'];
$fechaFin = $_GET['fechaFin'];
$idEmpleado = $_GET['idEmpleado'];

// Validar que las fechas y el idEmpleado no estén vacíos
if (empty($fechaInicio) || empty($fechaFin) || empty($idEmpleado)) {
    die("Error: Uno o más datos requeridos están vacíos. Por favor, verifique la información proporcionada.");
}

// Llamar al método para obtener los datos de asistencias
$respuesta = ModeloAsistencia::mdlImprimirReporteAsistenciasFechasId($fechaInicio, $fechaFin, $idEmpleado);

// Obtener los datos del primer registro para mostrar la información del empleado
$datosEmpleado = $respuesta[0];

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

// Información del empleado en formato horizontal
$html .= '<table border="0" cellpadding="5" cellspacing="0" style="width:100%; font-size:10px;">';
$html .= '<tr>
            <td><strong>Código:</strong> ' . $datosEmpleado['id'] . '</td>
            <td><strong>CI:</strong> ' . $datosEmpleado['ci'] . '</td>
            <td><strong>Nombre:</strong> ' . $datosEmpleado['nombre'] . '</td>
            <td><strong>Apellidos:</strong> ' . $datosEmpleado['apellidop'] . ' ' . $datosEmpleado['apellidom'] . '</td>
            <td><strong>Cargo:</strong> ' . $datosEmpleado['nombre_cargo'] . '</td>
          </tr>';
$html .= '</table>';

// Generar el contenido del reporte con la cabecera en color gris claro
$html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; font-size:10px; border-collapse: collapse; margin-top: 10px;">';
$html .= '<thead>
            <tr style="background-color: #d3d3d3;"> <!-- Color gris claro -->
                <th rowspan="2">Fecha</th>
                <th colspan="2" style="text-align:center;">Mañana</th>
                <th colspan="2" style="text-align:center;">Tarde</th>
                <th rowspan="2">Horas trabajadas</th>
                <th rowspan="2">Extras</th>
            </tr>
            <tr style="background-color: #d3d3d3;"> <!-- Color gris claro -->
                <th>Entrada</th>
                <th>Salida</th>
                <th>Entrada</th>
                <th>Salida</th>
            </tr>
          </thead>';
$html .= '<tbody>';

// Recorrer los datos y agregarlos a la tabla
foreach ($respuesta as $fila) {
    $html .= '<tr>
                <td>' . date('d-m-Y', strtotime($fila['fecha'])) . '</td>
                <td>' . $fila['entrada1'] . '</td>
                <td>' . $fila['salida1'] . '</td>
                <td>' . ($fila['entrada2'] ?? 'N/A') . '</td>
                <td>' . ($fila['salida2'] ?? 'N/A') . '</td>
                <td>' . $fila['horas'] . '</td>
                <td>' . $fila['extras'] . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Escribir el contenido en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Salida del PDF
$pdf->Output('reporte_asistencias.pdf', 'I');
