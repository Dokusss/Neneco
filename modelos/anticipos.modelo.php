<?php

require_once "conexion.php";

class ModeloAnticipos
{
	//MOSTRAR ANTICIPOS
	static public function MdlMostrarAnticipos($tabla, $item, $valor)
	{
		if ($item != null) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY fecha DESC");
			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC");
			$stmt->execute();
			return $stmt->fetchAll();
		}
		$stmt->close();
		$stmt = null;
	}
	//OBTENER ANTICIPOS
	static public function mdlObtenerAnticiposEmpleado($idEmpleado, $fechaInicio, $fechaFin)
	{
		$conexion = Conexion::conectar();
		$stmt = $conexion->prepare("SELECT SUM(monto) AS totalAnticipos FROM anticipos WHERE idempleado = :idempleado AND fecha BETWEEN :fechaInicio AND :fechaFin");
		$stmt->bindParam(":idempleado", $idEmpleado, PDO::PARAM_INT);
		$stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
		$stmt->execute();
		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		unset($stmt);
		return $resultado['totalAnticipos'] ? $resultado['totalAnticipos'] : 0;
	}
	//CREAR ANTICIPOS
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
	//EDITAR ANTICIPOS
	static public function mdlEditarAnticipos($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET monto = :monto WHERE id = :id");
		$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

}
