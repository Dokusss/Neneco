<?php

require_once "../controladores/horas.controlador.php";
require_once "../modelos/horas.modelo.php";

class AjaxHoras{

	//EDITAR HORAS EXTRAS
	public $idHoraExtra;
	public function ajaxEditarHoras(){
		$item = "id";
		$valor = $this->idHoraExtra;
		$respuesta = ControladorHoras::ctrMostrarHoras($item, $valor);
		echo json_encode($respuesta);
	}
}

//EDITAR HORAS EXTRAS
if(isset($_POST["idHoraExtra"])){
	$Horas = new AjaxHoras();
	$Horas -> idHoraExtra = $_POST["idHoraExtra"];
	$Horas -> ajaxEditarHoras();
}

