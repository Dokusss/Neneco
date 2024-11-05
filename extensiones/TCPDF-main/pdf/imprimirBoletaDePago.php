<?php
require_once "../../../modelos/planilla.modelo.php";
require_once "../pdf/tcpdf_include.php";

if (isset($_GET['idEmpleado']) && !empty($_GET['idEmpleado'])) {
    $idEmpleado = intval($_GET['idEmpleado']);
    $planilla = ModeloPlanilla::mdlImprimirBoletaDePago($idEmpleado);

    if ($planilla) {
        $datosEmpleado = $planilla[0];
        $fechaPlanilla = $datosEmpleado['fecha'];

        class MYPDF extends TCPDF
        {
            public function Header()
            {
                // Espacio superior para el margen
                $this->SetY(10); // Ajusta este valor según necesites el margen superior

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

        $pdf = new MYPDF('P', PDF_UNIT, 'LETTER', true, 'UTF-8', false);
        $pdf->SetMargins(10, 30, 10); // Ajusta el margen superior aquí si es necesario
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 14);

        // Título principal
        $pdf->Cell(0, 10, 'Boleta de Pago', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);

        // Información básica del empleado
        $html = '<table border="0" cellpadding="5" cellspacing="0" style="width:100%; font-size:10px;">
            <tr>
                <td><strong>Código:</strong> ' . $datosEmpleado['ci'] . '</td>
                <td><strong>Cargo:</strong> ' . $datosEmpleado['nombre_cargo'] . '</td>
            </tr>
            <tr>
                <td><strong>Apellido y Nombre:</strong> ' . $datosEmpleado['apellidop'] . ' ' . $datosEmpleado['apellidom'] . ', ' . $datosEmpleado['nombre'] . '</td>
                <td><strong>Fecha de emisión:</strong> ' . date('d-m-Y', strtotime($fechaPlanilla)) . '</td>
            </tr>
        </table>';

        // Tabla de remuneración y descuentos
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; font-size:10px; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background-color: #ffcc00;">
                    <th colspan="2">Remuneración</th>
                    <th colspan="2">Descuentos</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Descripción</td>
                    <td>Importe</td>
                    <td>Descripción</td>
                    <td>Importe</td>
                </tr>
                <tr>
                    <td>Sueldo Básico:</td>
                    <td>' . number_format($datosEmpleado['haberbasico'], 2) . ' bs.</td>
                    <td>Adelanto:</td>
                    <td>' . number_format($datosEmpleado['anticipos'], 2) . ' bs.</td>
                </tr>
                <tr>
                    <td>Horas extras:</td>
                    <td>' . number_format($datosEmpleado['horasextras'], 2) . ' bs.</td>
                    <td>Total Descuentos:</td>
                    <td>' . number_format($datosEmpleado['totaldescuentos'], 2) . ' bs.</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:right;"><strong>Subtotal Remuneración:</strong></td>
                    <td colspan="2" style="text-align:right;">' . number_format($datosEmpleado['haberbasico'] + $datosEmpleado['horasextras'], 2) . ' bs.</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:right;"><strong>Subtotal Descuento:</strong></td>
                    <td colspan="2" style="text-align:right;">' . number_format($datosEmpleado['totaldescuentos'], 2) . ' bs.</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:right; background-color: #d9edf7;"><strong>Neto a Pagar:</strong> ' . number_format($datosEmpleado['liquidopagable'], 2) . ' bs.</td>
                </tr>
            </tbody>
        </table>';

        // Firmas
        $html .= '<table border="0" cellpadding="5" cellspacing="0" style="width:100%; font-size:10px; margin-top: 100px;">
            <tr>
                <td style="text-align:center;"></td>
                <td style="text-align:center;"></td>
            </tr>
            <tr>
                <td style="text-align:center;"></td>
                <td style="text-align:center;"></td>
            </tr>
            <tr>
                <td style="text-align:center;"></td>
                <td style="text-align:center;"></td>
            </tr>
            <tr>
                <td style="text-align:center;">_______________________</td>
                <td style="text-align:center;">_______________________</td>
            </tr>
            <tr>
                <td style="text-align:center;">Firma del Pagador</td>
                <td style="text-align:center;">Firma del Trabajador</td>
            </tr>
            </table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('boleta_de_pago.pdf', 'I');
    } else {
        echo "No se encontraron datos para la boleta de pago.";
    }
} else {
    echo "Empleado no seleccionado.";
}
