<?php

require_once "conexion.php";

class ModeloEmpleado
{

	/*=============================================
				MOSTRAR TODOS LOS EMPLEADOS
				=============================================*/

	static public function mdlMostrarEmpleado($tabla, $item, $valor)
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
				MOSTRAR EMPLEADOS ORDENADOS Y CON ESTADO EN 1
				=============================================*/

	static public function mdlMostrarEmpleadoOrdenado($tabla, $item = null, $valor = null)
	{
		if ($item !== null) {
			// Si se proporciona un ítem y un valor, se agrega una condición WHERE a la consulta SQL
			$sql = "SELECT * FROM $tabla WHERE $item = :$item ORDER BY estado DESC, nombre ASC";
			$stmt = Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
		} else {
			// Si no se proporciona un ítem y un valor, se seleccionan todos los registros y se ordenan por estado y nombre
			$sql = "SELECT * FROM $tabla ORDER BY estado DESC, nombre ASC";
			$stmt = Conexion::conectar()->prepare($sql);
		}

		$stmt->execute();

		$result = $stmt->fetchAll();

		$stmt->closeCursor(); // Close cursor instead of stmt

		return $result;
	}


	/*=============================================
				REGISTRAR EMPLEADO
				=============================================*/
	static public function mdlCrearEmpleado($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idcargo, idhorario, ci, nombre, apellido1, apellido2, sexo, direccion, telefono, fechanac, fechareg, estado ) VALUES (:idcargo, :idhorario, :ci, :nombre, :apellido1, :apellido2, :sexo, :direccion, :telefono, :fechanac, :fechareg, :estado)");

		$stmt->bindParam(":idcargo", $datos["idcargo"], PDO::PARAM_INT);
		$stmt->bindParam(":idhorario", $datos["idhorario"], PDO::PARAM_INT);
		$stmt->bindParam(":ci", $datos["ci"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido1", $datos["apellido1"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido2", $datos["apellido2"], PDO::PARAM_STR);
		$stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":fechanac", $datos["fechanac"], PDO::PARAM_STR);
		$stmt->bindParam(":fechareg", $datos["fechareg"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
				EDITAR EMPLEADO
				=============================================*/

	static public function mdlEditarEmpleado($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idcargo = :idcargo, idhorario = :idhorario, ci = :ci, nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, sexo = :sexo, direccion = :direccion, telefono = :telefono, fechanac = :fechanac WHERE id = :id");

		$stmt->bindParam(":idcargo", $datos["idcargo"], PDO::PARAM_INT);
		$stmt->bindParam(":idhorario", $datos["idhorario"], PDO::PARAM_INT);
		$stmt->bindParam(":ci", $datos["ci"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido1", $datos["apellido1"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido2", $datos["apellido2"], PDO::PARAM_STR);
		$stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":fechanac", $datos["fechanac"], PDO::PARAM_STR);
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
			 ELIMINAR EMPLEADO
			 =============================================*/

	static public function mdlBorrarEmpleado($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado  WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
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
				ACTUALIZAR EMPLEADO
				=============================================*/

	static public function mdlActualizarEmpleado($tabla, $item1, $valor1, $item2, $valor2)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";

		} else {

			return "error";

		}

		$stmt->close();

		$stmt = null;

	}

}
