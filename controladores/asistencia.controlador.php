<?php
class ControladorAsistencia
{
    //MOSTRAR TODAS LAS ASISTENCIAS
    static public function ctrMostrarTodasLasAsistencias($item, $valor)
    {
        $tabla = "asistencias";
        $respuesta = ModeloAsistencia::MdlMostrarTodasLasAsistencias($tabla, $item, $valor);
        return $respuesta;
    }
    //SUBIR ARCHIVO
    static public function ctrCargarDatos($nuevoArchivo)
    {
        $respuesta = ModeloAsistencia::mdlCargarDatos($nuevoArchivo);
        return $respuesta;
    }
    //RANGO DE FECHAS
    static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal)
	{
		$tabla = "asistencias";
		$respuesta = ModeloAsistencia::mdlRangoFechasAsistencias($tabla, $fechaInicial, $fechaFinal);
		return $respuesta;
	}
}
