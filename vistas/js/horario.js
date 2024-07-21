/*=============================================
EDITAR HORARIO
=============================================*/
$(".tablas").on("click", ".btnEditarHorario", function () {

  var id = $(this).attr("id");
  var datos = new FormData();
  datos.append("id", id);

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
      $("#editarEntradaM").val(respuesta["horainiciom"]);
      $("#editarSalidaM").val(respuesta["horasalidam"]);
      $("#editarEntradaT").val(respuesta["horainiciot"]);
      $("#editarSalidaT").val(respuesta["horasalidat"]);

    }

  })

})

/*=============================================
ELIMINAR HORARIO
=============================================*/
$(".tablas").on("click", ".btnEliminarHorario", function () {

  var id = $(this).attr("id");

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
      window.location = "index.php?rutas=horario&id=" + id;
    }
  });

})