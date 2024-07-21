<?php

require_once "../controladores/cargo.controlador.php";
require_once "../modelos/cargo.modelo.php";

class AjaxCargo{

	/*=============================================
	EDITAR CARGO
	=============================================*/	

	public $id;

	public function ajaxEditarCargo(){

		$item = "id";
		$valor = $this->id;

		$respuesta = ControladorCargo::ctrMostrarCargo($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	VALIDAR NO REPETIR NOMBRE
	=============================================*/	

	public $nombre;

	public function ajaxValidarNombre(){

		$item = "nombre";
		$valor = $this->nombre;

		$respuesta = ControladorCargo::ctrMostrarCargo($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR CARGO
=============================================*/	
if(isset($_POST["id"])){

	$cargo = new AjaxCargo();
	$cargo -> id = $_POST["id"];
	$cargo -> ajaxEditarCargo();
}

/*=============================================
VALIDAR NO REPETIR NOMBRE
=============================================*/

if(isset( $_POST["nombre"])){

	$valNombre = new AjaxCargo();
	$valNombre -> nombre = $_POST["nombre"];
	$valNombre -> ajaxValidarNombre();

}
