//INSERTAR FECHA ACTUAL AL ABRIR MODAL
$("#modalRegistrarAnticipo").on("shown.bs.modal", function () {
	// Obtener la fecha actual del sistema
	var fechaActual = new Date();
	// Formatear la fecha en formato YYYY-MM-DD
	var dia = ("0" + fechaActual.getDate()).slice(-2); // Agregar 0 a los días menores a 10
	var mes = ("0" + (fechaActual.getMonth() + 1)).slice(-2); // Meses de 0 a 11, por eso sumamos 1
	var año = fechaActual.getFullYear();
	var fechaFormateada = año + "-" + mes + "-" + dia;
	$("#nuevoFecha").val(fechaFormateada);
});
//EDITAR ANTICIPOS
$(".tablas").on("click", ".btnEditarAnticipo", function () {
	var idAnticipos = $(this).attr("idAnticipos");
	var datos = new FormData();
	datos.append("idAnticipos", idAnticipos);

	$.ajax({
		url: "ajax/anticipos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {
			var idEmpleado = respuesta["idempleado"];
			var datosEmpleado = new FormData();
			datosEmpleado.append("idEmpleado", idEmpleado);

			$.ajax({
				url: "ajax/empleado.ajax.php",
				method: "POST",
				data: datosEmpleado,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (respuestaEmpleado) {
					var nombreCompleto = respuestaEmpleado["nombre"] + " " + respuestaEmpleado["apellidop"] + " " + (respuestaEmpleado["apellidom"] || "");
					$("#editarEmpleado").val(nombreCompleto);
				}
			});
			$("#editarFecha").val(respuesta["fecha"]);
			$("#editarMonto").val(respuesta["monto"]);
			$("#id").val(respuesta["id"]);
		}
	});
});
