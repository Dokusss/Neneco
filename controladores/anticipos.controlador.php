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
				$nuevoFecha = $_POST['nuevoFecha'];
				$formato = 'Y-m-d';
				$fecha = DateTime::createFromFormat($formato, $nuevoFecha);
				if ($fecha && $fecha->format($formato) === $nuevoFecha) {
					$tabla = "anticipos";
					$datos = array(
						"idempleado" => $_POST["nuevoEmpleado"],
						"fecha" => $nuevoFecha,
						"monto" => $_POST["nuevoMonto"]
					);
					$respuesta = ModeloAnticipos::mdlCrearAnticipos($tabla, $datos);
					if ($respuesta == "ok") {
						echo '<script>
						// Guardar un indicador en sessionStorage
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "anticipos";
					</script>';
					}

				} else {
					echo '<script>
						// Guardar un indicador en sessionStorage
						sessionStorage.setItem("tError", "true");
						window.location = "anticipos";
					</script>';
				}
			} else {
				echo '<script>
						// Guardar un indicador en sessionStorage
						sessionStorage.setItem("tError", "true");
						window.location = "anticipos";
					</script>';
			}
		}
	}

	/*=============================================
				   EDITAR ANTICIPOS     
				=============================================*/
	static public function ctrEditarAnticipos()
	{
		if (isset($_POST["editarMonto"])) {
			if (preg_match('/^[0-9.,]+$/', $_POST["editarMonto"])) {
				$tabla = "anticipos";
				$datos = array(
					"id" => $_POST["id"],
					"monto" => $_POST["editarMonto"]
				);
				$respuesta = ModeloAnticipos::mdlEditarAnticipos($tabla, $datos);
				if ($respuesta == "ok") {
					echo '<script>
							  // Guardar un indicador en sessionStorage
							  sessionStorage.setItem("tRegistrado", "true");
							  window.location = "anticipos";
						  </script>';
				}
			} else {
				echo '<script>
							  // Guardar un indicador en sessionStorage
							  sessionStorage.setItem("tError", "true");
							  window.location = "anticipos";
						  </script>';
			}
		}
	}
}