/*=============================================
EDITAR CARGO
=============================================*/
$(".tablas").on("click", ".btnEditarCargo", function () {
	var id = $(this).attr("id");
	var datos = new FormData();
	datos.append("id", id);

	$.ajax({
		url: "ajax/cargo.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			$("#editarNom").val(respuesta["nombre"]);
			$("#editarSueldo").val(respuesta["sueldo"]);
			$("#id").val(respuesta["id"]);

		}

	})


})