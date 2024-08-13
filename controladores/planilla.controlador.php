<?php
class ControladorPlanilla
{

    static public function ctrMostrarPlanilla($item, $valor)
    {

        $tabla = "planilla";

        $respuesta = ModeloPlanilla::MdlMostrarPlanilla($tabla, $item, $valor);

        return $respuesta;
    }

    /*=============================================
    CREAR PLANILLA
    =============================================*/
    static public function ctrCrearPlanilla()
    {
        if (isset($_POST["fechaInicioP"]) && isset($_POST["fechaFinP"])) {
            $fechaInicio = $_POST["fechaInicioP"];
            $fechaFin = $_POST["fechaFinP"];

            $idPlanilla = ModeloPlanilla::mdlCrearPlanilla($fechaInicio, $fechaFin);
            $empleados = ModeloEmpleado::mdlMostrarEmpleadosActivos();

            foreach ($empleados as $empleado) {
                $idEmpleado = $empleado['id'];
                $sueldoSemanal = $empleado['sueldo'] / 4;
                $sueldoDiario = $sueldoSemanal / 6;
                $tarifaPorHora = $sueldoDiario / 8;

                // Obtener días trabajados, faltas y permisos
                list($diasTrabajados, $faltas, $diasPermisos) = ModeloAsistencia::mdlCalcularDiasTrabajadosYFaltas($idEmpleado, $fechaInicio, $fechaFin);

                // Obtener días feriados en el rango
                $diasFeriados = ModeloFeriados::mdlContarFeriados($fechaInicio, $fechaFin);

                // Sumar los días feriados a los días trabajados
                $diasTrabajados += $diasFeriados;

                // Calcular el haber básico
                $haberBasico = $sueldoDiario * $diasTrabajados;

                // Calcular las horas extras normales
                $horasExtrasNormales = ModeloHoras::mdlCalcularHorasExtrasNormales($idEmpleado, $fechaInicio, $fechaFin, $tarifaPorHora);

                // Calcular anticipos
                $anticipos = ModeloAnticipos::mdlCalcularAnticipos($idEmpleado, $fechaInicio, $fechaFin);

                // Calcular el descuento de AFP
                $descuentoAFP = $haberBasico * 0.1271;

                // Calcular descuentos (anticipos, faltas y AFP)
                $totalDescuentos = $anticipos + ($faltas * $sueldoDiario) + $descuentoAFP;

                // Calcular el líquido pagable
                $liquidoPagable = $haberBasico + $horasExtrasNormales - $totalDescuentos;

                // Guardar la información en detalleplanillaempleado
                $resultado = ModeloPlanilla::mdlGuardarDetallePlanillaEmpleado(
                    $idPlanilla,
                    $idEmpleado,
                    $diasTrabajados,
                    $haberBasico,
                    $horasExtrasNormales,
                    $descuentoAFP,
                    $faltas,
                    $anticipos,
                    $totalDescuentos,
                    $liquidoPagable
                );
            }

            $id = $idPlanilla;
            echo "<script type='text/javascript'>
                window.open('extensiones/tcpdf/pdf/planilla.php?id={$id}', '_blank');
              </script>";

              echo '<script>

              Swal.fire({
                  type: "success",
                  title: "Planilla creada correctamente!",
                  showConfirmButton: true,
                  confirmButtonColor: "#627d72",
                  confirmButtonText: "Cerrar"
              }).then(function(result) {
                  if (result.value) {
                      window.location = "planilla";
                  }
              });
                
                  </script>';
        }
    }
}


