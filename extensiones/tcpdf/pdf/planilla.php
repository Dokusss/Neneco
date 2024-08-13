<?php

require_once "../../../modelos/planilla.modelo.php";
require_once "../../../controladores/empleado.controlador.php";
require_once "../../../modelos/empleado.modelo.php";
require_once "../../../controladores/cargo.controlador.php";
require_once "../../../modelos/cargo.modelo.php";
require_once "../../../controladores/planilla.controlador.php";
require_once "../examples/tcpdf_include.php";

class ReportePlanilla
{
	public $id;

	public function traerImpresionPlanilla()
	{
		$idItem = "idplanilla";
		$idValor = $this->id;

		// Obtenemos la información de la planilla
		$respuesta = ModeloPlanilla::mdlMostrarDetallePlanillaEmpleado($idItem, $idValor);

		if (empty($respuesta) || !is_array($respuesta)) {
			die("No se encontraron datos de planilla para los parámetros proporcionados.");
		}

		// Obtener la fecha de la tabla planilla usando el idplanilla
		$planilla = ControladorPlanilla::ctrMostrarPlanilla('id', $idValor);

		if (!$planilla) {
			die("No se encontró la planilla con el ID proporcionado.");
		}

		$fechaPlanilla = date('d/m/Y', strtotime($planilla['fecha']));

		// Crear una instancia de TCPDF con orientación horizontal (L)
		$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->startPageGroup();
		$pdf->AddPage();

		// Estilos CSS para el PDF con tamaño de fuente incrementado
		$css = '
        <style>
            h1 {
                text-align: center;
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 5px;
            }
            h2 {
                text-align: center;
                font-size: 14px;
                margin-bottom: 20px;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                font-size: 10px;
            }
            th {
                background-color: #627d72;
                color: white;
                font-weight: bold;
                text-align: center;
                padding: 6px;
            }
            td {
                border: 1px solid #ddd;
                padding: 6px;
                text-align: center;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            tr:hover {
                background-color: #ddd;
            }
        </style>
    ';

		// Crear contenido HTML para mostrar en el PDF
		$html = $css;
		$html .= '<h1>Planilla de Pago</h1>';
		$html .= '<h2>Fecha: ' . $fechaPlanilla . '</h2>';
		$html .= '<table border="1" cellspacing="0" cellpadding="4">';

		// Mapeo de los encabezados personalizados
		$columnHeaders = [
			"diastrabajados" => "Dias trabajados",
			"haberbasico" => "Haber basico",
			"horasextras" => "Horas extras",
			"afp" => "Aportes AFP",
			"faltas" => "Faltas",
			"anticipos" => "Anticipos",
			"totaldescuentos" => "Total Descuentos",
			"liquidopagable" => "Liquido pagable"
		];

		// Definir el encabezado de la tabla
		$headerHtml = '<tr>';
		$headerHtml .= '<th>Código</th><th>Empleado</th><th>Cargo</th>'; // Nuevas columnas al inicio
		foreach ($respuesta[0] as $column => $value) {
			if ($column != "idempleado" && $column != "idplanilla") {
				$header = isset($columnHeaders[$column]) ? $columnHeaders[$column] : ucfirst($column);
				$headerHtml .= '<th>' . $header . '</th>';
			}
		}
		$headerHtml .= '<th>Firma</th>';
		$headerHtml .= '</tr>';

		$html .= $headerHtml;

		// Generar las filas de valores
		foreach ($respuesta as $row) {
			$html .= '<tr>';

			// Obtener los datos del empleado
			$empleado = ControladorEmpleado::ctrMostrarEmpleado("id", $row['idempleado']);
			if (!$empleado) {
				$empleado = ['id' => '', 'nombre' => '', 'apellidop' => '', 'apellidom' => '', 'idcargo' => ''];
			}

			// Obtener el nombre del cargo
			$cargo = ControladorCargo::ctrMostrarCargo("id", $empleado['idcargo']);
			$nombreCargo = $cargo ? $cargo['nombre'] : '';

			// Añadir las columnas de "Código", "Empleado" y "Cargo" al inicio de cada fila
			$html .= '<td>' . $empleado['id'] . '</td>';
			$html .= '<td>' . $empleado['nombre'] . ' ' . $empleado['apellidop'] . ' ' . (!empty($empleado['apellidom']) ? $empleado['apellidom'] : '') . '</td>';
			$html .= '<td>' . $nombreCargo . '</td>';

			// Mostrar los valores de cada columna, excluyendo idempleado y idplanilla
			foreach ($row as $column => $value) {
				if ($column != "idempleado" && $column != "idplanilla") {
					// Añadir "Bs. " antes de ciertos campos
					if (in_array($column, ['haberbasico', 'horasextras', 'afp', 'anticipos', 'totaldescuentos', 'liquidopagable'])) {
						$value = "Bs. " . number_format($value, 2);
					}
					$html .= '<td>' . $value . '</td>';
				}
			}

			$html .= '<td></td>'; // Columna de "Firma"
			$html .= '</tr>';

			// Verificar si se necesita una nueva página
			if ($pdf->getY() > 180) {
				$html .= '</table>';
				$pdf->writeHTML($html, true, false, true, false, '');
				$pdf->AddPage();
				$html = $css . '<table border="1" cellspacing="0" cellpadding="4">' . $headerHtml;
			}
		}

		$html .= '</table>';

		// Sumar el total de "liquidopagable"
		$totalLiquidoPagable = array_sum(array_column($respuesta, 'liquidopagable'));

		// Mostrar el total
		$html .= '<h2>Total: Bs. ' . number_format($totalLiquidoPagable, 2) . '</h2>';

		// Escribir el contenido HTML en el PDF
		$pdf->writeHTML($html, true, false, true, false, '');

		// Cerrar y generar el PDF
		$pdf->Output('reporte_planilla.pdf', 'D');
	}



}

$planilla = new ReportePlanilla();
$planilla->id = $_GET["id"];
$planilla->traerImpresionPlanilla();
