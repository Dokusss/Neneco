<?php

require_once "../controladores/asistencia.controlador.php";
require_once "../modelos/asistencia.modelo.php";

class AjaxAsistencia
{

    public $idEmpleado;
    public $fechaInicio;
    public $fechaFin;

    public function ajaxMostrarAsistencia()
    {
        $respuesta = ModeloAsistencia::MdlMostrarAsistenciaDeEmpleado($this->idEmpleado, $this->fechaInicio, $this->fechaFin);
        echo json_encode($respuesta);
    }

}

// Comprueba si se ha enviado el ID del empleado
if (isset($_POST["idEmpleado"])) {
    $ajaxAsistencia = new AjaxAsistencia();
    $ajaxAsistencia->idEmpleado = $_POST["idEmpleado"];
    $ajaxAsistencia->fechaInicio = $_POST["fechaInicio"];
    $ajaxAsistencia->fechaFin = $_POST["fechaFin"];
    $ajaxAsistencia->ajaxMostrarAsistencia();
}
