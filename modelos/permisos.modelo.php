<?php
require_once "conexion.php";
class ModeloPermisos
{
	//MOSTRAR PERMISOS
	static public function mdlMostrarPermisos($tabla, $item, $valor)
	{
		if ($item != null) {
			//SELECT * FROM usuarios WHERE usuario='admin';
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY fechainicio DESC");
			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fechainicio DESC");
			$stmt->execute();
			return $stmt->fetchAll();
		}
		$stmt->close();
		$stmt = null;
	}
	//OBTENER DIAS DE PERMISOS
	static public function mdlObtenerPermisosEmpleado($idEmpleado, $fechaInicio, $fechaFin)
	{
		$conexion = Conexion::conectar();
		$stmt = $conexion->prepare("SELECT COUNT(*) AS totalDiasPermiso 
                                FROM permisos 
                                WHERE idempleado = :idempleado 
                                AND (
                                    (fechainicio BETWEEN :fechaInicio AND :fechaFin) 
                                    OR (fechafin BETWEEN :fechaInicio AND :fechaFin)
                                    OR (:fechaInicio BETWEEN fechainicio AND fechafin)
                                    OR (:fechaFin BETWEEN fechainicio AND fechafin)
                                )");
		$stmt->bindParam(":idempleado", $idEmpleado, PDO::PARAM_INT);
		$stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
		$stmt->execute();
		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		unset($stmt);

		// Devolver el total de días de permiso, o 0 si no hay registros
		return $resultado['totalDiasPermiso'] ? $resultado['totalDiasPermiso'] : 0;
	}
	//CREAR PERMISO
	static public function mdlCrearPermiso($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idempleado, fechainicio, fechafin, motivo) VALUES (:idempleado, :fechainicio, :fechafin, :motivo)");
		$stmt->bindParam(":idempleado", $datos["idempleado"], PDO::PARAM_INT);
		$stmt->bindParam(":fechainicio", $datos["fechainicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fechafin", $datos["fechafin"], PDO::PARAM_STR);
		$stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	//EDITAR PERMISOS
	static public function mdlEditarPermisos($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fechainicio = :fechainicio, fechafin = :fechafin, motivo = :motivo WHERE id = :id");
		$stmt->bindParam(":fechainicio", $datos["fechainicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fechafin", $datos["fechafin"], PDO::PARAM_STR);
		$stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
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
