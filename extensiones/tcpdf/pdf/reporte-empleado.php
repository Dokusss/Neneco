<?php

require_once "../../../controladores/asistencia.controlador.php";
require_once "../../../modelos/asistencia.modelo.php";
require_once "../examples/tcpdf_include.php";

class ReporteEmpleado
{
	public $idEmpleado;
	public $fechaInicio;
	public $fechaFin;

	public function traerImpresionReporte()
	{
		$idEmpleado = $this->idEmpleado;
		$fechaInicio = $this->fechaInicio;
		$fechaFin = $this->fechaFin;

		// Obtenemos la información de la asistencia
		$respuesta = ControladorAsistencia::ctrMostrarAsistenciaEmpleado($idEmpleado, $fechaInicio, $fechaFin);

		if (empty($respuesta)) {
			die("No se encontraron datos de asistencia para los parámetros proporcionados.");
		}

		$nombre = $respuesta[0]['nombre'];
		$apellidop = $respuesta[0]['apellidop'];
		$apellidom = $respuesta[0]['apellidom'];

		// Crear una instancia de TCPDF
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->startPageGroup();
		$pdf->AddPage();

		// Información del encabezado del reporte
		$bloque1 = <<<EOF
		<table style="width: 100%; margin-bottom: 20px;">
			<tr>
				<td style="width: 60%; vertical-align: top;"><img src="../../../vistas/images/logosNeneco/logoN.png" width="150" height="auto"></td>
				<td style="width: 40%; text-align:right; vertical-align: top;">
					<div style="font-size:10px; line-height:15px;">
						Dirección: Calle 44B 92-11<br>
						Teléfono: 300 786 52 49<br>
						barracaneneco@gmail.com
					</div>
				</td>
			</tr>
		</table>
	EOF;

		$pdf->writeHTML($bloque1, false, false, false, false, '');

		// Título del reporte
		$bloqueTitulo = <<<EOF
		<h1 style="text-align:center; margin-bottom: 20px; color: #747a80;">REPORTE DE ASISTENCIA</h1>
		<br>
	EOF;
		$pdf->writeHTML($bloqueTitulo, false, false, false, false, '');

		// Información del empleado
		$bloqueEmpleado = <<<EOF
		<p style="text-align:center; margin-bottom: 20px;">Empleado/a: $nombre $apellidop $apellidom</p>
	EOF;
		$pdf->writeHTML($bloqueEmpleado, false, false, false, false, '');

		// Fechas
		$bloqueFechas = <<<EOF
		<p style="text-align:center; margin-bottom: 20px;">Fecha desde $fechaInicio hasta $fechaFin</p>
		<br>
	EOF;
		$pdf->writeHTML($bloqueFechas, false, false, false, false, '');

		// Tabla de asistencia
		$bloque3 = <<<EOF
		<table border="1" cellpadding="4" style="font-size:10px; margin-top:20px; border-collapse: collapse;">
			<thead style="background-color: #f2f2f2;">
				<tr style="background-color: #747a80; color: white;">
					<th rowspan="2" style="text-align:center; vertical-align:middle;">Fecha</th>
					<th colspan="2" style="text-align:center;">Mañana</th>
					<th colspan="2" style="text-align:center;">Tarde</th>
					<th rowspan="2" style="text-align:center; vertical-align:middle;">Horas trabajadas</th>
					<th rowspan="2" style="text-align:center; vertical-align:middle;">Extras</th>
				</tr>
				<tr style="background-color: #747a80; color: white;">
					<th style="text-align:center;">Entrada</th>
					<th style="text-align:center;">Salida</th>
					<th style="text-align:center;">Entrada</th>
					<th style="text-align:center;">Salida</th>
				</tr>
			</thead>
			<tbody>
	EOF;

		foreach ($respuesta as $asistencia) {
			$fecha = $asistencia['fecha'];
			$entrada1 = $asistencia['entrada1'];
			$salida1 = $asistencia['salida1'];
			$entrada2 = $asistencia['entrada2'];
			$salida2 = $asistencia['salida2'];
			$horas = $asistencia['horas'];
			$horasExtras = $asistencia['horasextras'];

			$bloque3 .= <<<EOF
				<tr>
					<td style="text-align:center;">$fecha</td>
					<td style="text-align:center;">$entrada1</td>
					<td style="text-align:center;">$salida1</td>
					<td style="text-align:center;">$entrada2</td>
					<td style="text-align:center;">$salida2</td>
					<td style="text-align:center;">$horas</td>
					<td style="text-align:center;">$horasExtras</td>
				</tr>
	EOF;
		}

		$bloque3 .= <<<EOF
			</tbody>
		</table>
	EOF;

		// Imprimir el contenido HTML en el PDF
		$pdf->writeHTML($bloque3, true, false, true, false, '');

		// Cerrar y generar el PDF
		$pdf->Output('reporte_asistencia.pdf', 'I');
	}
}

if (isset($_GET["idEmpleado"]) && isset($_GET["fechaInicio"]) && isset($_GET["fechaFin"])) {
	$ajaxAsistencia = new ReporteEmpleado();
	$ajaxAsistencia->idEmpleado = $_GET["idEmpleado"];
	$ajaxAsistencia->fechaInicio = $_GET["fechaInicio"];
	$ajaxAsistencia->fechaFin = $_GET["fechaFin"];

	$ajaxAsistencia->traerImpresionReporte();
} else {
	echo 'Faltan parámetros.';
}

?>
