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
						   title: "El cargo ha sido registrado correctamente",
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
