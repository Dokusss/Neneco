<?php

class ControladorAnticipos
{


	/*=============================================
				MOSTRAR ANTICIPOS
			 =============================================*/

	static public function ctrMostrarAnticipos($item, $valor)
	{

		$tabla = "anticipos";

		$respuesta = ModeloAnticipos::MdlMostrarAnticipos($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
			 CREAR ANTICIPOS     
		  =============================================*/

	static public function ctrCrearAnticipos()
	{

		if (isset($_POST["nuevoEmpleado"])) {

			if (preg_match('/^[0-9.,]+$/', $_POST["nuevoMonto"])) {

				// Supongamos que $_POST['nuevoFecha'] contiene la fecha del formulario
				$nuevoFecha = $_POST['nuevoFecha'];
				$formato = 'Y-m-d'; // El formato esperado

				$fecha = DateTime::createFromFormat($formato, $nuevoFecha);

				if ($fecha && $fecha->format($formato) === $nuevoFecha) {
					// La fecha es válida y está en el formato correcto

					$tabla = "anticipos";

					$datos = array(
						"idempleado" => $_POST["nuevoEmpleado"],
						"fecha" => $nuevoFecha,
						"monto" => $_POST["nuevoMonto"]
					);

					$respuesta = ModeloAnticipos::mdlCrearAnticipos($tabla, $datos);

					if ($respuesta == "ok") {

						echo '<script>
									Swal.fire({
										type: "success",
										title: "El permiso ha sido registrado correctamente",
										showConfirmButton: true,
										confirmButtonColor: "#627d72",
										confirmButtonText: "Cerrar"
									}).then(function(result) {
										if (result.value) {
											window.location = "anticipos";
										}
									});
									</script>';
					}

				} else {

					// La fecha no está en el formato correcto
					echo '<script>
					Swal.fire({
						type: "error",
						title: "¡La fecha de inicio que ingresó está en un formato incorrecto!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "anticipos";
						}
					});
					</script>';
				}
			} else {

				echo '<script>

				Swal.fire({
					type: "error",
					title: "¡El motivo no puede ir vacío o llevar caracteres especiales!",
					showConfirmButton: true,
					confirmButtonColor: "#627d72",
					confirmButtonText: "Cerrar"
				}).then(function(result) {
					if (result.value) {
						window.location = "anticipos";
					}
				});
				  
					  </script>';
			}
		}
	}
}