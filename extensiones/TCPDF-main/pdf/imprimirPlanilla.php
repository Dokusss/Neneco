<?php

require_once "../../../modelos/planilla.modelo.php";
require_once "../pdf/tcpdf_include.php";

if (isset($_GET['idPlanilla']) && !empty($_GET['idPlanilla'])) {
    $idPlanilla = intval($_GET['idPlanilla']);
    $planilla = ModeloPlanilla::mdlImprimirPlanilla($idPlanilla);

    if ($planilla) {
        $fechaPlanilla = $planilla[0]['fecha'];

        class MYPDF extends TCPDF
        {
            public function Header()
            {
                // Ajustar margen superior
                $this->SetY(15); // Agrega un margen superior de 15 unidades. Puedes ajustar este valor según tus necesidades.

                // Encabezado personalizado con información de la empresa
                $bloque1 = <<<EOF
                    <table style="width:100%; font-size:8px;"> <!-- Cambié el tamaño de fuente a 8px -->
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
                $this->Ln(5); // Espaciado después del encabezado
            }

            public function Footer()
            {
                $this->SetY(-15);
                $this->SetFont('helvetica', 'I', 8);
                $this->Cell(0, 10, 'Generado el: ' . date('d-m-Y H:i:s'), 0, 0, 'R');
            }
        }

        $pdf = new MYPDF('L', PDF_UNIT, 'LEGAL', true, 'UTF-8', false);
        $pdf->SetMargins(10, 30, 10);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 10);

        // Título y fecha de la planilla
        $html = '<h2 style="text-align:center;">PLANILLA DE PAGO</h2>';
        $html .= '<p style="font-size: 12px;">FECHA: ' . date('d-m-Y', strtotime($fechaPlanilla)) . '</p>';

        // Iterar sobre cada empleado y construir las filas
        foreach ($planilla as $fila) {
            $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; font-size:10px; border-collapse: collapse; margin-bottom: 10px;">
                <tr>
                    <td style="background-color: #ffcc00;"><strong>Código:</strong> ' . $fila['id'] . '</td>
                    <td><strong>Nombre:</strong> ' . $fila['nombre'] . '</td>
                    <td><strong>Haber Básico:</strong> ' . number_format($fila['haberbasico'], 2) . ' bs.</td>
                    <td><strong>Días Trabajados:</strong> ' . $fila['diastrabajados'] . '</td>
                    <td><strong>Anticipos:</strong> ' . number_format($fila['anticipos'], 2) . ' bs.</td>
                    <td><strong>Faltas:</strong> ' . $fila['faltas'] . '</td>
                    <td rowspan="2"><strong>Firma</strong></td>
                </tr>
                <tr>
                    <td><strong>Documento:</strong> ' . $fila['ci'] . '</td>
                    <td><strong>Apellidos:</strong> ' . $fila['apellidop'] . ' ' . $fila['apellidom'] . '</td>
                    <td><strong>Cargo:</strong> ' . $fila['nombre_cargo'] . '</td>
                    <td><strong>Horas Extras:</strong> ' . number_format($fila['horasextras'], 2) . ' bs.</td>
                    <td><strong>Total Descuentos:</strong> ' . number_format($fila['totaldescuentos'], 2) . ' bs.</td>
                    <td><strong>Líquido Pagable:</strong> ' . number_format($fila['liquidopagable'], 2) . ' bs.</td>
                </tr>
            </table>';
        }

        // Total a pagado
        $totalPagado = array_sum(array_column($planilla, 'liquidopagable'));
        $html .= '<p style="text-align:right; font-size: 12px; font-weight: bold;">TOTAL A PAGADO: ' . number_format($totalPagado, 2) . ' bs.</p>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('planilla_de_pago.pdf', 'I');
    } else {
        echo "No se encontraron datos para la planilla.";
    }
} else {
    echo "Planilla no seleccionada.";
}
