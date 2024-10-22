<?php

class ControladorHorario
{

	//MOSTRAR HORARIOS
	static public function ctrMostrarHorario($item, $valor)
	{
		$tabla = "horarios";
		$respuesta = ModeloHorario::MdlMostrarHorario($tabla, $item, $valor);
		return $respuesta;
	}

	//CREAR HORARIO
	static public function ctrCrearHorario()
	{
		if (isset($_POST["nuevoFecha"])) {
			$nuevoFecha = $_POST['nuevoFecha'];
			$formato = 'Y-m-d';
			$fecha = DateTime::createFromFormat($formato, $nuevoFecha);
			$horaEntrada1 = $_POST['nuevoEntrada1'];
			$entrada1 = date('H:i:s', strtotime($horaEntrada1));
			$horaSalida1 = $_POST['nuevoSalida1'];
			$salida1 = date('H:i:s', strtotime($horaSalida1));
			$horaEntrada2 = $_POST['nuevoEntrada2'];
			$entrada2 = date('H:i:s', strtotime($horaEntrada2));
			$horaSalida2 = $_POST['nuevoSalida2'];
			$salida2 = date('H:i:s', strtotime($horaSalida2));
			if ($fecha && $fecha->format($formato) === $nuevoFecha) {
				$tabla = "horarios";
				$datos = array(
					"fecha" => $nuevoFecha,
					"entrada1" => $entrada1,
					"salida1" => $salida1,
					"entrada2" => $entrada2,
					"salida2" => $salida2
				);
				$respuesta = ModeloHorario::mdlIngresarHorario($tabla, $datos);
				if ($respuesta == "ok") {
					echo '<script>
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "horario";
					</script>';
				}
			} else {
				echo '<script>
					sessionStorage.setItem("tError", "true");
					window.location = "horario";
				</script>';
			}
		}
	}
	//EDITAR HORARIO
	static public function ctrEditarHorario()
	{
		if (isset($_POST["editarFecha"])) {
			$editarFecha = $_POST['editarFecha'];
			$formato = 'Y-m-d';
			$fecha = DateTime::createFromFormat($formato, $editarFecha);
			$editarHoraEntrada1 = $_POST['editarEntrada1'];
			$editarEntrada1 = date('H:i:s', strtotime($editarHoraEntrada1));
			$editarHoraSalida1 = $_POST['editarSalida1'];
			$editarSalida1 = date('H:i:s', strtotime($editarHoraSalida1));
			$editarHoraEntrada2 = $_POST['editarEntrada2'];
			$editarEntrada2 = date('H:i:s', strtotime($editarHoraEntrada2));
			$editarHoraSalida2 = $_POST['editarSalida2'];
			$editarSalida2 = date('H:i:s', strtotime($editarHoraSalida2));
			if ($fecha && $fecha->format($formato) === $editarFecha) {
				$tabla = "horarios";
				$datos = array(
					"id" => $_POST["id"],
					"fecha" => $editarFecha,
					"entrada1" => $editarEntrada1,
					"salida1" => $editarSalida1,
					"entrada2" => $editarEntrada2,
					"salida2" => $editarSalida2
				);
				$respuesta = ModeloHorario::mdlEditarHorario($tabla, $datos);
				if ($respuesta == "ok") {
					echo '<script>
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "horario";
					</script>';
				}
			} else {
				echo '<script>
					sessionStorage.setItem("tError", "true");
					window.location = "horario";
				</script>';
			}
		}
	}

	//ELIMINAR CLIENTE
	static public function ctrEliminarHorario()
	{
		if (isset($_GET["idHorario"])) {
			$tabla = "horarios";
			$datos = $_GET["idHorario"];
			$respuesta = ModeloHorario::mdlEliminarHorario($tabla, $datos);
			if ($respuesta == "ok") {
				echo '<script>
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "horario";
					</script>';
			} else {
				$errorMsg = $respuesta; // El mensaje de error que devuelve la función mdlEliminarHorario
				echo '<script>
					Swal.fire({
						type: "warning",
						title: "Error al borrar el horario",
						text: "' . $errorMsg . '",
						showConfirmButton: true,
						confirmButtonColor: "#627d72",
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "horario";
						}
					});
				</script>';
			}
		}
	}
}
