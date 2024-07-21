<?php

require_once "conexion.php";

class ModeloCargo
{

	/*=============================================
	MOSTRAR CARGO
	=============================================*/

	static public function mdlMostrarCargo($tabla, $item, $valor)
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
	CREAR CARGO
	=============================================*/

	static public function mdlIngresarCargo($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, sueldo) VALUES (:nombre, :sueldo)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":sueldo", $datos["sueldo"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	EDITAR CARGO
	=============================================*/

	static public function mdlEditarCargo($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, sueldo = :sueldo WHERE id = :id");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":sueldo", $datos["sueldo"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	BORRAR CARGO
=============================================*/

	static public function mdlBorrarCargo($tabla, $datos)
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
				return "No se puede borrar el cargo porque está asociado a uno o más empleados. Debe reasignar o eliminar esos empleados antes de borrar el cargo.";
			} else {
				return "error: " . $e->getMessage();
			}
		} finally {
			$stmt = null;
		}
	}
}
