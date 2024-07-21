<?php

class ControladorHoras
{


    /*=============================================
	MOSTRAR HORAS
	=============================================*/

    static public function ctrMostrarHoras($item, $valor)
    {

        $tabla = "horasextras";

        $respuesta = ModeloHoras::MdlMostrarHoras($tabla, $item, $valor);

        return $respuesta;
    }

    /*=============================================
	CREAR CARGO     
	=============================================*/

	static public function ctrCrearHoras()
	{

		if (isset($_POST["nuevoFecha"])) {

			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ #,.\\-]+$/', $_POST["nuevoMotivo"])) {

				$tabla = "horasextras";

				$datos = array(
					"fecha" => $_POST["nuevoFecha"],
					"horainicio" => $_POST["nuevoHoraInicio"],
					"horafinal" => $_POST["nuevoHoraFinal"],
					"tipo" => $_POST["nuevoTipo"],
					"motivo" => $_POST["nuevoMotivo"],
					"idempleado"=> $_POST["nuevoEmpleado"]

				);

				$respuesta = ModeloHoras::mdlIngresarHoras($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

					Swal.fire({
						type: "success",
						title: "El cargo ha sido registrado correctamente",
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
}
