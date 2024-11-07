<?php
require_once "conexion.php";
require_once "empleado.modelo.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
class ModeloAsistencia
{
    //MOSTRAR TODAS LAS ASISTENCIAS
    static public function MdlMostrarTodasLasAsistencias($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY fecha DESC");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt->close();
        $stmt = null;
    }
    //MOSTRAR ASISTENCIA
    static public function MdlMostrarAsistenciaDeEmpleado($idEmpleado, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio == null && $fechaFin == null) {
            $conexion = Conexion::conectar();
            $sql = "SELECT a.fecha, e.ci, e.nombre, e.apellidop, e.apellidom, a.entrada1, a.salida1, a.entrada2, a.salida2, a.horas, a.extras, a.retraso
            FROM asistencias a 
            INNER JOIN empleados e ON a.idempleado = e.id 
            WHERE a.idempleado = :idEmpleado";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
            $stmt->execute();
            $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $conexion = Conexion::conectar();
            $sql = "SELECT a.fecha, e.ci, e.nombre, e.apellidop, e.apellidom, a.entrada1, a.salida1, a.entrada2, a.salida2, a.horas, a.extras, a.retraso
            FROM asistencias a 
            INNER JOIN empleados e ON a.idempleado = e.id 
            WHERE DATE(a.fecha) >= :fechainicio 
            AND DATE(a.fecha) <= :fechafin 
            AND a.idempleado = :idEmpleado";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':fechainicio', $fechaInicio, PDO::PARAM_STR);
            $stmt->bindParam(':fechafin', $fechaFin, PDO::PARAM_STR);
            $stmt->bindParam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
            $stmt->execute();
            $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $respuesta;
    }
    //OBTENER ASISTENCIAS DE EMPLEADO
    static public function mdlObtenerAsistenciasEmpleado($idEmpleado, $fechaInicio, $fechaFin)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * FROM asistencias WHERE idempleado = :idempleado AND fecha BETWEEN :fechaInicio AND :fechaFin");
        $stmt->bindParam(":idempleado", $idEmpleado, PDO::PARAM_INT);
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);
        return $resultado;
    }
    //OBTENER EXTRAS DE EMPLEADO
    static public function mdlObtenerHorasExtrasEmpleado($idEmpleado, $fechaInicio, $fechaFin)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT fecha, extras 
                                FROM asistencias 
                                WHERE idempleado = :idempleado 
                                AND fecha BETWEEN :fechaInicio AND :fechaFin
                                AND extras > '00:00:00'");
        $stmt->bindParam(":idempleado", $idEmpleado, PDO::PARAM_INT);
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);

        // Devolver un array de registros de horas extras o un array vacío si no hay registros
        return $resultado ? $resultado : [];
    }
    //SUBIR ARCHIVO
    static public function mdlCargarDatos($nuevoArchivo)
    {
        // Verificar si el archivo ha sido cargado correctamente
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
        $asistencias = []; // Array para almacenar las entradas y salidas agrupadas por fecha y luego por userID
        $fechasIds = []; // Array para almacenar las fechas e IDs a verificar

        // Extraer fechas e IDs para validar duplicados
        foreach ($hoja->getRowIterator(2) as $fila) {
            $userID = $hoja->getCell("A" . $fila->getRowIndex())->getValue();
            $date = $hoja->getCell("C" . $fila->getRowIndex())->getFormattedValue();

            if (!empty($userID) && !empty($date)) {
                $fechaFormateada = is_numeric($date)
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d')
                    : (new DateTime($date))->format('Y-m-d');

                $fechasIds[] = ['userID' => $userID, 'fecha' => $fechaFormateada];
            }
        }

        // Validar duplicados en la base de datos
        $conexion = Conexion::conectar();
        foreach ($fechasIds as $registro) {
            $verificarStmt = $conexion->prepare("SELECT COUNT(*) FROM registros WHERE idempleado = :idempleado AND fecha = :fecha");
            $verificarStmt->bindParam(":idempleado", $registro['userID'], PDO::PARAM_INT);
            $verificarStmt->bindParam(":fecha", $registro['fecha'], PDO::PARAM_STR);
            $verificarStmt->execute();
            $count = $verificarStmt->fetchColumn();

            if ($count > 0) {
                echo "<script>console.log('Registro duplicado encontrado para Empleado {$registro['userID']} en la Fecha {$registro['fecha']}. No se insertarán los datos del archivo.');</script>";
                return 0; // Detener la operación si se encuentra un duplicado
            }
        }

        // Proceder con la inserción si no se encontraron duplicados
        foreach ($hoja->getRowIterator(2) as $fila) {
            $userID = $hoja->getCell("A" . $fila->getRowIndex())->getValue();
            $name = $hoja->getCell("B" . $fila->getRowIndex())->getValue();
            $date = $hoja->getCell("C" . $fila->getRowIndex())->getFormattedValue();
            $time = $hoja->getCell("D" . $fila->getRowIndex())->getFormattedValue();
            $verification = $hoja->getCell("E" . $fila->getRowIndex())->getValue();
            $mode = strtolower(trim($hoja->getCell("F" . $fila->getRowIndex())->getValue()));

            if (!empty($userID) && !empty($name) && !empty($date) && !empty($time)) {
                // Obtener el horario del empleado
                $horario = ModeloEmpleado::mdlMostrarHorarioEmpleado($userID);
                if (!$horario) {
                    continue; // Saltar si no hay horario asignado al empleado
                }

                // Convertir la fecha y hora a formatos adecuados
                $fechaFormateada = is_numeric($date)
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d')
                    : (new DateTime($date))->format('Y-m-d');
                $horaFormateada = date('H:i:s', strtotime($time));

                // Inicializar el array para cada fecha y empleado si no existe
                if (!isset($asistencias[$fechaFormateada][$userID])) {
                    $asistencias[$fechaFormateada][$userID] = [
                        'entrada1' => null,
                        'salida1' => null,
                        'entrada2' => null,
                        'salida2' => null,
                        'horas' => '00:00:00',
                        'extras' => '00:00:00',
                        'retraso_total' => '00:00:00'
                    ];
                }

                // Asignar la hora al tipo de evento correspondiente y calcular retrasos
                $retrasoTotalSegundos = 0;
                if ($mode === 'in') {
                    if ($asistencias[$fechaFormateada][$userID]['entrada1'] === null) {
                        $asistencias[$fechaFormateada][$userID]['entrada1'] = $horaFormateada;
                        // Calcular retraso para entrada1
                        if ($horaFormateada > $horario['entrada1']) {
                            $retraso = strtotime($horaFormateada) - strtotime($horario['entrada1']);
                            $retrasoTotalSegundos += $retraso;
                        }
                    } elseif ($asistencias[$fechaFormateada][$userID]['entrada2'] === null) {
                        $asistencias[$fechaFormateada][$userID]['entrada2'] = $horaFormateada;
                        // Calcular retraso para entrada2
                        if ($horaFormateada > $horario['entrada2']) {
                            $retraso = strtotime($horaFormateada) - strtotime($horario['entrada2']);
                            $retrasoTotalSegundos += $retraso;
                        }
                    }
                } elseif ($mode === 'out') {
                    if ($asistencias[$fechaFormateada][$userID]['salida1'] === null) {
                        $asistencias[$fechaFormateada][$userID]['salida1'] = $horaFormateada;
                    } elseif ($asistencias[$fechaFormateada][$userID]['salida2'] === null) {
                        $asistencias[$fechaFormateada][$userID]['salida2'] = $horaFormateada;
                    }
                }

                // Calcular el tiempo total de la jornada
                if (
                    !empty($asistencias[$fechaFormateada][$userID]['entrada1']) && !empty($asistencias[$fechaFormateada][$userID]['salida1'])
                    && !empty($asistencias[$fechaFormateada][$userID]['entrada2']) && !empty($asistencias[$fechaFormateada][$userID]['salida2'])
                ) {
                    $inicio1 = new DateTime($asistencias[$fechaFormateada][$userID]['entrada1']);
                    $fin1 = new DateTime($asistencias[$fechaFormateada][$userID]['salida1']);
                    $inicio2 = new DateTime($asistencias[$fechaFormateada][$userID]['entrada2']);
                    $fin2 = new DateTime($asistencias[$fechaFormateada][$userID]['salida2']);
                    $intervalo1 = $inicio1->diff($fin1);
                    $intervalo2 = $inicio2->diff($fin2);

                    $horasTotales = new DateTime('00:00:00');
                    $horasTotales->add($intervalo1);
                    $horasTotales->add($intervalo2);
                    $asistencias[$fechaFormateada][$userID]['horas'] = $horasTotales->format('H:i:s');

                    // Calcular horas extras (descontando las 8 horas)
                    $jornadaBase = new DateTime('08:00:00');
                    $totalHorasEnSegundos = $horasTotales->getTimestamp() - (new DateTime('00:00:00'))->getTimestamp();
                    $jornadaBaseEnSegundos = $jornadaBase->getTimestamp() - (new DateTime('00:00:00'))->getTimestamp();

                    if ($totalHorasEnSegundos > $jornadaBaseEnSegundos) {
                        $horasExtrasEnSegundos = $totalHorasEnSegundos - $jornadaBaseEnSegundos;
                        $horasExtras = new DateTime('@' . $horasExtrasEnSegundos);
                        $horasExtras->setTimezone(new DateTimeZone('UTC'));
                        $asistencias[$fechaFormateada][$userID]['extras'] = $horasExtras->format('H:i:s');
                    } else {
                        $asistencias[$fechaFormateada][$userID]['extras'] = '00:00:00'; // Sin horas extras
                    }
                }

                // Asignar el retraso total al array de asistencias
                if ($retrasoTotalSegundos > 0) {
                    $asistencias[$fechaFormateada][$userID]['retraso_total'] = gmdate('H:i:s', $retrasoTotalSegundos);
                }

                // Insertar en la tabla 'registros' el detalle original
                $stmt = $conexion->prepare("INSERT INTO registros(idempleado, nombre, fecha, hora, verificacion, evento) VALUES (:idempleado, :nombre, :fecha, :hora, :verificacion, :evento)");
                $stmt->bindParam(":idempleado", $userID, PDO::PARAM_INT);
                $stmt->bindParam(":nombre", $name, PDO::PARAM_STR);
                $stmt->bindParam(":fecha", $fechaFormateada, PDO::PARAM_STR);
                $stmt->bindParam(":hora", $horaFormateada, PDO::PARAM_STR);
                $stmt->bindParam(":verificacion", $verification, PDO::PARAM_STR);
                $stmt->bindParam(":evento", $mode, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $registros++;
                }
            }
        }

        if (!empty($asistencias)) {
            ModeloAsistencia::mdlInsertarAsistencias($asistencias);
        }

        return $registros;
    }
    //INSERTAR DATOS A LA TABLA ASISTENCIAS
    static public function mdlInsertarAsistencias($asistencias)
    {
        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO asistencias (
                fecha, 
                entrada1, 
                salida1, 
                entrada2, 
                salida2, 
                horas, 
                extras, 
                retraso, 
                idempleado
            ) VALUES (
                :fecha, 
                :entrada1, 
                :salida1, 
                :entrada2, 
                :salida2, 
                :horas, 
                :extras, 
                :retraso, 
                :idempleado
            )"
        );

        foreach ($asistencias as $fecha => $empleados) {
            foreach ($empleados as $idEmpleado => $datos) {
                $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
                $stmt->bindParam(":entrada1", $datos['entrada1'], PDO::PARAM_STR);
                $stmt->bindParam(":salida1", $datos['salida1'], PDO::PARAM_STR);
                $stmt->bindParam(":entrada2", $datos['entrada2'], PDO::PARAM_STR);
                $stmt->bindParam(":salida2", $datos['salida2'], PDO::PARAM_STR);
                $stmt->bindParam(":horas", $datos['horas'], PDO::PARAM_STR);
                $stmt->bindParam(":extras", $datos['extras'], PDO::PARAM_STR);
                $stmt->bindParam(":retraso", $datos['retraso_total'], PDO::PARAM_STR);
                $stmt->bindParam(":idempleado", $idEmpleado, PDO::PARAM_INT);

                if (!$stmt->execute()) {
                    // Manejar el error en caso de que la inserción falle
                    echo "Error al insertar datos para el empleado $idEmpleado en la fecha $fecha.";
                    return false;
                }
            }
        }

        $stmt->closeCursor(); // Cierra el cursor si quieres liberar recursos
        unset($stmt); // Libera el objeto explícitamente
        return true;
    }
    //RANGO DE FECHAS
    static public function mdlRangoFechasAsistencias($tabla, $fechaInicial, $fechaFinal)
    {
        if ($fechaInicial == null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        } else if ($fechaInicial == $fechaFinal) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%' ORDER BY fecha DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            $fechaActual = new DateTime();
            $fechaActual->add(new DateInterval("P1D"));
            $fechaActualMasUno = $fechaActual->format("Y-m-d");
            $fechaFinal2 = new DateTime($fechaFinal);
            $fechaFinal2->add(new DateInterval("P1D"));
            $fechaFinalMasUno = $fechaFinal2->format("Y-m-d");
            if ($fechaFinalMasUno == $fechaActualMasUno) {
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ORDER BY fecha DESC");
            } else {
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal' ORDER BY fecha DESC");
            }
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }






    //CALCULAR DÍAS TRABAJADOS Y FALTAS
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
        $diasFeriados = ModeloFeriados::mdlObtenerFeriados($fechaInicio, $fechaFin);
        // Calcular las faltas (días hábiles menos los días trabajados y restando los días feriados)
        $faltas = max(0, ($diasHabiles - $diasFeriados) - $diasTrabajados);
        $stmt = null;
        return [$diasTrabajados, $faltas];
    }
    static public function mdlImprimirReporteAsistenciasFechasId($fechaInicio, $fechaFin, $idEmpleado)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT a.fecha, a.entrada1, a.salida1, a.entrada2, a.salida2, a.horas, a.extras, 
                    e.id, e.ci, e.nombre, e.apellidop, e.apellidom, c.nombre AS nombre_cargo
             FROM asistencias a
             JOIN empleados e ON a.idempleado = e.id
             JOIN cargos c ON e.idcargo = c.id
             WHERE a.idempleado = :idEmpleado
             AND a.fecha BETWEEN :fechaInicio AND :fechaFin"
        );
        $stmt->bindParam(":idEmpleado", $idEmpleado, PDO::PARAM_INT);
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);
        return $result;
    }

    static public function mdlImprimirReporteAsistenciasFechas($fechaInicio, $fechaFin)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT a.fecha, a.entrada1, a.salida1, a.entrada2, a.salida2, a.horas, a.extras, 
                    e.id, e.ci, e.nombre, e.apellidop, e.apellidom, c.nombre AS nombre_cargo
             FROM asistencias a
             JOIN empleados e ON a.idempleado = e.id
             JOIN cargos c ON e.idcargo = c.id
             WHERE a.fecha BETWEEN :fechaInicio AND :fechaFin"
        );
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);
        return $result;
    }

    static public function mdlImprimirReporteAsistenciasId($idEmpleado)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT a.fecha, a.entrada1, a.salida1, a.entrada2, a.salida2, a.horas, a.extras, 
                    e.id, e.ci, e.nombre, e.apellidop, e.apellidom, c.nombre AS nombre_cargo
             FROM asistencias a
             JOIN empleados e ON a.idempleado = e.id
             JOIN cargos c ON e.idcargo = c.id
             WHERE a.idempleado = :idEmpleado"
        );
        $stmt->bindParam(":idEmpleado", $idEmpleado, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);
        return $result;
    }

    static public function mdlImprimirReporteAsistencias()
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT a.fecha, a.entrada1, a.salida1, a.entrada2, a.salida2, a.horas, a.extras, 
                    e.id, e.ci, e.nombre, e.apellidop, e.apellidom, c.nombre AS nombre_cargo
             FROM asistencias a
             JOIN empleados e ON a.idempleado = e.id
             JOIN cargos c ON e.idcargo = c.id"
        );
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);
        return $result;
    }


}
