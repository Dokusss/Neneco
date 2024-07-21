<?php

class ControladorAsistencia
{


    /*=============================================
	MOSTRAR TODAS LAS ASISTENCIAS
	=============================================*/

	static public function ctrMostrarTodasLasAsistencias($item, $valor)
	{

		$tabla = "asistencia";

		$respuesta = ModeloAsistencia::MdlMostrarTodasLasAsistencias($tabla, $item, $valor);

		return $respuesta;
	}

    /*=============================================
	MOSTRAR ASISTENCIA
	=============================================*/

    static public function ctrMostrarAsistencia($id, $fechaInicio, $fechaFin)
    {
        if (isset($_POST["idEmpleado"])) {

            $tabla = "asistencia";

            $respuesta = ModeloAsistencia::MdlMostrarAsistencia($tabla, $fechaInicio, $fechaFin, $id);

            return $respuesta;

        }
    }

     /*=============================================
    MOSTRAR ASISTENCIA EMPLEADO
    =============================================*/
    static public function ctrMostrarAsistenciaEmpleado($id, $fechaInicio, $fechaFin) {
        if (!empty($id) && !empty($fechaInicio) && !empty($fechaFin)) {
            $tabla = "asistencia";
            $respuesta = ModeloAsistencia::MdlMostrarAsistencia($tabla, $fechaInicio, $fechaFin, $id);
            // Debug: Verificar la respuesta del modelo
            //var_dump($respuesta);
            return $respuesta;
        }
        return [];
    }

    /*=============================================
	SUBIR ARCHIVO
	=============================================*/

    static public function ctrCargarDatos($nuevoArchivo)
    {

        $respuesta = ModeloAsistencia::mdlCargarDatos($nuevoArchivo);

        return $respuesta;
    }
}
