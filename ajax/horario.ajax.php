<?php

require_once "../controladores/horario.controlador.php";
require_once "../modelos/horario.modelo.php";

class AjaxHorario{

	/*=============================================
	EDITAR HORARIO
	=============================================*/	

	public $id;

	public function ajaxEditarHorario(){

		$item = "id";
		$valor = $this->id;

		$respuesta = ControladorHorario::ctrMostrarHorario($item, $valor);

		echo json_encode($respuesta);


	}

}

/*=============================================
EDITAR HORARIO
=============================================*/	

if(isset($_POST["id"])){

	$horario = new AjaxHorario();
	$horario -> id = $_POST["id"];
	$horario -> ajaxEditarHorario();

}