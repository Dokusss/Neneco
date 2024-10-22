
//EDITAR CARGO
$(".tablas").on("click", ".btnEditarCargo", function () {
	var idCargo = $(this).attr("idCargo");
	var datos = new FormData();
	datos.append("idCargo", idCargo);
	$.ajax({
		url: "ajax/cargo.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {
			$("#editarNombre").val(respuesta["nombre"]);
			$("#id").val(respuesta["id"]);
		}
	})
})
//REVISAR SI EL CI NO ESTA REPETIDO
$(".nuevoNombre").change(function () {
	$(".alert").remove();
	var nombre = $(this).val();
	var datos = new FormData();
	datos.append("nombre", nombre);
	$.ajax({
		url: "ajax/cargo.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {
			if (respuesta) {
				$(".nuevoNombre").parent().after('<div class="alert alert-warning" role="alert"> El cargo con ese nombre ya está registrado, por favor verifique. </div>');
				$(".nuevoNombre").val("");
			}
		}
	})
})
//ELIMINAR CARGO	
$(".tablas").on("click", ".btnEliminarCargo", function () {
	var idCargo = $(this).attr("idCargo");
	Swal.fire({
		type: 'warning',
		title: "¿Está seguro de borrar el cargo?",
		text: "¡Si no lo está puede cancelar la acción!",
		showCancelButton: true,
		confirmButtonColor: "#627d72",
		cancelButtonColor: "#f85359",
		cancelButtonText: "Cancelar",
		confirmButtonText: "Sí, borrar cargo"
	}).then(function (result) {
		if (result.value) {
			window.location = "index.php?rutas=cargo&idCargo=" + idCargo;
		}
	});
})