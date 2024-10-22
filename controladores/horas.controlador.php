<?php

class ControladorHoras
{

	//MOSTRAR HORAS
	static public function ctrMostrarHoras($item, $valor)
	{
		$tabla = "horasextras";
		$respuesta = ModeloHoras::MdlMostrarHoras($tabla, $item, $valor);
		return $respuesta;
	}

	//MOSTRAR DETALLE HORAS
	public static function ctrMostrarDetalleHoras($item, $valor)
	{
		$tabla = "detallehoraempleado";
		$respuesta = ModeloHoras::mdlMostrarDetalleHoras($tabla, $item, $valor);
		return $respuesta;
	}

	//CREAR HORA 
	static public function ctrCrearHoras()
	{
		if (isset($_POST["nuevoFecha"])) {
			$nuevoFecha = $_POST['nuevoFecha'];
			$formato = 'Y-m-d';
			$fecha = DateTime::createFromFormat($formato, $nuevoFecha);
			$horaEntrada = $_POST['nuevoEntrada'];
			$horaEntradaFormateada = date('H:i:s', strtotime($horaEntrada));
			$horaSalida = $_POST['nuevoSalida'];
			$horaSalidaFormateada = date('H:i:s', strtotime($horaSalida));
			// Verificar si se ha enviado la lista de empleados y no está vacía
			if (isset($_POST["listaEmpleados"]) && $_POST["listaEmpleados"] != "") {
				if ($fecha && $fecha->format($formato) === $nuevoFecha) {
					$tabla = "horasextras";
					$datos = array(
						"fecha" => $nuevoFecha,
						"entrada" => $horaEntradaFormateada,
						"salida" => $horaSalidaFormateada
					);
					// Insertar los datos en la tabla horasextras
					$respuesta = ModeloHoras::mdlIngresarHoras($tabla, $datos);
					if ($respuesta == "ok") {
						$idHoraExtra = ModeloHoras::mdlObtenerUltimoId();
						$listaEmpleados = $_POST["listaEmpleados"];
						// Insertar los datos en la tabla detallehoraempleado
						$respuestaDetalle = ModeloHoras::mdlInsertarDetalleHorasExtras($idHoraExtra, $listaEmpleados);
						if ($respuestaDetalle == "ok") {
							echo '<script>
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "horasextras";
					</script>';
						} else {
							echo '<script>
                    alert("Error al insertar detalles: ' . $respuestaDetalle . '");
                    window.location = "horasextras";
                </script>';
						}
					}
				} else {
					echo '<script>
                        sessionStorage.setItem("tError", "true");
                        window.location = "horasextras";
                    </script>';
				}
			} else {
				echo '<script>
                    alert("Debe seleccionar al menos un empleado.");
                    window.location = "horasextras";
                </script>';
			}
		}
	}

	//EDITAR HORAS EXTRAS    
	static public function ctrEditarHoras()
	{
		if (isset($_POST["editarFecha"])) {
			$editarFecha = $_POST['editarFecha'];
			$formato = 'Y-m-d';
			$fecha = DateTime::createFromFormat($formato, $editarFecha);
			$editarEntrada = $_POST['editarEntrada'];
			$editarEntradaFormateada = date('H:i:s', strtotime($editarEntrada));
			$editarSalida = $_POST['editarSalida'];
			$editarSalidaFormateada = date('H:i:s', strtotime($editarSalida));
			if ($fecha && $fecha->format($formato) === $editarFecha) {
				$tabla = "horasextras";
				$datos = array(
					"id" => $_POST["id"],
					"fecha" => $editarFecha,
					"entrada" => $editarEntradaFormateada,
					"salida" => $editarSalidaFormateada
				);
				$respuesta = ModeloHoras::mdlEditarHoras($tabla, $datos);
				if ($respuesta == "ok") {
					echo '<script>
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "horasextras";
					</script>';
				}
			} else {
				echo '<script>
                        sessionStorage.setItem("tError", "true");
                        window.location = "horasextras";
                    </script>';
			}
		}
	}
}


