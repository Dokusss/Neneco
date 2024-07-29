<?php

class ControladorEmpleado
{


	/*=============================================
	   MOSTRAR EMPLEADO
	=============================================*/

	static public function ctrMostrarEmpleado($item, $valor)
	{

		$tabla = "empleado";

		$respuesta = ModeloEmpleado::MdlMostrarEmpleado($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	   MOSTRAR EMPLEADO ORDENADO
	=============================================*/

	static public function ctrMostrarEmpleadoOdenado($item, $valor)
	{

		$tabla = "empleado";

		$respuesta = ModeloEmpleado::mdlMostrarEmpleadoOrdenado($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	   REGISTRAR EMPLEADO
	=============================================*/

	static public function ctrCrearEmpleado()
	{

		if (isset($_POST["nuevoNombre"])) {

			$fechaActual = new DateTime(); // Fecha y hora actual
			$fechaFormato = $fechaActual->format('Y-m-d'); // Formateando para SQL

			if (
				preg_match('/^[0-9]+$/', $_POST["nuevoCodigo"]) &&
				preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["nuevoCi"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoAp1"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/', $_POST["nuevoAp2"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ #,.\\-]+$/', $_POST["nuevoDir"])

			) {

				// Supongamos que $_POST['nuevoFechaNac'] contiene la fecha del formulario
				$fecha_input = $_POST['nuevoFechaNac'];
				$formato = 'Y-m-d'; // El formato esperado

				$fechaNacimiento = DateTime::createFromFormat($formato, $fecha_input);
				$fechaActual = new DateTime(); // Fecha actual

				if ($fechaNacimiento && $fechaNacimiento->format($formato) === $fecha_input) {
					// La fecha es válida y está en el formato correcto

					// Validación de que la fecha de nacimiento no sea futura
					if ($fechaNacimiento <= $fechaActual) {
						// Aquí procederías a insertar $fecha_input directamente en la base de datos

						$tabla = "empleado";

						$datos = array(
							"idcargo" => $_POST["nuevoCargo"],
							"idhorario" => $_POST["nuevoHorario"],
							"ci" => $_POST["nuevoCi"],
							"nombre" => $_POST["nuevoNombre"],
							"apellidop" => $_POST["nuevoAp1"],
							"apellidom" => $_POST["nuevoAp2"],
							"direccion" => $_POST["nuevoDir"],
							"genero" => $_POST["nuevoGenero"],
							"telefono" => $_POST["nuevoTelefono"],
							"fechanac" => $fecha_input,
							"fechareg" => $fechaActual->format('Y-m-d'), // Asegúrate de que este campo esté correctamente asignado
							"estado" => 1
						);

						$respuesta = ModeloEmpleado::mdlCrearEmpleado($tabla, $datos);

						if ($respuesta == "ok") {
							echo '<script>
								Swal.fire({
									type: "success",
									title: "El empleado ha sido registrado correctamente",
									showConfirmButton: true,
									confirmButtonColor: "#627d72",
									confirmButtonText: "Cerrar"
								}).then(function(result) {
									if (result.value) {
										window.location = "empleado";
									}
								});
								</script>';
						}
					} else {
						// Fecha de nacimiento es futura
						echo '<script>
						Swal.fire({
							type: "error",
							title: "¡La fecha de nacimiento no puede ser en el futuro!",
							showConfirmButton: true,
							confirmButtonColor: "#627d72",
							confirmButtonText: "Cerrar"
						}).then(function(result) {
							if (result.value) {
								window.location = "empleado";
							}
						});
						</script>';
					}
				} else {
					// La fecha no está en el formato correcto
					echo '<script>
					Swal.fire({
						type: "error",
						title: "¡La fecha que ingresó está en un formato incorrecto!",
						showConfirmButton: true,
						confirmButtonColor: "#627d72",
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "empleado";
						}
					});
					</script>';
				}
			} else {

				echo '<script>

				Swal.fire({
					type: "error",
					title: "¡El empleado no puede ir vacío o llevar caracteres especiales!",
					showConfirmButton: true,
					confirmButtonColor: "#627d72",
					confirmButtonText: "Cerrar"
				}).then(function(result) {
					if (result.value) {
						window.location = "empleado";
					}
				});
				  
					  </script>';
			}
		}
	}

	/*=============================================
	EDITAR EMPLEADO
	=============================================*/

	static public function ctrEditarEmpleado()
	{

		if (isset($_POST["editarNombre"])) {

			$fechaActual = new DateTime(); // Fecha y hora actual
			$fechaFormato = $fechaActual->format('Y-m-d'); // Formateando para SQL

			if (
				preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["editarCi"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarAp1"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/', $_POST["editarAp2"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ #,.\\-]+$/', $_POST["editarDir"]) &&
				preg_match('/^(\(\d{3}\)\d{8})?$/', $_POST["nuevoTelefono"])

			) {

				// Supongamos que $_POST['editarFechaNac'] contiene la fecha del formulario
				$fecha_input = $_POST['editarFechaNac'];
				$formato = 'Y-m-d'; // El formato esperado

				$fechaNacimiento = DateTime::createFromFormat($formato, $fecha_input);
				$fechaActual = new DateTime(); // Fecha actual

				if ($fechaNacimiento && $fechaNacimiento->format($formato) === $fecha_input) {
					// La fecha es válida y está en el formato correcto

					// Validación de que la fecha de nacimiento no sea futura
					if ($fechaNacimiento <= $fechaActual) {
						// Aquí procederías a insertar $fecha_input directamente en la base de datos

						$tabla = "empleado";

						$datos = array(
							"idcargo" => $_POST["editarCargo"],
							"idhorario" => $_POST["editarHorario"],
							"ci" => $_POST["editarCi"],
							"nombre" => $_POST["editarNombre"],
							"apellidop" => $_POST["editarAp1"],
							"apellidom" => $_POST["editarAp2"],
							"direccion" => $_POST["editarDir"],
							"genero" => $_POST["editarGenero"],
							"telefono" => $_POST["editarTelefono"],
							"fechanac" => $fecha_input,
							"fechareg" => $fechaActual->format('Y-m-d'), // Asegúrate de que este campo esté correctamente asignado
							"id" => $_POST["id"]
						);

						$respuesta = ModeloEmpleado::mdlEditarEmpleado($tabla, $datos);

						if ($respuesta == "ok") {
							echo '<script>
								Swal.fire({
									type: "success",
									title: "Se cambiarion los datos del empleado correctamente",
									showConfirmButton: true,
									confirmButtonColor: "#627d72",
									confirmButtonText: "Cerrar"
								}).then(function(result) {
									if (result.value) {
										window.location = "empleado";
									}
								});
								</script>';
						}
					} else {
						// Fecha de nacimiento es futura
						echo '<script>
						Swal.fire({
							type: "error",
							title: "¡La fecha de nacimiento no puede ser en el futuro!",
							showConfirmButton: true,
							confirmButtonColor: "#627d72",
							confirmButtonText: "Cerrar"
						}).then(function(result) {
							if (result.value) {
								window.location = "empleado";
							}
						});
						</script>';
					}
				} else {
					// La fecha no está en el formato correcto
					echo '<script>
					Swal.fire({
						type: "error",
						title: "¡La fecha que ingresó está en un formato incorrecto!",
						showConfirmButton: true,
						confirmButtonColor: "#627d72",
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "empleado";
						}
					});
					</script>';
				}
			} else {

				echo '<script>

				Swal.fire({
					type: "error",
					title: "¡El empleado no puede ir vacío o llevar caracteres especiales!",
					showConfirmButton: true,
					confirmButtonColor: "#627d72",
					confirmButtonText: "Cerrar"
				}).then(function(result) {
					if (result.value) {
						window.location = "empleado";
					}
				});
				  
					  </script>';
			}
		}
	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	// static public function ctrBorrarEmpleado()
	// {

	// 	if (isset($_GET["id"])) {

	// 		$tabla = "empleado";
	// 		$datos = array(
	// 			"id" => $_GET["id"],
	// 			"estado" => 0
	// 		);

	// 		$respuesta = ModeloEmpleado::mdlBorrarEmpleado($tabla, $datos);

	// 		if ($respuesta == "ok") {

	// 			echo '<script>

	// 			Swal.fire({
	// 				type: "success",
	// 				title: "El empleado ha sido borrado correctamente",
	// 				showConfirmButton: true,
	// 				confirmButtonColor: "#627d72",
	// 				confirmButtonText: "Cerrar"
	// 			}).then(function(result) {
	// 				if (result.value) {
	// 					window.location = "empleado";
	// 				}
	// 			});
			

	// 			</script>';
	// 		}
	// 	}
	// }
}
