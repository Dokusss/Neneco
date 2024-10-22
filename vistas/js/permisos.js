//EDITAR PERMISO
$(".tablas").on("click", ".btnEditarPermisos", function () {
    var idPermiso = $(this).attr("idPermiso");
    var datos = new FormData();
    datos.append("idPermiso", idPermiso);

    $.ajax({
        url: "ajax/permisos.ajax.php",
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
            $("#editarFechaInicio").val(respuesta["fechainicio"]);
            $("#editarFechaFin").val(respuesta["fechafin"]);
            $("#editarMotivo").val(respuesta["motivo"]);
            $("#id").val(respuesta["id"]);
        }
    })
})

//REVISAR SI LA FECHA NO ES INFERIOR A LA FECHA ACTUAL
$(".nuevoFechaInicio").change(function () {
    $(".alert").remove();
    var fechaInicio = new Date($(this).val());
    var fechaActual = new Date();
    fechaActual.setDate(fechaActual.getDate() - 1);
    fechaActual.setHours(0, 0, 0, 0);
    if (fechaInicio < fechaActual) {
        $(".nuevoFechaInicio").parent().after('<div class="alert alert-warning" role="alert"> La fecha de inicio no puede ser menor a la fecha actual un día. </div>');
        $(".nuevoFechaInicio").val("");
    }
});