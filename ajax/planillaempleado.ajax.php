<?php
require_once "../modelos/planilla.modelo.php";
class AjaxPlanillaEmpleado
{
    //EDITAR Planilla
    public $idEmpleado;
    public function ajaxMostrarPlanillaEmpleado()
    {
        $idEmpleado = $this->idEmpleado;
        $respuesta = ModeloPlanilla::mdlImprimirBoletaDePago($idEmpleado);
        echo json_encode($respuesta);
    }
}
//EDITAR Planilla
if (isset($_POST["idEmpleado"])) {
    $Planilla = new AjaxPlanillaEmpleado();
    $Planilla->idEmpleado = $_POST["idEmpleado"];
    $Planilla->ajaxMostrarPlanillaEmpleado();
}
