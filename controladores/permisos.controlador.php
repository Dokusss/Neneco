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
						// Guardar un indicador en sessionStorage
						sessionStorage.setItem("tRegistrado", "true");
						window.location = "permisos";
					</script>';
						}
					} else {
						echo '<script>
						// Guardar un indicador en sessionStorage
						sessionStorage.setItem("tError", "true");
						window.location = "permisos";
					</script>';
					}
				} else {
					echo '<script>
					// Guardar un indicador en sessionStorage
					sessionStorage.setItem("tError", "true");
					window.location = "permisos";
				</script>';
				}
			} else {
				echo '<script>
				// Guardar un indicador en sessionStorage
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

				// Supongamos que $_POST['editarFechaInicio'] contiene la fecha del formulario
				$editarFechaInicio = $_POST['editarFechaInicio'];
				$formato = 'Y-m-d';

				$fechaInicio = DateTime::createFromFormat($formato, $editarFechaInicio);

				if ($fechaInicio && $fechaInicio->format($formato) === $editarFechaInicio) {
					// La fecha es válida y está en el formato correcto

					// Supongamos que $_POST['editarFechaFin'] contiene la fecha del formulario
					$editarFechaFin = $_POST['editarFechaFin'];
					$formato = 'Y-m-d'; // El formato esperado

					$fechaFin = DateTime::createFromFormat($formato, $editarFechaFin);

					if ($fechaFin && $fechaFin->format($formato) === $editarFechaFin) {
						// La fecha es válida y está en el formato correcto

						$tabla = "permisos";

						$datos = array(
							"fechainicio" => $editarFechaInicio,
							"fechafin" => $editarFechaFin,
							"categoria" => $_POST["editarCategoria"],
							"motivo" => $_POST["editarMotivo"],
							"id" => $_POST["id"]
						);

						$respuesta = ModeloPermisos::mdlEditarPermisos($tabla, $datos);

						if ($respuesta == "ok") {

							echo '<script>
									Swal.fire({
										type: "success",
										title: "El permiso ha sido cambiado correctamente",
										showConfirmButton: true,
										confirmButtonColor: "#627d72",
										confirmButtonText: "Cerrar"
									}).then(function(result) {
										if (result.value) {
											window.location = "permisos";
										}
									});
									</script>';
						}
					} else {

						// La fecha no está en el formato correcto
						echo '<script>
					Swal.fire({
						type: "error",
						title: "¡La fecha de fin que ingresó está en un formato incorrecto!",
						showConfirmButton: true,
						confirmButtonColor: "#627d72",
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "permisos";
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
						confirmButtonColor: "#627d72",
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "permisos";
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
						window.location = "permisos";
					}
				});
				  
					  </script>';
			}
		}
	}

	/*=============================================
	   BORRAR PERMISOS
	   =============================================*/

	static public function ctrBorrarPermisos()
	{


		if (isset($_GET["id"])) {

			$tabla = "permisos";
			$datos = $_GET["id"];

			$respuesta = ModeloPermisos::mdlBorrarPermisos($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>

					Swal.fire({
						type: "success",
						title: "El permiso ha sido borrado correctamente",
						showConfirmButton: true,
						confirmButtonColor: "#627d72",
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "permisos";
						}
					});
					  
						</script>';
			}
		}
	}
}
