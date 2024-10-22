<?php
require_once "../controladores/horario.controlador.php";
require_once "../modelos/horario.modelo.php";
class AjaxHorario{
	//EDITAR HORARIO
	public $idHorario;
	public function ajaxEditarHorario(){
		$item = "id";
		$valor = $this->idHorario;
		$respuesta = ControladorHorario::ctrMostrarHorario($item, $valor);
		echo json_encode($respuesta);
	}
}
//EDITAR HORARIO	
if(isset($_POST["idHorario"])){
	$horario = new AjaxHorario();
	$horario -> idHorario = $_POST["idHorario"];
	$horario -> ajaxEditarHorario();
}