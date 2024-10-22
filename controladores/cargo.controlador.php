<?php
class ControladorCargo
{
	//MOSTRAR CARGO
	static public function ctrMostrarCargo($item, $valor)
	{
		$tabla = "cargos";
		$respuesta = ModeloCargo::MdlMostrarCargo($tabla, $item, $valor);
		return $respuesta;
	}
	//CREAR CARGO     
	static public function ctrCrearCargo()
	{
		if (isset($_POST["nuevoNombre"])) {
			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])) {
				$tabla = "cargos";
				$datos = array(
					"nombre" => $_POST["nuevoNombre"]
				);
				$respuesta = ModeloCargo::mdlIngresarCargo($tabla, $datos);
				if ($respuesta == "ok") {
					echo '<script>
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "cargo";
					</script>';
				}
			} else {
				echo '<script>
						sessionStorage.setItem("tError", "true");
						window.location = "cargo";
					</script>';
			}
		}
	}
	//EDITAR CARGO
	static public function ctrEditarCargo()
	{
		if (isset($_POST["editarNombre"])) {
			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])) {
				$tabla = "cargos";
				$datos = array(
					"nombre" => $_POST["editarNombre"],
					"id" => $_POST["id"]
				);
				$respuesta = ModeloCargo::mdlEditarCargo($tabla, $datos);
				if ($respuesta == "ok") {
					echo '<script>
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "cargo";
					</script>';
				}
			} else {
				echo '<script>
						sessionStorage.setItem("tError", "true");
						window.location = "cargo";
					</script>';
			}
		}
	}
	//BORRAR CARGO
	static public function ctrBorrarCargo()
	{
		if (isset($_GET["idCargo"])) {
			$tabla = "cargos";
			$datos = $_GET["idCargo"];
			$respuesta = ModeloCargo::mdlBorrarCargo($tabla, $datos);
			if ($respuesta == "ok") {
				echo '<script>
						sessionStorage.setItem("tEliminar", "true");
						window.location = "cargo";
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
