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
			 MOSTRAR DETALLE HORAS
			 =============================================*/

	public static function ctrMostrarDetalleHoras($item, $valor)
	{
		$tabla = "horasextras";
		$respuesta = ModeloHoras::mdlMostrarDetalleHoras($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
			 CREAR CARGO     
			 =============================================*/

	static public function ctrCrearHoras()
	{
		if (isset($_POST["nuevoFecha"])) {

			$fechaProporcionada = $_POST["nuevoFecha"];
			$fechaActual = date("Y-m-d");

			if ($fechaProporcionada > $fechaActual) {
				$tabla = "horasextras";
				$datos = array(
					"fecha" => $_POST["nuevoFecha"],
					"idhorario" => $_POST["nuevoHorario"],
					"tipo" => $_POST["nuevoTipo"],
					"empleados" => $_POST["empleados"]
				);

				$respuesta = ModeloHoras::mdlIngresarHoras($tabla, $datos);

				if ($respuesta == "ok") {
					echo '<script>
					   Swal.fire({
						   type: "success",
						   title: "Hora extra ha sido registrada correctamente",
						   showConfirmButton: true,
						   confirmButtonColor: "#627d72",
						   confirmButtonText: "Cerrar"
					   }).then(function(result) {
						   if (result.value) {
							   window.location = "horasextras";
						   }
					   });
					   </script>';
				}
			} else {
				echo '<script>
				   Swal.fire({
					   type: "error",
					   title: "¡Error en fecha!",
					   showConfirmButton: true,
					   confirmButtonColor: "#627d72",
					   confirmButtonText: "Cerrar"
				   }).then(function(result) {
					   if (result.value) {
						   window.location = "horasextras";
					   }
				   });
				   </script>';
			}
		}
	}

	/*=============================================
			 CREAR CARGO     
			 =============================================*/

	static public function ctrEditarHoras()
	{
		if (isset($_POST["editarFecha"])) {

			$fechaProporcionada = $_POST["editarFecha"];
			$fechaActual = date("Y-m-d");

			if ($fechaProporcionada > $fechaActual) {
				$tabla = "horasextras";
				$datos = array(
					"id" => $_POST["id"],
					"fecha" => $_POST["editarFecha"],
					"idhorario" => $_POST["editarHorario"],
					"tipo" => $_POST["editarTipo"],
					"empleados" => $_POST["empleados"]
				);

				$respuesta = ModeloHoras::mdlEditarHoras($tabla, $datos);

				if ($respuesta == "ok") {
					echo '<script>
							 Swal.fire({
								 type: "success",
								 title: "Hora extra ha sido editada correctamente",
								 showConfirmButton: true,
								 confirmButtonColor: "#627d72",
								 confirmButtonText: "Cerrar"
							 }).then(function(result) {
								 if (result.value) {
									 window.location = "horasextras";
								 }
							 });
							 </script>';
				}
			} else {
				echo '<script>
						 Swal.fire({
							 type: "error",
							 title: "¡Error en fecha!",
							 showConfirmButton: true,
							 confirmButtonColor: "#627d72",
							 confirmButtonText: "Cerrar"
						 }).then(function(result) {
							 if (result.value) {
								 window.location = "horasextras";
							 }
						 });
						 </script>';
			}
		}
	}

}
