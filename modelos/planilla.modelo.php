<?php
require_once "conexion.php";
class ModeloPlanilla
{
    //CREAR PLANILLA
    static public function mdlInsertarPlanilla($fechaFin, $totalLiquidoPagable)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO planillas(fecha, totalpagado) VALUES (:fecha, :totalpagado)");
        $stmt->bindParam(":fecha", $fechaFin, PDO::PARAM_STR);
        $stmt->bindParam(":totalpagado", $totalLiquidoPagable, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
        $stmt = null;

    }
    //OBTENER ID PLANILLA
    static public function obtenerUltimoIdPlanilla()
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT id FROM planillas ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);
        return $resultado['id'];
    }
    //MOSTRAR PLANILLA
    static public function mdlMostrarPlanilla($tabla, $item, $valor)
    {
        if ($item != null) {
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
    //VALIDAR FECHA
    static public function mdlContarFechasPlanillas($fechaFin)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT COUNT(DISTINCT fecha) AS total_fechas FROM planillas WHERE fecha <= :fechaFin");
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);
        return $resultado['total_fechas'];
    }
    //IMPRIMIR PLANILLA
    static public function mdlImprimirPlanilla($idPlanilla)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT p.id, p.fecha, p.totalpagado, p.estado, e.id,
                e.ci, e.nombre, e.apellidop, e.apellidom, 
                dp.diastrabajados, dp.haberbasico, dp.horasextras, 
                dp.faltas, dp.anticipos, dp.totaldescuentos, dp.liquidopagable, c.nombre AS nombre_cargo
         FROM detalleplanillaempleado dp
         JOIN empleados e ON e.id = dp.idempleado
         JOIN planillas p ON p.id = dp.idplanilla
  		JOIN cargos c ON e.idcargo = c.id
         WHERE dp.idplanilla = :idPlanilla"
        );

        $stmt->bindParam(":idPlanilla", $idPlanilla, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); // Liberar el cursor
        unset($stmt); // Liberar el recurso

        return $result;
    }
    //GUARDAR DETALLE DE PLANILLA DE EMPLEADO
    static public function mdlInsertarDetallePlanilla($idPlanilla, $detalle)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare(
            "INSERT INTO detalleplanillaempleado 
        (idempleado, idplanilla, diastrabajados, haberbasico, horasextras, totalhorasextras, faltas, anticipos, totaldescuentos, liquidopagable) 
        VALUES 
        (:idempleado, :idplanilla, :diastrabajados, :haberbasico, :horasextras, :totalhorasextras, :faltas, :anticipos, :totaldescuentos, :liquidopagable)"
        );
        $stmt->bindParam(":idempleado", $detalle['idempleado'], PDO::PARAM_INT);
        $stmt->bindParam(":idplanilla", $idPlanilla, PDO::PARAM_INT);
        $stmt->bindParam(":diastrabajados", $detalle['diasTrabajados'], PDO::PARAM_INT);
        $stmt->bindParam(":haberbasico", $detalle['haberBasicoSemanal'], PDO::PARAM_STR);
        $stmt->bindParam(":horasextras", $detalle['horasextras'], PDO::PARAM_STR);
        $stmt->bindParam(":totalhorasextras", $detalle['totalHorasExtras'], PDO::PARAM_STR);
        $stmt->bindParam(":faltas", $detalle['faltas'], PDO::PARAM_INT);
        $stmt->bindParam(":anticipos", $detalle['anticipos'], PDO::PARAM_STR);
        $stmt->bindParam(":totaldescuentos", $detalle['totalDescuentos'], PDO::PARAM_STR);
        $stmt->bindParam(":liquidopagable", $detalle['liquidoPagable'], PDO::PARAM_STR);
        $resultado = $stmt->execute();
        $stmt->closeCursor();
        unset($stmt);
        return $resultado;
    }



}