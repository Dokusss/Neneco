<?php

require_once "../controladores/horas.controlador.php";
require_once "../modelos/horas.modelo.php";

class AjaxDetalleHoras{

	//EDITAR HORAS EXTRAS
	public $idHorasExtras;
	public function ajaxEditarDetalleHoras(){
		$item = "idhorasextras";
		$valor = $this->idHorasExtras;
		$respuesta = ControladorHoras::ctrMostrarDetalleHoras($item, $valor);
		echo json_encode($respuesta);
	}
}

//EDITAR HORAS EXTRAS
if(isset($_POST["idHorasExtras"])){
	$Horas = new AjaxDetalleHoras();
	$Horas -> idHorasExtras = $_POST["idHorasExtras"];
	$Horas -> ajaxEditarDetalleHoras();
}

