/*=============================================
EDITAR PERMISO
=============================================*/
$(".tablas").on("click", ".btnEditarPermisos", function () {

    var id = $(this).attr("id");
    var datos = new FormData();
    datos.append("id", id);

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

            // Aquí debes crear un nuevo FormData con el idEmpleado
            var datosEmpleado = new FormData();
            datosEmpleado.append("id", idEmpleado);

            $.ajax({

                url: "ajax/empleado.ajax.php",
                method: "POST",
                data: datosEmpleado,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (respuesta) {

                    var nombre = respuesta["nombre"];
                    var apellido1 = respuesta["apellido1"];
                    var apellido2 = respuesta["apellido2"];

                    $("#mostrarEmpleado").val(nombre + " " + apellido1 + " " + apellido2);

                }

            })

            $("#editarFechaInicio").val(respuesta["fechainicio"]);
            $("#editarFechaFin").val(respuesta["fechafin"]);
            $("#editarMotivo").val(respuesta["motivo"]);
            $("#editarCategoria").val(respuesta["categoria"]);
            $("#id").val(respuesta["id"]);

        }

    })
})

/*=============================================
REVISAR SI LA FECHA NO ES INFERIOR A LA FECHA ACTUAL
=============================================*/
$(".nuevoFechaInicio").change(function () {

    $(".alert").remove();

    var fechaInicio = new Date($(this).val());
    var fechaActual = new Date();
    fechaActual.setHours(0, 0, 0, 0); // Ajusta la hora al inicio del día

    if (fechaInicio < fechaActual) {
        $(".nuevoFechaInicio").parent().after('<div class="alert alert-warning" role="alert"> La fecha de inicio no puede ser inferior a la fecha actual. </div>');
        $(".nuevoFechaInicio").val("");
    }
});

/*=============================================
ELIMINAR PERMISO	
=============================================*/
$(".tablas").on("click", ".btnEliminarPermisos", function () {

    var id = $(this).attr("id");

    Swal.fire({
        type: 'warning',
        title: "¿Está seguro de borrar el cargo?",
        text: "¡Si no lo está puede cancelar la acción!",
        showCancelButton: true,
        confirmButtonColor: "#627d72",
        cancelButtonColor: "#f85359",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, borrar permiso"
    }).then(function (result) {
        if (result.value) {
            window.location = "index.php?rutas=permisos&id=" + id;
        }
    });

})