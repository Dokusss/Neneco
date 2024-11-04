<?php

require_once "../../../modelos/planilla.modelo.php";
require_once "../pdf/tcpdf_include.php";

if (isset($_GET['idPlanilla']) && !empty($_GET['idPlanilla'])) {
    $idPlanilla = intval($_GET['idPlanilla']);

    $planilla = ModeloPlanilla::mdlImprimirPlanilla($idPlanilla);

    if ($planilla) {

        class MYPDF extends TCPDF
        {

            public function Header()
            {
                $bloque1 = <<<EOF
                    <table style="width:100%; font-size:10px;">
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
                $this->Cell(0, 0, '', 'T', 1, 'C', 0, '', 1);
            }

            // Agregar un pie de página personalizado
            public function Footer()
            {
                // Posición a 20 mm desde la parte inferior
                $this->SetY(-20);

                // Establece el estilo de la línea
                $this->SetLineStyle(array('width' => 0.5, 'cap' => 'round', 'join' => 'round', 'dash' => 0, 'color' => array(0, 0, 0)));

                // Posición a 15 mm desde la parte inferior
                $this->SetY(-15);
                $this->SetFont('helvetica', 'I', 8);

                $this->Cell(0, 10, 'Generado el: ' . date('d-m-Y H:i:s'), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            }
        }

        // Crear una nueva instancia del PDF personalizado con orientación horizontal (landscape)
        $pdf = new MYPDF('L', PDF_UNIT, 'LEGAL', true, 'UTF-8', false);

        // Configuraciones básicas del PDF
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Confitería MOROCHO');
        $pdf->SetTitle('Lista de Productos');
        $pdf->SetSubject('Reporte de Inventario');
        $pdf->SetMargins(10, 30, 10);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(15);

        // Agregar una página
        $pdf->AddPage();

        // Encabezado de la tabla
        $html = '<h2 style="text-align:center;">Reporte de Planilla</h2>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse; width:100%; font-size:10px;">
    <thead>
        <tr>
            <th style="width:7%; text-align:center; font-weight:bold;">Documento</th>
            <th style="width:9%; text-align:center; font-weight:bold;">Nombre</th>
            <th style="width:13%; text-align:center; font-weight:bold;">Apellidos</th>
            <th style="width:9%; text-align:center; font-weight:bold;">Cargo</th>
            <th style="width:7%; text-align:center; font-weight:bold;">Días Trab.</th>
            <th style="width:8%; text-align:center; font-weight:bold;">Haber Básico</th>
            <th style="width:8%; text-align:center; font-weight:bold;">Horas Extras</th>
            <th style="width:5%; text-align:center; font-weight:bold;">Faltas</th>
            <th style="width:7%; text-align:center; font-weight:bold;">Anticipos</th>
            <th style="width:9%; text-align:center; font-weight:bold;">Total Desc.</th>
            <th style="width:9%; text-align:center; font-weight:bold;">Líquido Pagable</th>
            <th style="width:9%; text-align:center; font-weight:bold;">Firma</th>
        </tr>
    </thead>
    <tbody>';

        // Recorrer los datos de la planilla y agregarlos al PDF
        foreach ($planilla as $fila) {
            $html .= '<tr>
    <td style="width:7%; text-align:center; vertical-align:middle; height:40px;">' . $fila['ci'] . '</td>
    <td style="width:9%; text-align:center; vertical-align:middle; height:40px;">' . $fila['nombre'] . '</td>
    <td style="width:13%; text-align:center; vertical-align:middle; height:40px;">' . $fila['apellidop'] . ' ' . $fila['apellidom'] . '</td>
    <td style="width:9%; text-align:center; vertical-align:middle; height:40px;">' . $fila['nombre_cargo'] . '</td>
    <td style="width:7%; text-align:center; vertical-align:middle; height:40px;">' . $fila['diastrabajados'] . '</td>
    <td style="width:8%; text-align:center; vertical-align:middle; height:40px;">' . number_format($fila['haberbasico'], 2) . ' bs.</td>
    <td style="width:8%; text-align:center; vertical-align:middle; height:40px;">' . number_format($fila['horasextras'], 2) . ' bs.</td>
    <td style="width:5%; text-align:center; vertical-align:middle; height:40px;">' . $fila['faltas'] . '</td>
    <td style="width:7%; text-align:center; vertical-align:middle; height:40px;">' . number_format($fila['anticipos'], 2) . ' bs.</td>
    <td style="width:9%; text-align:center; vertical-align:middle; height:40px;">' . number_format($fila['totaldescuentos'], 2) . ' bs.</td>
    <td style="width:9%; text-align:center; vertical-align:middle; height:40px;">' . number_format($fila['liquidopagable'], 2) . ' bs.</td>
    <td style="width:9%; text-align:center; vertical-align:middle; height:40px;"> </td>
</tr>';
        }

        $html .= '</tbody></table>';


        // Escribir el contenido HTML en el PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Cerrar y enviar el PDF al navegador
        $pdf->Output('planilla_de_pago.pdf', 'I');
    } else {
        echo "No se encontraron datos para la planilla.";
    }
} else {
    echo "Planilla no seleccionada.";
}
