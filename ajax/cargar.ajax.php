<?php
require_once "../controladores/asistencia.controlador.php";
require_once "../modelos/asistencia.modelo.php";
require_once "../vendor/autoload.php";
class AjaxAsistencia
{
    public $nuevoArchivo;
    public function ajaxCargarDatos()
    {
        $respuesta = ControladorAsistencia::ctrCargarDatos($this->nuevoArchivo);
        echo json_encode($respuesta);
    }
}
if (isset($_FILES)) {
    $archivo = new AjaxAsistencia();
    $archivo->nuevoArchivo = $_FILES["nuevoArchivo"];
    $archivo->ajaxCargarDatos();
}