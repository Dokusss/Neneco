<?php
require_once "../modelos/planilla.modelo.php";
require_once "../modelos/usuarios.modelo.php";
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
    /*=============================================
	ACTIVAR USUARIO
	=============================================*/	

	public $estadoPlanilla;
	public $activar;


	public function ajaxEstadoPlanilla(){

		$tabla = "planillas";

		$item1 = "estado";
		$valor1 = $this->estadoPlanilla;

		$item2 = "id";
		$valor2 = $this->activar;

		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

	}
}
//EDITAR Planilla
if (isset($_POST["idPlanilla"])) {
    $Planilla = new AjaxPlanilla();
    $Planilla->idPlanilla = $_POST["idPlanilla"];
    $Planilla->ajaxMostrarPlanilla();
}
/*=============================================
ACTIVAR USUARIO
=============================================*/	

if(isset($_POST["estadoPlanilla"])){

	$estadoPlanilla = new AjaxPlanilla();
	$estadoPlanilla -> estadoPlanilla = $_POST["estadoPlanilla"];
	$estadoPlanilla -> activar = $_POST["activar"];
	$estadoPlanilla -> ajaxEstadoPlanilla();

}
