<?php
require_once "../modelos/asistencia.modelo.php";
class AjaxReportesAsistencias
{
    public $fechaInicio;
    public $fechaFin;
    public $idEmpleado;
    public $tipo;
    public function ajaxEnviarDatos()
    {
        $fechaInicio = $this->fechaInicio;
        $fechaFin = $this->fechaFin;
        $idEmpleado = $this->idEmpleado;
        $tipo = $this->tipo;
        $respuesta = ModeloAsistencia::mdlImprimirReporteAsistencias($fechaInicio, $fechaFin, $idEmpleado, $tipo);
    }
}
// Validar si los datos han sido enviados por POST
if (isset($_POST["fechaInicio"]) && isset($_POST["fechaFin"]) && isset($_POST["idEmpleado"]) && isset($_POST["tipo"])) {
    $reporte = new AjaxReportesAsistencias();
    $reporte->fechaInicio = $_POST["fechaInicio"];
    $reporte->fechaFin = $_POST["fechaFin"];
    $reporte->idEmpleado = $_POST["idEmpleado"];
    $reporte->tipo = $_POST["tipo"];
    $reporte->ajaxEnviarDatos();
}

