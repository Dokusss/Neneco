/*=============================================
SUBIENDO LA FOTO DEL USUARIO
=============================================*/
$(".nuevaFoto").change(function () {
	var imagen = this.files[0];

	/*=============================================
		VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
		=============================================*/

	if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

		$(".nuevaFoto").val("");

		Swal.fire({
			type: "error",
			title: "¡La imagen debe estar en formato JPG o PNG!",
			showConfirmButton: true,
			confirmButtonText: "Cerrar"
		}).then(function(result) {
			if (result.value) {
				window.location = "usuario";
			}
		});

	} else if (imagen["size"] > 2000000) {

		$(".nuevaFoto").val("");

		Swal.fire({
			type: "error",
			title: "¡La imagen no debe pesar más de 2MB!",
			showConfirmButton: true,
			confirmButtonText: "Cerrar"
		}).then(function(result) {
			if (result.value) {
				window.location = "usuario";
			}
		});

	} else {

		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on("load", function (event) {

			var rutaImagen = event.target.result;

			$(".previsualizar").attr("src", rutaImagen);

		})

	}
})

/*=============================================
EDITAR USUARIO
=============================================*/
$(".tablas").on("click", ".btnEditarUsuario", function () {

	var id = $(this).attr("id");
	var datos = new FormData();
	datos.append("id", id);

	$.ajax({

		url: "ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarUsuario").val(respuesta["usuario"]);
			$("#passwordActual").val(respuesta["password"]);
			$("#fotoActual").val(respuesta["foto"]);

		}

	});

})

/*=============================================
ACTIVAR USUARIO
=============================================*/
$(".tablas").on("click", ".btnActivar", function () {

	var id = $(this).attr("id");
	var estadoUsuario = $(this).attr("estadoUsuario");

	var datos = new FormData();
	datos.append("activarId", id);
	datos.append("activarUsuario", estadoUsuario);

	$.ajax({

		url: "ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {

			if (window.matchMedia("(max-width:767px)").matches) {

				Swal.fire({
					type: "success",
					title: "El usuario ha sido actualizado",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"
				}).then(function(result) {
					if (result.value) {
						window.location = "usuario";
					}
				});

			}

		}

	})

	if (estadoUsuario == 0) {

		$(this).removeClass('btn-primary');
		$(this).addClass('btn-danger');
		$(this).html('Desactivado');
		$(this).attr('estadoUsuario', 1);

	} else {

		$(this).addClass('btn-primary');
		$(this).removeClass('btn-danger');
		$(this).html('Activado');
		$(this).attr('estadoUsuario', 0);

	}

})

/*=============================================
REVISAR SI EL USUARIO YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoUsuario").change(function () {

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarUsuario", usuario);

	$.ajax({
		url: "ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			if (respuesta) {

				$("#nuevoUsuario").parent().after('<div class="alert alert-warning" role="alert"> Este usuario ya existe. </div>');  

				$("#nuevoUsuario").val("");

			}

		}

	})
})

/*=============================================
ELIMINAR USUARIO
=============================================*/
$(".tablas").on("click", ".btnEliminarUsuario", function () {

	var id = $(this).attr("id");
	var fotoUsuario = $(this).attr("fotoUsuario");
	var usuario = $(this).attr("usuario");

	Swal.fire({
		type: 'warning',
		title: "¿Está seguro de borrar el usuario?",
		text: "¡Si no lo está puede cancelar la acción!",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		cancelButtonText: "Cancelar",
		confirmButtonText: "Sí, borrar usuario!"
	}).then(function (result) {
		if (result.value) {
			window.location = "index.php?rutas=usuario&id=" + id + "&usuario=" + usuario + "&fotoUsuario=" + fotoUsuario;
		}
	});

})








