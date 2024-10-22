<?php
require_once "conexion.php";
class ModeloHorario
{
	//MOSTRAR HORARIOS
	static public function mdlMostrarHorario($tabla, $item, $valor)
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
	//CREAR HORARIO
	static public function mdlIngresarHorario($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(entrada1, salida1, entrada2, salida2, fecha) VALUES (:entrada1, :salida1, :entrada2, :salida2, :fecha)");
		$stmt->bindParam(":entrada1", $datos["entrada1"], PDO::PARAM_STR);
		$stmt->bindParam(":salida1", $datos["salida1"], PDO::PARAM_STR);
		$stmt->bindParam(":entrada2", $datos["entrada2"], PDO::PARAM_STR);
		$stmt->bindParam(":salida2", $datos["salida2"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	//EDITAR HORARIO
	static public function mdlEditarHorario($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET entrada1 = :entrada1, salida1 = :salida1, entrada2 = :entrada2, salida2 = :salida2, fecha = :fecha WHERE id = :id");
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":entrada1", $datos["entrada1"], PDO::PARAM_STR);
		$stmt->bindParam(":salida1", $datos["salida1"], PDO::PARAM_STR);
		$stmt->bindParam(":entrada2", $datos["entrada2"], PDO::PARAM_STR);
		$stmt->bindParam(":salida2", $datos["salida2"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	//ELIMINAR HORARIO
	static public function mdlEliminarHorario($tabla, $datos)
	{
		try {
			$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
			$stmt->bindParam(":id", $datos, PDO::PARAM_INT);
			if ($stmt->execute()) {
				return "ok";
			} else {
				return "error";
			}
		} catch (PDOException $e) {
			if ($e->getCode() == '23000') {
				// Código de error específico para violación de integridad referencial
				return "No se puede borrar el horario porque está asociado a uno o más empleados. Debe reasignar o eliminar esos empleados antes de borrar el horario.";
			} else {
				return "error: " . $e->getMessage();
			}
		} finally {
			$stmt = null;
		}
	}
}
