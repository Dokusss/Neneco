<?php

require_once "conexion.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

class ModeloAsistencia
{

    /*=============================================
    MOSTRAR TODAS LAS ASISTENCIAS
    =============================================*/

    static public function MdlMostrarTodasLasAsistencias($tabla, $item, $valor)
    {

        if ($item != null) {
            //SELECT * FROM usuarios WHERE usuario='admin';
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY fecha DESC");

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
    MOSTRAR ASISTENCIA
    =============================================*/

    static public function MdlMostrarAsistencia($tabla, $fechaInicio, $fechaFin, $id)
    {
        $conexion = Conexion::conectar();

        $sql = "SELECT a.fecha, e.nombre, e.apellidop, e.apellidom, a.entrada1, a.salida1, a.entrada2, a.salida2, a.horas, a.horasextras
        FROM $tabla a 
        INNER JOIN empleado e ON a.idempleado = e.id 
        WHERE DATE(a.fecha) >= :fechainicio 
        AND DATE(a.fecha) <= :fechafin 
        AND a.idempleado = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':fechainicio', $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(':fechafin', $fechaFin, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);


        return $respuesta;
    }

    /*=============================================
    SUBIR ARCHIVO
    =============================================*/

    static public function mdlCargarDatos($nuevoArchivo)
    {
        // Verificar si el archivo ha sido cargado
        if (!isset($nuevoArchivo['tmp_name']) || !file_exists($nuevoArchivo['tmp_name'])) {
            throw new Exception("El archivo no existe o no se ha subido correctamente.");
        }

        $nombreArchivo = $nuevoArchivo['tmp_name'];

        try {
            // Cargar el archivo Excel
            $documento = IOFactory::load($nombreArchivo);
        } catch (Exception $e) {
            throw new Exception("Error al cargar el archivo: " . $e->getMessage());
        }

        $hoja = $documento->getActiveSheet();
        $registros = 0;

        // Obtener los horarios planificados del horario 'normal' desde la base de datos
        $conn = Conexion::conectar();
        $stmt = $conn->prepare("SELECT entrada1, salida1, entrada2, salida2 FROM horario WHERE nombre = 'normal'");
        $stmt->execute();
        $horarioNormal = $stmt->fetch(PDO::FETCH_ASSOC);

        // Convertir los horarios planificados a DateTime
        $horaEntrada1Planificada = new DateTime($horarioNormal['entrada1']);
        $horaEntrada2Planificada = new DateTime($horarioNormal['entrada2']);


        if (!$horarioNormal) {
            throw new Exception("No se encontró el horario normal en la base de datos.");
        }

        // Iterar sobre las filas comenzando desde la fila 2
        foreach ($hoja->getRowIterator(2) as $fila) {
            $userID = $hoja->getCell("A" . $fila->getRowIndex())->getValue();
            $name = $hoja->getCell("B" . $fila->getRowIndex())->getValue();
            $date = $hoja->getCell("C" . $fila->getRowIndex())->getFormattedValue();
            $time = $hoja->getCell("D" . $fila->getRowIndex())->getFormattedValue();
            $mode = $hoja->getCell("E" . $fila->getRowIndex())->getValue();
            $status = $hoja->getCell("F" . $fila->getRowIndex())->getValue();

            if (!empty($userID) && !empty($name) && !empty($date) && !empty($time)) {
                // Verificar si la fecha es un número de serie de Excel o una cadena de texto
                if (is_numeric($date)) {
                    // Convertir la fecha de Excel a objeto DateTime
                    $fechaDateTime = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
                    $fechaFormateada = $fechaDateTime->format('Y-m-d');
                } else {
                    // Convertir la cadena de texto a objeto DateTime
                    $fechaDateTime = new DateTime($date);
                    $fechaFormateada = $fechaDateTime->format('Y-m-d');
                }

                // Validar y formatear la hora
                $horaFormateada = date('H:i:s', strtotime($time));

                // Preparar la consulta
                $stmt = Conexion::conectar()->prepare("INSERT INTO registros(idempleado, nombre, fecha, hora, verificacion, evento) VALUES (:idempleado, :nombre, :fecha, :hora, :verificacion, :evento)");

                // Enlazar los parámetros
                $stmt->bindParam(":idempleado", $userID, PDO::PARAM_INT);
                $stmt->bindParam(":nombre", $name, PDO::PARAM_STR);
                $stmt->bindParam(":fecha", $fechaFormateada, PDO::PARAM_STR);
                $stmt->bindParam(":hora", $horaFormateada, PDO::PARAM_STR);
                $stmt->bindParam(":verificacion", $mode, PDO::PARAM_STR);
                $stmt->bindParam(":evento", $status, PDO::PARAM_STR);

                // Ejecutar la consulta y verificar el resultado
                if ($stmt->execute()) {
                    $registros++;
                }
            }
        }
        $conn = Conexion::conectar();

        // Nueva sección para extraer datos y hacer inserciones adicionales
        $stmt = $conn->prepare("
            SELECT idempleado, fecha,
            MIN(CASE WHEN evento = 'In' THEN hora END) AS entrada1,
            MIN(CASE WHEN evento = 'Out' THEN hora END) AS salida1,
            MAX(CASE WHEN evento = 'In' THEN hora END) AS entrada2,
            MAX(CASE WHEN evento = 'Out' AND hora > (
            SELECT MAX(hora)
            FROM registros r2
            WHERE r2.idempleado = registros.idempleado
            AND r2.fecha = registros.fecha
            AND r2.evento = 'In'
            ) THEN hora END) AS salida2
            FROM registros
            GROUP BY idempleado, fecha
            ORDER BY fecha DESC, idempleado
            ");
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Insertar los resultados procesados en la tabla `asistencia`
        foreach ($resultados as $resultado) {
            $entrada1 = $resultado['entrada1'] ? new DateTime($resultado['entrada1']) : null;
            $salida1 = $resultado['salida1'] ? new DateTime($resultado['salida1']) : null;
            $entrada2 = $resultado['entrada2'] ? new DateTime($resultado['entrada2']) : null;
            $salida2 = $resultado['salida2'] ? new DateTime($resultado['salida2']) : null;

            $horasTrabajadas = 0;
            $horasExtras = 0;
            $retraso = 0;

            if ($entrada1 && $salida1) {
                $intervalo1 = $entrada1->diff($salida1);
                $horasTrabajadas += $intervalo1->h * 3600 + $intervalo1->i * 60 + $intervalo1->s;

                if ($entrada1 > $horaEntrada1Planificada) {
                    $retrasoInterval = $horaEntrada1Planificada->diff($entrada1);
                    $retraso += $retrasoInterval->h * 3600 + $retrasoInterval->i * 60 + $retrasoInterval->s;
                }
            }

            if ($entrada2 && $salida2) {
                $intervalo2 = $entrada2->diff($salida2);
                $horasTrabajadas += $intervalo2->h * 3600 + $intervalo2->i * 60 + $intervalo2->s;

                if ($entrada2 > $horaEntrada2Planificada) {
                    $retrasoInterval = $horaEntrada2Planificada->diff($entrada2);
                    $retraso += $retrasoInterval->h * 3600 + $retrasoInterval->i * 60 + $retrasoInterval->s;
                }
            }

            // Calcular las horas extras solo si exceden los 59 minutos (3540 segundos)
            if ($horasTrabajadas > 8 * 3600) {
                $horasExtras = $horasTrabajadas - 8 * 3600;

                // Verificar si las horas extras exceden los 59 minutos
                if ($horasExtras <= 3540) {
                    $horasExtras = 0; // Si no es superior a 59 minutos, no se considera como hora extra
                }
            } else {
                $horasExtras = 0;
            }

            // Convertir las horas trabajadas, horas extras y retrasos a formato H:i:s
            $horasTrabajadasStr = gmdate('H:i:s', $horasTrabajadas);
            $horasExtrasStr = gmdate('H:i:s', $horasExtras);
            $retrasoStr = gmdate('H:i:s', $retraso);

            // Asignar valores por defecto si entrada2 o salida2 son nulos
            $entrada1Str = $entrada1 ? $entrada1->format('H:i:s') : '00:00:00';
            $salida1Str = $salida1 ? $salida1->format('H:i:s') : '00:00:00';
            $entrada2Str = $entrada2 ? $entrada2->format('H:i:s') : null;
            $salida2Str = $salida2 ? $salida2->format('H:i:s') : null;

            $stmt = $conn->prepare("INSERT INTO asistencia(fecha, entrada1, salida1, entrada2, salida2, horas, horasextras, retraso, idempleado) 
                            VALUES (:fecha, :entrada1, :salida1, :entrada2, :salida2, :horas, :horasextras, :retraso, :idempleado)");
            $stmt->bindParam(":fecha", $resultado['fecha'], PDO::PARAM_STR);
            $stmt->bindParam(":entrada1", $entrada1Str, PDO::PARAM_STR);
            $stmt->bindParam(":salida1", $salida1Str, PDO::PARAM_STR);
            $stmt->bindParam(":entrada2", $entrada2Str, PDO::PARAM_STR);
            $stmt->bindParam(":salida2", $salida2Str, PDO::PARAM_STR);
            $stmt->bindParam(":horas", $horasTrabajadasStr, PDO::PARAM_STR);
            $stmt->bindParam(":horasextras", $horasExtrasStr, PDO::PARAM_STR);
            $stmt->bindParam(":retraso", $retrasoStr, PDO::PARAM_STR);
            $stmt->bindParam(":idempleado", $resultado['idempleado'], PDO::PARAM_INT);
            $stmt->execute();
        }

        return $registros;
    }


    /*=============================================
    CALCULAR DÍAS TRABAJADOS Y FALTAS
    =============================================*/
    public static function mdlCalcularDiasTrabajadosYFaltas($idEmpleado, $fechaInicio, $fechaFin)
    {
        // Obtener los días trabajados en el rango de fechas
        $stmt = Conexion::conectar()->prepare(
            "SELECT COUNT(*) AS diasTrabajados
         FROM asistencia
         WHERE idempleado = :idempleado
         AND fecha BETWEEN :fechaInicio AND :fechaFin"
        );

        $stmt->bindParam(":idempleado", $idEmpleado, PDO::PARAM_INT);
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);

        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $diasTrabajados = $resultado['diasTrabajados'];

        // Calcular los días hábiles en el rango de fechas
        $diasTotales = (new DateTime($fechaInicio))->diff(new DateTime($fechaFin))->days + 1;

        // Incluir sábados en los días hábiles (lunes a sábado)
        $diasHabiles = 0;
        $currentDate = new DateTime($fechaInicio);
        for ($i = 0; $i < $diasTotales; $i++) {
            if ($currentDate->format('N') < 7) { // 1-6 es lunes a sábado
                $diasHabiles++;
            }
            $currentDate->modify('+1 day');
        }

        // Obtener los días feriados en el rango de fechas
        $diasFeriados = ModeloFeriados::mdlContarFeriados($fechaInicio, $fechaFin);

        // Calcular las faltas (días hábiles menos los días trabajados y restando los días feriados)
        $faltas = max(0, ($diasHabiles - $diasFeriados) - $diasTrabajados);

        $stmt = null;

        return [$diasTrabajados, $faltas];
    }


}
