<?php
class ControladorPlanilla
{
    //MOSTRAR PLANILLAS
    static public function ctrMostrarPlanilla($item, $valor)
    {
        $tabla = "planillas";
        $respuesta = ModeloPlanilla::MdlMostrarPlanilla($tabla, $item, $valor);
        return $respuesta;
    }
    //CREAR PLANILLA
    static public function ctrCrearPlanilla()
    {
        if (isset($_POST["fechaInicioP"]) && isset($_POST["fechaFinP"])) {
            $fechaInicio = date('Y-m-d', strtotime($_POST["fechaInicioP"]));
            $fechaFin = date('Y-m-d', strtotime($_POST["fechaFinP"]));
            $respuestaValidarFecha = ModeloPlanilla::mdlContarFechasPlanillas($fechaFin);

            if ($respuestaValidarFecha == 0) {
                $respuestaEmpleadosActivos = ModeloEmpleado::mdlMostrarIdEmpleadosActivos();
                $planillaDetalles = [];
                $diasLaboralesSemana = 5.5;
                $totalLiquidoPagable = 0;
                foreach ($respuestaEmpleadosActivos as $empleado) {
                    $idEmpleado = $empleado['id'];
                    $asistenciasEmpleado = ModeloAsistencia::mdlObtenerAsistenciasEmpleado($idEmpleado, $fechaInicio, $fechaFin);

                    $diasTrabajados = 0;
                    $totalHorasExtras = 0; // Total de horas extras en horas decimales

                    if (!empty($asistenciasEmpleado)) {
                        foreach ($asistenciasEmpleado as $asistencia) {
                            if ($asistencia['entrada1'] && $asistencia['salida1'] && $asistencia['entrada2'] && $asistencia['salida2']) {
                                $diasTrabajados += 1; // Jornada completa
                            } elseif ($asistencia['entrada1'] && $asistencia['salida1'] || $asistencia['entrada2'] && $asistencia['salida2']) {
                                $diasTrabajados += 0.5; // Media jornada
                            }

                            // Validar si las horas extras del registro superan 59 minutos
                            $horasExtrasEnSegundos = strtotime($asistencia['extras']) - strtotime('TODAY');
                            if ($horasExtrasEnSegundos > 3540) { // 59 minutos en segundos
                                $horasExtrasDecimal = $horasExtrasEnSegundos / 3600; // Convertir a horas decimales
                                $totalHorasExtras += $horasExtrasDecimal;
                            }
                        }
                    }

                    $diasPermiso = ModeloPermisos::mdlObtenerPermisosEmpleado($idEmpleado, $fechaInicio, $fechaFin);

                    // Obtener los días de feriados en el rango de fechas
                    $diasFeriado = ModeloFeriados::mdlObtenerFeriados($fechaInicio, $fechaFin);

                    // Calcular los días trabajados reales sumando permisos y feriados
                    $diasTrabajadosReales = $diasTrabajados + $diasPermiso + $diasFeriado;

                    // Verificar que los días trabajados reales no sobrepasen los días laborales semanales
                    if ($diasTrabajadosReales > $diasLaboralesSemana) {
                        $diasTrabajadosReales = $diasLaboralesSemana;
                    }

                    // Calcular las faltas considerando los permisos y feriados
                    $faltas = max(0, $diasLaboralesSemana - $diasTrabajadosReales);

                    // Obtener el salario mensual y calcular el haber básico semanal
                    $salarioMensual = ModeloEmpleado::mdlObtenerSalarioEmpleado($idEmpleado);
                    $haberBasicoSemanal = $salarioMensual / 4.33;
                    $sueldoPorDia = $haberBasicoSemanal / $diasLaboralesSemana;

                    // Calcular el descuento por días no trabajados
                    $descuentoPorFaltas = $faltas * $sueldoPorDia;

                    // Obtener anticipos del empleado en el rango de fechas
                    $anticipos = ModeloAnticipos::mdlObtenerAnticiposEmpleado($idEmpleado, $fechaInicio, $fechaFin);

                    // Calcular el total de descuentos
                    $totalDescuentos = $descuentoPorFaltas + $anticipos;

                    // Calcular el pago por horas extras (recargo del 100%)
                    $sueldoPorHora = $sueldoPorDia / 8; // Basado en un día de 8 horas
                    $pagoHorasExtras = $totalHorasExtras * $sueldoPorHora * 2; // Pago al doble

                    // Convertir el total de horas extras a formato HH:MM:SS
                    $totalHorasExtrasEnTiempo = gmdate("H:i:s", $totalHorasExtras * 3600); // Convertir horas decimales a segundos y luego a formato de tiempo

                    // Formatear los valores a dos decimales
                    $haberBasicoSemanal = number_format($haberBasicoSemanal, 2);
                    $descuentoPorFaltas = number_format($descuentoPorFaltas, 2);
                    $anticipos = number_format($anticipos, 2);
                    $totalDescuentos = number_format($totalDescuentos, 2);
                    $pagoHorasExtras = number_format($pagoHorasExtras, 2); // Pago por horas extras formateado

                    // Calcular el líquido pagable
                    $liquidoPagable = number_format($haberBasicoSemanal - $totalDescuentos + $pagoHorasExtras, 2);
                    $totalLiquidoPagable += $liquidoPagable; // Sumar al total pagado

                    // Almacenar los detalles en el array
                    $planillaDetalles[] = [
                        'idempleado' => $idEmpleado,
                        'diasTrabajados' => $diasTrabajados, // Cambio: debe coincidir con el bindParam
                        'haberBasicoSemanal' => $haberBasicoSemanal, // Cambio: debe coincidir con el bindParam
                        'horasextras' => $pagoHorasExtras,
                        'totalHorasExtras' => $totalHorasExtrasEnTiempo, // Cambio: debe coincidir con el bindParam
                        'faltas' => $faltas,
                        'anticipos' => $anticipos,
                        'totalDescuentos' => $totalDescuentos,
                        'liquidoPagable' => $liquidoPagable
                    ];
                }


                //echo '<script>console.log("' . $fechaFin . '");</script>';
                // Insertar la planilla con la fecha de fin y el total pagado
                $resultadoPlanilla = ModeloPlanilla::mdlInsertarPlanilla($fechaFin, $totalLiquidoPagable);

                if ($resultadoPlanilla == "ok") {

                    $idPlanilla = ModeloPlanilla::obtenerUltimoIdPlanilla();

                    // Insertar detalles de la planilla
                    foreach ($planillaDetalles as $detalle) {
                        ModeloPlanilla::mdlInsertarDetallePlanilla($idPlanilla, $detalle);
                    }
                    echo "<script type='text/javascript'>
                window.open('extensiones/TCPDF-main/pdf/imprimirPlanilla.php?idPlanilla={$idPlanilla}', '_blank');
              </script>";
                    echo '<script>
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "planilla";
					</script>';

                } else {
                    echo '<script>
						sessionStorage.setItem("tError", "true");
						window.location = "planilla";
					</script>';
                }
            } else {
                echo '<script>
            Swal.fire({
                type: "warning",
                title: "Planilla encontrada",
                text: "Se encontró una planilla con la fecha especificada.",
                showCancelButton: false,
                confirmButtonColor: "#627d72",
                confirmButtonText: "Confirmar"
            }).then(function(result) {
                if (result.value) {
                    window.location = "planilla";
                }
            });
            </script>';
            }
        }
    }







}


