<?php

class ControladorHorario
{


	/*=============================================
				MOSTRAR EMPLEADO
				=============================================*/

	static public function ctrMostrarHorario($item, $valor)
	{

		$tabla = "horario";

		$respuesta = ModeloHorario::MdlMostrarHorario($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
			 CREAR HORARIO
			 =============================================*/

	static public function ctrCrearHorario()
	{

		if (isset($_POST["nuevoNombre"])) {

			if (
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])
			) {
				$tabla = "horario";

				$datos = array(
					"nombre" => $_POST["nuevoNombre"],
					"entrada1" => $_POST["nuevoEntrada1"],
					"salida1" => $_POST["nuevoSalida1"],
					"entrada2" => $_POST["nuevoEntrada2"],
					"salida2" => $_POST["nuevoSalida2"]
				);

				$respuesta = ModeloHorario::mdlIngresarHorario($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

					Swal.fire({
						type: "success",
						title: "El horario ha sido guardado correctamente",
						showConfirmButton: true,
						confirmButtonColor: "#627d72",
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "horario";
						}
					});
					  
						</script>';
				} else {

					echo '<script>

				Swal.fire({
					type: "error",
					title: "¡El horario no puede ir vacío o llevar caracteres especiales!",
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
			} else {
				echo '<script>
			Swal.fire({
				type: "error",
				title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
				showConfirmButton: true,
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

	/*=============================================
			 EDITAR HORARIO
			 =============================================*/

	static public function ctrEditarHorario()
	{

		if (isset($_POST["editarNombre"])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])) {

				$tabla = "horario";

				$datos = array(
					"id" => $_POST["id"],
					"nombre" => $_POST["editarNombre"],
					"entrada1" => $_POST["editarEntrada1"],
					"salida1" => $_POST["editarSalida1"],
					"entrada2" => $_POST["editarEntrada2"],
					"salida2" => $_POST["editarSalida2"]
				);

				$respuesta = ModeloHorario::mdlEditarHorario($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

					Swal.fire({
						type: "success",
						title: "El horario ha sido editado correctamente",
						showConfirmButton: true,
						confirmButtonColor: "#627d72",
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "horario";
						}
					});
					  
						</script>';
				} else {

					echo '<script>

				Swal.fire({
					type: "error",
					title: "¡El horario no puede ir vacío o llevar caracteres especiales!",
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
			} else {

				echo '<script>

			Swal.fire({
				type: "error",
				title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
				showConfirmButton: true,
				confirmButtonText: "Cerrar"
			}).then(function(result) {
				if (result.value) {
					window.location = "usuario";
				}
			});

			  </script>';
			}
		}
	}

	/*=============================================
			 ELIMINAR CLIENTE
			 =============================================*/

	static public function ctrEliminarHorario()
	{

		if (isset($_GET["id"])) {

			$tabla = "horario";
			$datos = $_GET["id"];

			$respuesta = ModeloHorario::mdlEliminarHorario($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>

					Swal.fire({
						type: "success",
						title: "El horario ha sido editado correctamente",
						showConfirmButton: true,
						confirmButtonColor: "#627d72",
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "horario";
						}
					});
					  
						</script>';
			} else {

				$errorMsg = $respuesta; // El mensaje de error que devuelve la función mdlBorrarCargo

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
