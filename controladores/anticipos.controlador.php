<?php

class ControladorAnticipos
{


	/*=============================================
		  MOSTRAR ANTICIPOS
	   =============================================*/

	static public function ctrMostrarAnticipos($item, $valor)
	{

		$tabla = "anticipos";

		$respuesta = ModeloAnticipos::MdlMostrarAnticipos($tabla, $item, $valor);

		return $respuesta;
	}
}