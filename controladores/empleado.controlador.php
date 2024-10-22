<?php
class ControladorEmpleado
{
	//MOSTRAR EMPLEADO
	static public function ctrMostrarEmpleado($item, $valor)
	{
		$tabla = "empleados";
		$respuesta = ModeloEmpleado::MdlMostrarEmpleado($tabla, $item, $valor);
		return $respuesta;
	}
	//REGISTRAR EMPLEADO
	static public function ctrCrearEmpleado()
	{
		if (isset($_POST["nuevoNombre"])) {
			$fechaActual = new DateTime(); // Fecha y hora actual		
			if (
				preg_match('/^[0-9]+$/', $_POST["nuevoCodigo"]) &&
				preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["nuevoCi"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoAp1"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/', $_POST["nuevoAp2"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ #,.\/\\-]+$/', $_POST["nuevoDir"]) &&
				preg_match('/^[0-9]+$/', $_POST["nuevoTelefono"]) &&
				preg_match('/^[0-9.,]+$/', $_POST["nuevoSueldo"])
			) {
				$nuevoFechaNac = $_POST['nuevoFechaNac'];
				$formato = 'Y-m-d';
				$fechaNac = DateTime::createFromFormat($formato, $nuevoFechaNac);
				if ($fechaNac && $fechaNac->format($formato) === $nuevoFechaNac) {
					$tabla = "empleados";
					$datos = array(
						"idcargo" => $_POST["nuevoCargo"],
						"idhorario" => $_POST["nuevoHorario"],
						"id" => $_POST["nuevoCodigo"],
						"ci" => $_POST["nuevoCi"],
						"nombre" => $_POST["nuevoNombre"],
						"apellidop" => $_POST["nuevoAp1"],
						"apellidom" => $_POST["nuevoAp2"],
						"direccion" => $_POST["nuevoDir"],
						"genero" => $_POST["nuevoGenero"],
						"telefono" => $_POST["nuevoTelefono"],
						"fechanac" => $fechaNac->format('Y-m-d'),
						"fechareg" => $fechaActual->format('Y-m-d'), // Asegúrate de que este campo esté correctamente asignado
						"sueldo" => $_POST["nuevoSueldo"],
						"estado" => 1
					);
					$respuesta = ModeloEmpleado::mdlCrearEmpleado($tabla, $datos);
					if ($respuesta == "ok") {
						echo '<script>
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "empleado";
					</script>';
					}
				} else {
					echo '<script>
						sessionStorage.setItem("tError", "true");
						window.location = "empleado";
					</script>';
				}
			} else {
				echo '<script>
				sessionStorage.setItem("tError", "true");
				window.location = "empleado";
			</script>';
			}
		}
	}
	//EDITAR EMPLEADO
	static public function ctrEditarEmpleado()
	{
		if (isset($_POST["editarNombre"])) {
			$fechaActual = new DateTime(); // Fecha y hora actual		
			if (
				preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["editarCi"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarAp1"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/', $_POST["editarAp2"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ #,.\/\\-]+$/', $_POST["editarDir"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarTelefono"]) &&
				preg_match('/^[0-9.,]+$/', $_POST["editarSueldo"])
			) {
				$editarFechaNac = $_POST['editarFechaNac'];
				$formato = 'Y-m-d';
				$fechaNac = DateTime::createFromFormat($formato, $editarFechaNac);
				if ($fechaNac && $fechaNac->format($formato) === $editarFechaNac) {
					$tabla = "empleados";
					$datos = array(
						"id" => $_POST["id"],
						"idcargo" => $_POST["editarCargo"],
						"idhorario" => $_POST["editarHorario"],
						"ci" => $_POST["editarCi"],
						"nombre" => $_POST["editarNombre"],
						"apellidop" => $_POST["editarAp1"],
						"apellidom" => $_POST["editarAp2"],
						"direccion" => $_POST["editarDir"],
						"genero" => $_POST["editarGenero"],
						"telefono" => $_POST["editarTelefono"],
						"fechanac" => $fechaNac->format('Y-m-d'),
						"sueldo" => $_POST["editarSueldo"]
					);
					$respuesta = ModeloEmpleado::mdlEditarEmpleado($tabla, $datos);
					if ($respuesta == "ok") {
						echo '<script>
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "empleado";
					</script>';
					}
				} else {
					echo '<script>
						sessionStorage.setItem("tError", "true");
						window.location = "empleado";
					</script>';
				}
			} else {
				echo '<script>
				sessionStorage.setItem("tError", "true");
				window.location = "empleado";
			</script>';
			}
		}
	}
}
