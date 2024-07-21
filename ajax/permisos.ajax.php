<?php

require_once "../controladores/permisos.controlador.php";
require_once "../modelos/permisos.modelo.php";

class AjaxPermisos{

	/*=============================================
	EDITAR PERMISOS
	=============================================*/	

	public $id;

	public function ajaxEditarPermisos(){

		$item = "id";
		$valor = $this->id;

		$respuesta = ControladorPermisos::ctrMostrarPermisos($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR PERMISOS
=============================================*/	
if(isset($_POST["id"])){

	$permisos = new AjaxPermisos();
	$permisos -> id = $_POST["id"];
	$permisos -> ajaxEditarPermisos();
}