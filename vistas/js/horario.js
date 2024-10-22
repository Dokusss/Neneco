//EDITAR HORARIO
$(".tablas").on("click", ".btnEditarHorario", function () {
  var idHorario = $(this).attr("idHorario");
  var datos = new FormData();
  datos.append("idHorario", idHorario);
  $.ajax({
    url: "ajax/horario.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#id").val(respuesta["id"]);
      $("#editarFecha").val(respuesta["fecha"]);
      $("#editarEntrada1").val(respuesta["entrada1"]);
      $("#editarSalida1").val(respuesta["salida1"]);
      $("#editarEntrada2").val(respuesta["entrada2"]);
      $("#editarSalida2").val(respuesta["salida2"]);
    }
  })
})
//REVISAR SI LA FECHA NO ES INFERIOR A LA FECHA ACTUAL
$(".nuevoFechaHorario").change(function () {
	$(".alert").remove();
	var fecha = new Date($(this).val());
	var fechaActual = new Date();
	fechaActual.setDate(fechaActual.getDate() - 1);
	fechaActual.setHours(0, 0, 0, 0);
	if (fecha < fechaActual) {
		$(".nuevoFechaHorario").parent().after('<div class="alert alert-warning" role="alert"> La fecha de  no puede ser menor a la fecha actual un día. </div>');
		$(".nuevoFechaHorario").val("");
	}
});
//ELIMINAR HORARIO
$(".tablas").on("click", ".btnEliminarHorario", function () {
  var idHorario = $(this).attr("idHorario");
  Swal.fire({
    type: 'warning',
    title: "¿Está seguro de borrar el horario?",
    text: "¡Si no lo está puede cancelar la acción!",
    showCancelButton: true,
    confirmButtonColor: "#627d72",
    cancelButtonColor: "#f85359",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Sí, borrar horario"
  }).then(function (result) {
    if (result.value) {
      window.location = "index.php?rutas=horario&idHorario=" + idHorario;
    }
  });

})