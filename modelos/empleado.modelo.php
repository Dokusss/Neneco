<?php
require_once "conexion.php";
class ModeloEmpleado
{
	//MOSTRAR EMPLEADOS ACTIVOS
	public static function mdlMostrarEmpleadosActivos()
	{
		$stmt = Conexion::conectar()->prepare(
			"SELECT *
				   FROM empleados
				   WHERE estado = 1
				   ORDER BY nombre ASC"
		);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->close();
		$stmt = null;
	}
	//MOSTRAR ID EMPLEADOS ACTIVOS
	public static function mdlMostrarIdEmpleadosActivos()
	{
		$stmt = Conexion::conectar()->prepare(
			"SELECT id
				   FROM empleados
				   WHERE estado = 1
				   ORDER BY nombre ASC"
		);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->close();
		$stmt = null;
	}
	//MOSTRAR TODOS LOS EMPLEADOS
	static public function mdlMostrarEmpleado($tabla, $item, $valor)
	{
		if ($item != null) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY estado DESC, nombre ASC");
			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY estado DESC, nombre ASC");
			$stmt->execute();
			return $stmt->fetchAll();
		}
		$stmt->close();
		$stmt = null;
	}
	//OBTENER SALARIO DEL EMPLEADO
	static public function mdlObtenerSalarioEmpleado($idEmpleado)
	{
		$conexion = Conexion::conectar();
		$stmt = $conexion->prepare("SELECT sueldo FROM empleados WHERE id = :idempleado");
		$stmt->bindParam(":idempleado", $idEmpleado, PDO::PARAM_INT);
		$stmt->execute();
		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
		return $resultado['sueldo'];
	}
	//REGISTRAR EMPLEADO
	static public function mdlCrearEmpleado($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idcargo, idhorario, id, ci, nombre, apellidop, apellidom, genero, direccion, telefono, fechanac, fechareg, estado, sueldo ) VALUES (:idcargo, :idhorario, :id, :ci, :nombre, :apellidop, :apellidom, :genero, :direccion, :telefono, :fechanac, :fechareg, :estado, :sueldo)");
		$stmt->bindParam(":idcargo", $datos["idcargo"], PDO::PARAM_INT);
		$stmt->bindParam(":idhorario", $datos["idhorario"], PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_STR);
		$stmt->bindParam(":ci", $datos["ci"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellidop", $datos["apellidop"], PDO::PARAM_STR);
		$stmt->bindParam(":apellidom", $datos["apellidom"], PDO::PARAM_STR);
		$stmt->bindParam(":genero", $datos["genero"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":fechanac", $datos["fechanac"], PDO::PARAM_STR);
		$stmt->bindParam(":fechareg", $datos["fechareg"], PDO::PARAM_STR);
		$stmt->bindParam(":sueldo", $datos["sueldo"], PDO::PARAM_STR);
		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	//EDITAR EMPLEADO
	static public function mdlEditarEmpleado($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idcargo = :idcargo, idhorario = :idhorario, ci = :ci, nombre = :nombre, apellidop = :apellidop, apellidom = :apellidom, genero = :genero, direccion = :direccion, telefono = :telefono, fechanac = :fechanac, sueldo = :sueldo WHERE id = :id");
		$stmt->bindParam(":idcargo", $datos["idcargo"], PDO::PARAM_INT);
		$stmt->bindParam(":idhorario", $datos["idhorario"], PDO::PARAM_INT);
		$stmt->bindParam(":ci", $datos["ci"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellidop", $datos["apellidop"], PDO::PARAM_STR);
		$stmt->bindParam(":apellidom", $datos["apellidom"], PDO::PARAM_STR);
		$stmt->bindParam(":genero", $datos["genero"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":fechanac", $datos["fechanac"], PDO::PARAM_STR);
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
	//ACTUALIZAR EMPLEADO
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

	//MOSTRAR HORARIO DE LOS EMPLEADOS
	static public function mdlMostrarHorarioEmpleado($idEmpleado)
	{
		$stmt = Conexion::conectar()->prepare("SELECT h.entrada1, h.salida1, h.entrada2, h.salida2
				FROM empleados e
				JOIN horarios h ON e.idhorario = h.id
				WHERE e.id = :idEmpleado");
		$stmt->bindParam(":idEmpleado", $idEmpleado, PDO::PARAM_INT);
		$stmt->execute();
		$resultado = $stmt->fetch();
		$stmt = null;
		return $resultado;
	}
}
