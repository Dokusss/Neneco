<?php

require_once "conexion.php";

class ModeloHoras
{

	/*=============================================
					  MOSTRAR HORAS EXTRAS
					  =============================================*/

	static public function mdlMostrarHoras($tabla, $item, $valor)
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
					  MOSTRAR DETALLE HORAS EXTRAS
					  =============================================*/

	public static function mdlMostrarDetalleHoras($tabla, $item, $valor)
	{
		$stmt = Conexion::conectar()->prepare("SELECT he.id AS idhorasextras, he.fecha, he.tipo, he.idhorario,
                                            GROUP_CONCAT(CONCAT(e.nombre, ' ', e.apellidop, ' ', e.apellidom) SEPARATOR ', ') AS empleados
                                            FROM $tabla he
                                            JOIN detallehoraempleado dhe ON he.id = dhe.idhorasextras
                                            JOIN empleado e ON dhe.idempleado = e.id
                                            GROUP BY he.id");

		$stmt->execute();
		return $stmt->fetchAll();
	}

	/*=============================================
			   REGISTRAR HORAS EXTRAS
			   =============================================*/

	static public function mdlIngresarHoras($tabla, $datos)
	{
		try {
			// Iniciar una transacción
			$conn = Conexion::conectar();
			$conn->beginTransaction();

			// Preparar la consulta para insertar en la tabla horasextras
			$stmt = $conn->prepare("INSERT INTO $tabla (fecha, idhorario, tipo) VALUES (:fecha, :idhorario, :tipo)");

			// Enlazar los parámetros
			$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
			$stmt->bindParam(":idhorario", $datos["idhorario"], PDO::PARAM_INT);
			$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);

			// Ejecutar la consulta
			if ($stmt->execute()) {
				// Obtener el ID de la última inserción
				$idHorasExtras = $conn->lastInsertId();

				// Iterar sobre el array de empleados
				foreach ($datos["empleados"] as $empleado) {
					// Preparar la consulta para insertar en la tabla detallehoraempleado
					$stmtDetalle = $conn->prepare("INSERT INTO detallehoraempleado (idhorasextras, idempleado) VALUES (:idhorasextras, :idempleado)");

					// Enlazar los parámetros
					$stmtDetalle->bindParam(":idhorasextras", $idHorasExtras, PDO::PARAM_INT);
					$stmtDetalle->bindParam(":idempleado", $empleado, PDO::PARAM_INT);

					// Ejecutar la consulta
					$stmtDetalle->execute();
				}

				// Confirmar la transacción
				$conn->commit();
				return "ok";
			} else {
				// Revertir la transacción en caso de error
				$conn->rollBack();
				return "error";
			}
		} catch (PDOException $e) {
			// Revertir la transacción en caso de excepción
			if ($conn->inTransaction()) {
				$conn->rollBack();
			}
			return "error";
		}

		// Cerrar la conexión
		$stmt = null;
		$stmtDetalle = null;
	}

	/*=============================================
	  EDITAR HORAS EXTRAS
	  =============================================*/
	static public function mdlEditarHoras($tabla, $datos)
	{
		// Actualizar la tabla horasextras
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha = :fecha, idhorario = :idhorario, tipo = :tipo WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":idhorario", $datos["idhorario"], PDO::PARAM_INT);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			// Eliminar los registros existentes en detallehoraempleado para la hora extra
			$stmt = Conexion::conectar()->prepare("DELETE FROM detallehoraempleado WHERE idhorasextras = :idhorasextras");
			$stmt->bindParam(":idhorasextras", $datos["id"], PDO::PARAM_INT);
			$stmt->execute();

			// Insertar los nuevos registros en detallehoraempleado
			foreach ($datos["empleados"] as $empleado) {
				$stmt = Conexion::conectar()->prepare("INSERT INTO detallehoraempleado (idhorasextras, idempleado) VALUES (:idhorasextras, :idempleado)");
				$stmt->bindParam(":idhorasextras", $datos["id"], PDO::PARAM_INT);
				$stmt->bindParam(":idempleado", $empleado, PDO::PARAM_INT);
				$stmt->execute();
			}
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

}
