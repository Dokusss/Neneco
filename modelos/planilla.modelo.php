<?php

require_once "conexion.php";

class ModeloPlanilla
{

    static public function mdlSumarLiquidopagable($idPlanilla)
    {
        // Preparamos la consulta con SUM para obtener el total de liquidopagable
        $stmt = Conexion::conectar()->prepare("
        SELECT SUM(dpe.liquidopagable) AS total_liquidopagable
        FROM detalleplanillaempleado dpe
        JOIN planilla p ON dpe.idplanilla = p.id
        WHERE p.id = :idPlanilla");

        $stmt->bindParam(":idPlanilla", $idPlanilla, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch();

        // Cerramos la conexión
        $stmt->close();
        $stmt = null;
    }

    static public function mdlMostrarPlanilla($tabla, $item, $valor)
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

    static public function mdlMostrarDetallePlanillaEmpleado($item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM detalleplanillaempleado WHERE $item = :$item");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM detalleplanillaempleado");

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $stmt = null;
    }


    /*=============================================
 CREAR PLANILLA
 =============================================*/
    public static function mdlCrearPlanilla($fechaInicio, $fechaFin)
    {
        try {
            $conexion = Conexion::conectar(); // Reutiliza la misma conexión
            $stmt = $conexion->prepare("INSERT INTO planilla (fecha) VALUES (NOW())");

            if ($stmt->execute()) {
                // Obtener el ID de la planilla recién creada
                $idPlanilla = $conexion->lastInsertId(); // Usa la misma conexión
                return $idPlanilla;
            } else {
                return "error en la inserción";
            }
        } catch (PDOException $e) {
            return "error: " . $e->getMessage();
        }

        $stmt->close();
        $stmt = null;
    }


    /*=============================================
    GUARDAR DETALLE DE PLANILLA DE EMPLEADO
    =============================================*/
    public static function mdlGuardarDetallePlanillaEmpleado($idPlanilla, $idEmpleado, $diasTrabajados, $haberBasico, $horasExtrasNormales, $descuentoAFP, $faltas, $anticipos, $totalDescuentos, $liquidoPagable)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO detalleplanillaempleado 
        (idplanilla, idempleado, diastrabajados, haberbasico, horasextras, afp, faltas, anticipos, totaldescuentos, liquidopagable) 
        VALUES (:idplanilla, :idempleado, :diastrabajados, :haberbasico, :horasextras, :afp, :faltas, :anticipos, :totaldescuentos, :liquidopagable)");

        $stmt->bindParam(":idplanilla", $idPlanilla, PDO::PARAM_INT);
        $stmt->bindParam(":idempleado", $idEmpleado, PDO::PARAM_INT);
        $stmt->bindParam(":diastrabajados", $diasTrabajados, PDO::PARAM_INT);
        $stmt->bindParam(":haberbasico", $haberBasico, PDO::PARAM_STR);
        $stmt->bindParam(":horasextras", $horasExtrasNormales, PDO::PARAM_STR);
        $stmt->bindParam(":afp", $descuentoAFP, PDO::PARAM_STR);
        $stmt->bindParam(":faltas", $faltas, PDO::PARAM_INT);
        $stmt->bindParam(":anticipos", $anticipos, PDO::PARAM_STR);
        $stmt->bindParam(":totaldescuentos", $totalDescuentos, PDO::PARAM_STR);
        $stmt->bindParam(":liquidopagable", $liquidoPagable, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";  // Retorna "ok" si la inserción fue exitosa
        } else {
            return "error";  // Retorna "error" si hubo un problema
        }

        $stmt = null;
    }


}