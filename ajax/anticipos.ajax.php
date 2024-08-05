<?php

require_once "../controladores/anticipos.controlador.php";
require_once "../modelos/anticipos.modelo.php";

class AjaxAnticipos{

	/*=============================================
	EDITAR ANTICIPO
	=============================================*/	

	public $id;

	public function ajaxEditarAnticipos(){

		$item = "id";
		$valor = $this->id;

		$respuesta = ControladorAnticipos::ctrMostrarAnticipos($item, $valor);

		echo json_encode($respuesta);

	}

}

/*=============================================
EDITAR ANTICIPOS
=============================================*/	
if(isset($_POST["id"])){

	$anticipos = new AjaxAnticipos();
	$anticipos -> id = $_POST["id"];
	$anticipos -> ajaxEditarAnticipos();
}

