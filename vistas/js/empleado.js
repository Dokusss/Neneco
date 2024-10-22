//EDITAR EMPLEADO
$(".tablas").on("click", ".btnEditarEmpleado", function () {
	var idEmpleado = $(this).attr("idEmpleado");
	var datos = new FormData();
	datos.append("idEmpleado", idEmpleado);
	$.ajax({
		url: "ajax/empleado.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {
			$("#editarCodigo").val(respuesta["id"]);
			$("#editarCi").val(respuesta["ci"]);
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarAp1").val(respuesta["apellidop"]);
			$("#editarAp2").val(respuesta["apellidom"]);
			$("#editarDir").val(respuesta["direccion"]);
			$("#editarGenero").val(respuesta["genero"]);
			$("#editarGenero").html(respuesta["genero"]);
			$("#editarTelefono").val(respuesta["telefono"]);
			$("#editarFechaNac").val(respuesta["fechanac"]);
			$("#editarSueldo").val(respuesta["sueldo"]);
			$("#id").val(respuesta["id"]);
		}
	})
})
//REVISAR SI LA FECHA NO ES SUPERIOR AL AÑO ACTUAL Y EL EMPLEADO SEA MAYOR DE EDAD
$(".nuevoFechaNac").change(function () {
	$(".alert").remove();
	var fechaNacimiento = new Date($(this).val());
	var fechaActual = new Date();
	fechaActual.setHours(0, 0, 0, 0); // Ajusta la hora al inicio del día
	if (fechaNacimiento > fechaActual) {
		$(".nuevoFechaNac").parent().after('<div class="alert alert-warning" role="alert"> Verifique la fecha ingresada. Recuerda que la fecha no puede ser en el futuro. </div>');
		$(".nuevoFechaNac").val("");
	} else {
		// Calcula la edad
		var edad = fechaActual.getFullYear() - fechaNacimiento.getFullYear();
		var mes = fechaActual.getMonth() - fechaNacimiento.getMonth();
		if (mes < 0 || (mes === 0 && fechaActual.getDate() < fechaNacimiento.getDate())) {
			edad--;
		}
		if (edad < 18) {
			$(".nuevoFechaNac").parent().after('<div class="alert alert-warning" role="alert"> Verifique la fecha ingresada. El empleado debe ser mayor de 18 años. </div>');
			$(".nuevoFechaNac").val("");
		}
	}
});
//REVISAR SI EL CI NO ESTA REPETIDO
$(".nuevoCi").change(function () {
	$(".alert").remove();
	var ci = $(this).val();
	var datos = new FormData();
	datos.append("validarCi", ci);
	$.ajax({
		url: "ajax/empleado.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {
			if (respuesta) {
				$(".nuevoCi").parent().after('<div class="alert alert-warning" role="alert"> Verifique la cedula ingresada. La cedula ya ha sido registrada para otro empleado. </div>');
				$(".nuevoCi").val("");
			}
		}
	})
})
//REVISAR SI EL ID NO ESTA REPETIDO
$("#nuevoCodigo").change(function () {
	$(".alert").remove();
	var id = $(this).val();
	var datos = new FormData();
	datos.append("validarCodigo", id);
	$.ajax({
		url: "ajax/empleado.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {
			if (respuesta) {
				$("#nuevoCodigo").parent().after('<div class="alert alert-warning" role="alert"> Verifique el codigo ingresado. El codigo ya ha sido registrado para otro empleado. </div>');
				$("#nuevoCodigo").val("");
			}
		}
	})
})

/*=============================================
DAR DE BAJA EMPLEADOS
=============================================*/
$(".tablas").on("click", ".btnActivarE", function () {
	var id = $(this).attr("id");
	var estadoEmpleado = $(this).attr("estadoEmpleado");
	var datos = new FormData();
	datos.append("activarId", id);
	datos.append("activarEmpleado", estadoEmpleado);
	$.ajax({
		url: "ajax/empleado.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {

			if (respuesta != null) {
				sessionStorage.setItem("tActualizado", "true");
				window.location = "empleado";
			}
		}
	})

	if (estadoEmpleado == 0) {
		$(this).removeClass('btn-primary');
		$(this).addClass('btn-danger');
		$(this).html('Inactivo');
		$(this).attr('estadoEmpleado', 1);
	} else {
		$(this).addClass('btn-primary');
		$(this).removeClass('btn-danger');
		$(this).html('Activo');
		$(this).attr('estadoEmpleado', 0);
	}

})

