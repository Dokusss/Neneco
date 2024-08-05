<?php

require_once "conexion.php";

class ModeloPermisos
{

	/*=============================================
	MOSTRAR PERMISOS
	=============================================*/

	static public function mdlMostrarPermisos($tabla, $item, $valor)
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

	static public function mdlCrearPermiso($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idempleado, fechainicio, fechafin, categoria, motivo) VALUES (:idempleado, :fechainicio, :fechafin, :categoria, :motivo)");

		$stmt->bindParam(":idempleado", $datos["idempleado"], PDO::PARAM_INT);
		$stmt->bindParam(":fechainicio", $datos["fechainicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fechafin", $datos["fechafin"], PDO::PARAM_STR);
		$stmt->bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
		$stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	EDITAR PERMISOS
	=============================================*/

	static public function mdlEditarPermisos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fechainicio = :fechainicio, fechafin = :fechafin, categoria = :categoria, motivo = :motivo WHERE id = :id");

		$stmt -> bindParam(":fechainicio", $datos["fechainicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fechafin", $datos["fechafin"], PDO::PARAM_STR);
		$stmt -> bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
		$stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR PERMISOS
	=============================================*/

	static public function mdlBorrarPermisos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}
}
