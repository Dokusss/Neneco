$(document).ready(function () {
	// Configuración de Toastr
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}

	// Verificar si el indicador está en sessionStorage
	if (sessionStorage.getItem("cargoRegistrado") === "true") {
		// Mostrar la notificación Toastr
		toastr["success"]("Datos registrados correctamente.", "Exito!");

		// Eliminar el indicador de sessionStorage
		sessionStorage.removeItem("cargoRegistrado");
	}
});

$(document).ready(function () {
	// Configuración de Toastr
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}

	// Verificar si el indicador está en sessionStorage
	if (sessionStorage.getItem("cargoError") === "true") {
		// Mostrar la notificación Toastr
		toastr["error"]("Datos en formato incorrecto.", "Error!");

		// Eliminar el indicador de sessionStorage
		sessionStorage.removeItem("cargoError");
	}
});

/*=============================================
EDITAR CARGO
=============================================*/
$(".tablaCargo").on("click", ".btnEditarCargo", function () {
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

/*=============================================
REVISAR SI EL CI NO ESTA REPETIDO
=============================================*/

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

				$(".nuevoNombre").parent().after('<div class="alert alert-warning" role="alert"> Lo siento, ya existe un cargo registrado con ese nombre. </div>');

				$(".nuevoNombre").val("");

			}

		}

	})
})

/*=============================================
ELIMINAR CARGO	
=============================================*/
$(".tablaCargo").on("click", ".btnEliminarCargo", function () {

	var id = $(this).attr("id");

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
			window.location = "index.php?rutas=cargo&id=" + id;
		}
	});

})

/*=============================================
CARGAR LA TABLA DINAMICA DE CARGO
=============================================*/
$.ajax({
	url: "ajax/datatable-cargo.ajax.php",
	success: function (respuesta) {
		//console.log(respuesta);
	}
});

$('.tablaCargo').DataTable({
	"ajax": "ajax/datatable-cargo.ajax.php",
	"language": {

		"sProcessing": "Procesando...",
		"sLengthMenu": "Mostrar _MENU_ registros",
		"sZeroRecords": "No se encontraron resultados",
		"sEmptyTable": "Ningún dato disponible en esta tabla",
		"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix": "",
		"sSearch": "Buscar:",
		"sUrl": "",
		"sInfoThousands": ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
			"sFirst": "Primero",
			"sLast": "Último",
			"sNext": "Siguiente",
			"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	}
});