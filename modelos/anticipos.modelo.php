<?php

require_once "conexion.php";

class ModeloAnticipos
{

	/*=============================================
		  MOSTRAR CARGO
		  =============================================*/

	static public function MdlMostrarAnticipos($tabla, $item, $valor)
	{

		if ($item != null) {
			//SELECT * FROM usuarios WHERE usuario='admin';
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt->execute();

			return $stmt->fetchAll();
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
		  CREAR PERMISO
		  =============================================*/

	static public function mdlCrearAnticipos($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idempleado, fecha, monto) VALUES (:idempleado, :fecha, :monto)");

		$stmt->bindParam(":idempleado", $datos["idempleado"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	public static function mdlCalcularAnticipos($idEmpleado, $fechaInicio, $fechaFin)
	{
		$stmt = Conexion::conectar()->prepare("
            SELECT SUM(monto) as totalAnticipos
            FROM anticipos 
            WHERE idempleado = :idEmpleado 
            AND fecha BETWEEN :fechaInicio AND :fechaFin
        ");

		$stmt->bindParam(":idEmpleado", $idEmpleado, PDO::PARAM_INT);
		$stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);

		$stmt->execute();

		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($resultado && $resultado['totalAnticipos']) {
			return $resultado['totalAnticipos'];
		} else {
			return 0; // Si no hay anticipos
		}
	}

}
