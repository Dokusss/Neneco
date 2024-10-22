<?php

class ControladorPermisos
{

	/*=============================================
			 MOSTRAR PERMISOS
		  =============================================*/
	static public function ctrMostrarPermisos($item, $valor)
	{
		$tabla = "permisos";
		$respuesta = ModeloPermisos::MdlMostrarPermisos($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
		  CREAR PERMISOS     
	   =============================================*/
	static public function ctrCrearPermisos()
	{
		if (isset($_POST["nuevoEmpleado"])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoMotivo"])) {
				$nuevoFechaInicio = $_POST['nuevoFechaInicio'];
				$formato = 'Y-m-d';
				$fechaInicio = DateTime::createFromFormat($formato, $nuevoFechaInicio);
				if ($fechaInicio && $fechaInicio->format($formato) === $nuevoFechaInicio) {
					$nuevoFechaFin = $_POST['nuevoFechaFin'];
					$formato = 'Y-m-d';
					$fechaFin = DateTime::createFromFormat($formato, $nuevoFechaFin);
					if ($fechaFin && $fechaFin->format($formato) === $nuevoFechaFin) {
						$tabla = "permisos";
						$datos = array(
							"idempleado" => $_POST["nuevoEmpleado"],
							"fechainicio" => $nuevoFechaInicio,
							"fechafin" => $nuevoFechaFin,
							"motivo" => $_POST["nuevoMotivo"]
						);
						$respuesta = ModeloPermisos::mdlCrearPermiso($tabla, $datos);
						if ($respuesta == "ok") {
							echo '<script>
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "permisos";
					</script>';
						}
					} else {
						echo '<script>
						sessionStorage.setItem("tError", "true");
						window.location = "permisos";
					</script>';
					}
				} else {
					echo '<script>
					sessionStorage.setItem("tError", "true");
					window.location = "permisos";
				</script>';
				}
			} else {
				echo '<script>
				sessionStorage.setItem("tError", "true");
				window.location = "permisos";
			</script>';
			}
		}
	}

	/*=============================================
		  EDITAR PERMISOS     
	   =============================================*/
	static public function ctrEditarPermisos()
	{
		if (isset($_POST["id"])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarMotivo"])) {
				$editarFechaInicio = $_POST['editarFechaInicio'];
				$formato = 'Y-m-d';
				$fechaInicio = DateTime::createFromFormat($formato, $editarFechaInicio);
				if ($fechaInicio && $fechaInicio->format($formato) === $editarFechaInicio) {
					$editarFechaFin = $_POST['editarFechaFin'];
					$formato = 'Y-m-d';
					$fechaFin = DateTime::createFromFormat($formato, $editarFechaFin);
					if ($fechaFin && $fechaFin->format($formato) === $editarFechaFin) {
						$tabla = "permisos";
						$datos = array(
							"fechainicio" => $editarFechaInicio,
							"fechafin" => $editarFechaFin,
							"motivo" => $_POST["editarMotivo"],
							"id" => $_POST["id"]
						);
						$respuesta = ModeloPermisos::mdlEditarPermisos($tabla, $datos);
						if ($respuesta == "ok") {
							echo '<script>
							sessionStorage.setItem("tRegistrado", "true");
							window.location = "permisos";
						</script>';
						}
					} else {
						echo '<script>
					sessionStorage.setItem("tError", "true");
					window.location = "permisos";
				</script>';
					}
				} else {
					echo '<script>
					sessionStorage.setItem("tError", "true");
					window.location = "permisos";
				</script>';
				}
			} else {
				echo '<script>
					sessionStorage.setItem("tError", "true");
					window.location = "permisos";
				</script>';
			}
		}
	}
}
