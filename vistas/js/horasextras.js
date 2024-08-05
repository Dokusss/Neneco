/*=============================================
EDITAR CARGO
=============================================*/
$(".tablas").on("click", ".btnEditarHoras", function () {
	var id = $(this).attr("id");
	var datos = new FormData();
	datos.append("id", id);

	$.ajax({
		url: "ajax/horas.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {
			//console.log(respuesta);

			$("#editarFecha").val(respuesta["fecha"]);
			$("#editarTipo").val(respuesta["tipo"]);
			$("#id").val(respuesta["id"]);

		}

	})


})