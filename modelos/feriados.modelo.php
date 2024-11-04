<?php
require_once "conexion.php";
class ModeloFeriados
{
    //MOSTRAR FERIADOS
    static public function MdlMostrarFeriados($tabla, $item, $valor)
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
    //CREAR FERIADOS
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
    //OBTENER FERIADOS
    static public function mdlObtenerFeriados($fechaInicio, $fechaFin)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT COUNT(*) AS totalDiasFeriados 
                                FROM feriados 
                                WHERE fecha BETWEEN :fechaInicio AND :fechaFin");
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);
        return $resultado['totalDiasFeriados'] ? $resultado['totalDiasFeriados'] : 0;
    }
}

