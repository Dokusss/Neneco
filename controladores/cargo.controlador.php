<?php

class ControladorCargo
{


	/*=============================================
	   MOSTRAR CARGO
	   =============================================*/

	static public function ctrMostrarCargo($item, $valor)
	{

		$tabla = "cargo";

		$respuesta = ModeloCargo::MdlMostrarCargo($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	   CREAR CARGO     
	   =============================================*/

	static public function ctrCrearCargo()
	{

		if (isset($_POST["nuevoCargo"])) {

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCargo"])) {

				$tabla = "cargo";

				$datos = array(
					"nombre" => $_POST["nuevoCargo"],
					"sueldo" => $_POST["nuevoSueldo"]
				);

				$respuesta = ModeloCargo::mdlIngresarCargo($tabla, $datos);

				if ($respuesta == "ok") {
					echo '<script>
						// Guardar un indicador en sessionStorage
						sessionStorage.setItem("cargoRegistrado", "true");
				
						// Redirigir a la página "cargo"
						window.location = "cargo";
					</script>';
				}
			} else {

				echo '<script>
						// Guardar un indicador en sessionStorage
						sessionStorage.setItem("cargoError", "true");
				
						// Redirigir a la página "cargo"
						window.location = "cargo";
					</script>';
			}
		}
	}

	/*=============================================
	   EDITAR CARGO
	   =============================================*/

	static public function ctrEditarCargo()
	{

		if (isset($_POST["editarNom"])) {

			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNom"])) {

				$tabla = "cargo";

				$datos = array(
					"nombre" => $_POST["editarNom"],
					"sueldo" => $_POST["editarSueldo"],
					"id" => $_POST["id"]
				);

				$respuesta = ModeloCargo::mdlEditarCargo($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

					Swal.fire({
						type: "success",
						title: "El cargo ha sido editado correctamente",
						showConfirmButton: true,
						confirmButtonColor: "#627d72",
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "cargo";
						}
					});
					  
						</script>';
				}
			} else {

				echo '<script>

				Swal.fire({
					type: "error",
					title: "¡El cargo no puede ir vacío o llevar caracteres especiales!",
					showConfirmButton: true,
					confirmButtonColor: "#627d72",
					confirmButtonText: "Cerrar"
				}).then(function(result) {
					if (result.value) {
						window.location = "cargo";
					}
				});
				  
					  </script>';
			}
		}
	}

	/*=============================================
	   BORRAR CARGO
	   =============================================*/

	static public function ctrBorrarCargo()
	{
		if (isset($_GET["id"])) {

			$tabla = "cargo";
			$datos = $_GET["id"];

			$respuesta = ModeloCargo::mdlBorrarCargo($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>
					Swal.fire({
						type: "success",
						title: "El cargo ha sido borrado correctamente",
						showConfirmButton: true,
						confirmButtonColor: "#627d72",
						confirmButtonText: "Cerrar"
					}).then(function(result) {
					if (result.value) {
						window.location = "cargo";
					}
				});
				</script>';
			} else {

				$errorMsg = $respuesta; // El mensaje de error que devuelve la función mdlBorrarCargo

				echo '<script>
					Swal.fire({
						type: "warning",
						title: "Error al borrar el cargo",
						text: "' . $errorMsg . '",
						showConfirmButton: true,
						confirmButtonColor: "#627d72",
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "cargo";
						}
					});
				</script>';
			}
		}
	}
}
