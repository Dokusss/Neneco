<?php

require_once "../controladores/horas.controlador.php";
require_once "../modelos/horas.modelo.php";

class AjaxHoras{

	/*=============================================
	EDITAR HORAS EXTRAS
	=============================================*/	

	public $id;

	public function ajaxEditarHoras(){

		$item = "id";
		$valor = $this->id;

		$respuesta = ControladorHoras::ctrMostrarHoras($item, $valor);

		echo json_encode($respuesta);

	}

}

/*=============================================
EDITAR HORAS EXTRAS
=============================================*/	
if(isset($_POST["id"])){

	$Horas = new AjaxHoras();
	$Horas -> id = $_POST["id"];
	$Horas -> ajaxEditarHoras();
}

