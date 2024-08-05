/*=============================================
EDITAR ANTICIPOS
=============================================*/
$(".tablas").on("click", ".btnEditarAnticipos", function () {
	var id = $(this).attr("id");
	var datos = new FormData();
	datos.append("id", id);

	$.ajax({
		url: "ajax/anticipos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			$("#editarFecha").val(respuesta["fecha"]);
			$("#editarMonto").val(respuesta["monto"]);
			$("#id").val(respuesta["id"]);

		}

	})


})