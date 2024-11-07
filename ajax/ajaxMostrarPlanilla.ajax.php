<?php

require_once "../controladores/planilla.controlador.php";
require_once "../modelos/planilla.modelo.php";

class AjaxMostrarPlanilla{

	/*=============================================
	EDITAR USUARIO
	=============================================*/	

	public $id;

	public function ajaxEditarPlanilla(){

		$item = "id";
		$valor = $this->id;

		$respuesta = ControladorPlanilla::ctrMostrarPlanilla($item, $valor);

		echo json_encode($respuesta);

	}

}

/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["id"])){

	$editar = new ajaxMostrarPlanilla();
	$editar -> id = $_POST["id"];
	$editar -> ajaxEditarPlanilla();

}
