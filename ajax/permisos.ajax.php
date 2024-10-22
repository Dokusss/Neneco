<?php

require_once "../controladores/permisos.controlador.php";
require_once "../modelos/permisos.modelo.php";

class AjaxPermisos{

	/*=============================================
	EDITAR PERMISOS
	=============================================*/	

	public $idPermiso;

	public function ajaxEditarPermisos(){

		$item = "id";
		$valor = $this->idPermiso;

		$respuesta = ControladorPermisos::ctrMostrarPermisos($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR PERMISOS
=============================================*/	
if(isset($_POST["idPermiso"])){

	$permisos = new AjaxPermisos();
	$permisos -> idPermiso = $_POST["idPermiso"];
	$permisos -> ajaxEditarPermisos();
}