<?php
require_once "../modelos/planilla.modelo.php";
class AjaxPlanilla
{
    //EDITAR Planilla
    public $idPlanilla;
    public function ajaxMostrarPlanilla()
    {
        $idPlanilla = $this->idPlanilla;
        $respuesta = ModeloPlanilla::mdlImprimirPlanilla($idPlanilla);
        echo json_encode($respuesta);
    }
}
//EDITAR Planilla
if (isset($_POST["idPlanilla"])) {
    $Planilla = new AjaxPlanilla();
    $Planilla->idPlanilla = $_POST["idPlanilla"];
    $Planilla->ajaxMostrarPlanilla();
}
