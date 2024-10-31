<?php
require_once "conexion.php";
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

        // Iterar sobre las filas comenzando desde la fila 2
        foreach ($hoja->getRowIterator(2) as $fila) {
            $userID = $hoja->getCell("A" . $fila->getRowIndex())->getValue();
            $name = $hoja->getCell("B" . $fila->getRowIndex())->getValue();
            $date = $hoja->getCell("C" . $fila->getRowIndex())->getFormattedValue();
            $time = $hoja->getCell("D" . $fila->getRowIndex())->getFormattedValue();
            $verification = $hoja->getCell("E" . $fila->getRowIndex())->getValue();
            $mode = strtolower(trim($hoja->getCell("F" . $fila->getRowIndex())->getValue())); // Convertimos a minúsculas y eliminamos espacios

            // Confirmación de los datos leídos
            //echo "Procesando: userID=$userID, name=$name, date=$date, time=$time, mode=$mode <br>";

            if (!empty($userID) && !empty($name) && !empty($date) && !empty($time)) {
                // Convertir la fecha a un formato adecuado
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
                    ];
                }

                // Asignar la hora al tipo de evento correspondiente
                if ($mode === 'in') {
                    if ($asistencias[$fechaFormateada][$userID]['entrada1'] === null) {
                        $asistencias[$fechaFormateada][$userID]['entrada1'] = $horaFormateada;
                    } elseif ($asistencias[$fechaFormateada][$userID]['entrada2'] === null) {
                        $asistencias[$fechaFormateada][$userID]['entrada2'] = $horaFormateada;
                    }
                } elseif ($mode === 'out') {
                    if ($asistencias[$fechaFormateada][$userID]['salida1'] === null) {
                        $asistencias[$fechaFormateada][$userID]['salida1'] = $horaFormateada;
                    } elseif ($asistencias[$fechaFormateada][$userID]['salida2'] === null) {
                        $asistencias[$fechaFormateada][$userID]['salida2'] = $horaFormateada;
                    }
                }

                // Insertar en la tabla 'registros' el detalle original
                $stmt = Conexion::conectar()->prepare("INSERT INTO registros(idempleado, nombre, fecha, hora, verificacion, evento) VALUES (:idempleado, :nombre, :fecha, :hora, :verificacion, :evento)");
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

        // Depuración: Mostrar el array de asistencias organizado en el formato deseado
        echo "<h3>Depuración del Array Asistencias:</h3>";
        echo "<table border='1'>
            <tr>
                <th>Fecha</th>
                <th>UserID</th>
                <th>Primera Entrada</th>
                <th>Primera Salida</th>
                <th>Segunda Entrada</th>
                <th>Segunda Salida</th>
            </tr>";
        foreach ($asistencias as $fecha => $usuarios) {
            foreach ($usuarios as $userID => $horas) {
                echo "<tr>
                    <td>{$fecha}</td>
                    <td>{$userID}</td>
                    <td>" . ($horas['entrada1'] ?? '-') . "</td>
                    <td>" . ($horas['salida1'] ?? '-') . "</td>
                    <td>" . ($horas['entrada2'] ?? '-') . "</td>
                    <td>" . ($horas['salida2'] ?? '-') . "</td>
                  </tr>";
            }
        }
        echo "</table>";

        return $registros;
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
        $diasFeriados = ModeloFeriados::mdlContarFeriados($fechaInicio, $fechaFin);
        // Calcular las faltas (días hábiles menos los días trabajados y restando los días feriados)
        $faltas = max(0, ($diasHabiles - $diasFeriados) - $diasTrabajados);
        $stmt = null;
        return [$diasTrabajados, $faltas];
    }
}
