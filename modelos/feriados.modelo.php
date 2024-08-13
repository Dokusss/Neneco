<?php

require_once "conexion.php";

class ModeloFeriados
{

    /*=============================================
          MOSTRAR FERIADOS
          =============================================*/

    static public function MdlMostrarFeriados($tabla, $item, $valor)
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
              CREAR FERIADOS
              =============================================*/

    static public function mdlCrearFeriados($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, fecha) VALUES (:nombre, :fecha)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();
        $stmt = null;
    }

    /*=============================================
    CONTAR FERIADOS EN EL RANGO DE FECHAS
    =============================================*/
    public static function mdlContarFeriados($fechaInicio, $fechaFin)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT COUNT(*) AS totalFeriados 
             FROM feriados 
             WHERE fecha BETWEEN :fechaInicio AND :fechaFin"
        );

        // Vincular los parámetros
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver el número total de feriados en el rango de fechas
        return $resultado['totalFeriados'] ?? 0;

        // No se necesita $stmt->close(); 
        $stmt = null;
    }
}

