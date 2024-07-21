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

		if (isset($_POST["nuevoEntradaM"])) {

			$tabla = "horario";

			$datos = array(
				"horainiciom" => $_POST["nuevoEntradaM"],
				"horasalidam" => $_POST["nuevoSalidaM"],
				"horainiciot" => $_POST["nuevoEntradaT"],
				"horasalidat" => $_POST["nuevoSalidaT"],
				"estado" => 1
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
		}
	}

	/*=============================================
	EDITAR HORARIO
	=============================================*/

	static public function ctrEditarHorario()
	{

		if (isset($_POST["editarEntradaM"])) {

			$tabla = "horario";

			$datos = array(
				"id" => $_POST["id"],
				"horainiciom" => $_POST["editarEntradaM"],
				"horasalidam" => $_POST["editarSalidaM"],
				"horainiciot" => $_POST["editarEntradaT"],
				"horasalidat" => $_POST["editarSalidaT"]
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
