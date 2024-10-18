<?php

require_once "../controladores/anticipos.controlador.php";
require_once "../modelos/anticipos.modelo.php";

class AjaxAnticipos{

	/*=============================================
	EDITAR ANTICIPO
	=============================================*/	

	public $idAnticipos;

	public function ajaxEditarAnticipos(){

		$item = "id";
		$valor = $this->idAnticipos;

		$respuesta = ControladorAnticipos::ctrMostrarAnticipos($item, $valor);

		echo json_encode($respuesta);

	}

}

/*=============================================
EDITAR ANTICIPOS
=============================================*/	
if(isset($_POST["idAnticipos"])){

	$anticipos = new AjaxAnticipos();
	$anticipos -> idAnticipos = $_POST["idAnticipos"];
	$anticipos -> ajaxEditarAnticipos();
}

