<?php

class ControladorFeriados
{
	/*=============================================
				MOSTRAR FERIADOS
			 =============================================*/

	static public function ctrMostrarFeriados($item, $valor)
	{

		$tabla = "feriados";

		$respuesta = ModeloFeriados::MdlMostrarFeriados($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
			 CREAR FERIADOS    
		  =============================================*/

	static public function ctrCrearFeriados()
	{

		if (isset($_POST["nuevoNombre"])) {

			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])) {

				// Supongamos que $_POST['nuevoFecha'] contiene la fecha del formulario	
				$nuevoFecha = $_POST['nuevoFechaF'];
				$formato = 'Y-m-d'; // El formato esperado

				$fecha = DateTime::createFromFormat($formato, $nuevoFecha);

				if ($fecha && $fecha->format($formato) === $nuevoFecha) {
					// La fecha es válida y está en el formato correcto

					$tabla = "feriados";

					$datos = array(
						"nombre" => $_POST["nuevoNombre"],
						"fecha" => $nuevoFecha
					);

					$respuesta = ModeloFeriados::mdlCrearFeriados($tabla, $datos);

					if ($respuesta == "ok") {

						echo '<script>
									Swal.fire({
										type: "success",
										title: "El feriado ha sido registrado correctamente",
										showConfirmButton: true,
										confirmButtonColor: "#627d72",
										confirmButtonText: "Cerrar"
									}).then(function(result) {
										if (result.value) {
											window.location = "feriados";
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
					title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
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