//MOSTRAR TABLA EMPLEADOS
$(".tablas").on("click", ".btnModalEmpleados", function () {
	var idHorasExtras = $(this).attr("idHorasExtras");
	var datos = new FormData();
	datos.append("idHorasExtras", idHorasExtras);

	$.ajax({
		url: "ajax/detallehoras.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuestaHoras) {
			$("#tablaEmpleados tbody").empty();
			respuestaHoras.forEach(function (empleado) {
				var datosEmpleado = new FormData();
				datosEmpleado.append("idEmpleado", empleado.idempleado);

				$.ajax({
					url: "ajax/empleado.ajax.php",
					method: "POST",
					data: datosEmpleado,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success: function (respuestaEmpleado) {
						var apellidos = respuestaEmpleado["apellidop"] + " " + respuestaEmpleado["apellidom"];
						$("#tablaEmpleados tbody").append(
							'<tr>' +
							'<td>' + respuestaEmpleado["nombre"] + '</td>' +
							'<td>' + apellidos + '</td>' +
							'</tr>'
						);
					}
				});
			});
		}
	});
});

//REVISAR SI LA FECHA NO ES INFERIOR A LA FECHA ACTUAL
$(".nuevoFechaHorasExtras").change(function () {
	$(".alert").remove();
	var fecha = new Date($(this).val());
	var fechaActual = new Date();
	fechaActual.setDate(fechaActual.getDate() - 1);
	fechaActual.setHours(0, 0, 0, 0);
	if (fecha < fechaActual) {
		$(".nuevoFechaHorasExtras").parent().after('<div class="alert alert-warning" role="alert"> La fecha de  no puede ser menor a la fecha actual un día. </div>');
		$(".nuevoFechaHorasExtras").val("");
	}
});

//EDITAR CARGO
$(".tablas").on("click", ".btnEditarHoras", function () {
	var idHoraExtra = $(this).attr("idHoraExtra");
	var datos = new FormData();
	datos.append("idHoraExtra", idHoraExtra);

	$.ajax({
		url: "ajax/horas.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {
			var idHorasExtras = respuesta["id"];
			var datos = new FormData();
			datos.append("idHorasExtras", idHorasExtras);

			$.ajax({
				url: "ajax/detallehoras.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (respuestaHoras) {
					var empleadosSeleccionados = [];
					respuestaHoras.forEach(function (empleado) {
						var datosEmpleado = new FormData();
						datosEmpleado.append("idEmpleado", empleado.idempleado);

						$.ajax({
							url: "ajax/empleado.ajax.php",
							method: "POST",
							data: datosEmpleado,
							cache: false,
							contentType: false,
							processData: false,
							dataType: "json",
							success: function (respuestaEmpleado) {
								if (respuestaEmpleado) { // Asegúrate de que haya respuesta
									var apellidos = respuestaEmpleado["apellidop"] + " " + respuestaEmpleado["apellidom"];
									var nombreCompleto = respuestaEmpleado["nombre"] + " " + apellidos;
									empleadosSeleccionados.push(nombreCompleto);
									$("#listaEmpleados").val(empleadosSeleccionados.join(", "));
								}
							}
						});
					});
				}
			});
			$("#editarFecha").val(respuesta["fecha"]);
			$("#editarEntrada").val(respuesta["entrada"]);
			$("#editarSalida").val(respuesta["salida"]);
			$("#id").val(respuesta["id"]);
		}
	})
})