<?php

require_once "conexion.php";

class ModeloHorario
{

	/*=============================================
	MOSTRAR HORARIO
	=============================================*/

	static public function mdlMostrarHorario($tabla, $item, $valor)
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
	CREAR HORARIO
	=============================================*/

	static public function mdlIngresarHorario($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(horainiciom, horasalidam, horainiciot, horasalidat, estado) VALUES (:horainiciom, :horasalidam, :horainiciot, :horasalidat, :estado)");

		$stmt->bindParam(":horainiciom", $datos["horainiciom"], PDO::PARAM_STR);
		$stmt->bindParam(":horasalidam", $datos["horasalidam"], PDO::PARAM_STR);
		$stmt->bindParam(":horainiciot", $datos["horainiciot"], PDO::PARAM_STR);
		$stmt->bindParam(":horasalidat", $datos["horasalidat"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	EDITAR HORARIO
	=============================================*/

	static public function mdlEditarHorario($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET horainiciom = :horainiciom, horasalidam = :horasalidam, horainiciot = :horainiciot, horasalidat = :horasalidat WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":horainiciom", $datos["horainiciom"], PDO::PARAM_STR);
		$stmt->bindParam(":horasalidam", $datos["horasalidam"], PDO::PARAM_STR);
		$stmt->bindParam(":horainiciot", $datos["horainiciot"], PDO::PARAM_STR);
		$stmt->bindParam(":horasalidat", $datos["horasalidat"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	ELIMINAR HORARIO
	=============================================*/

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
