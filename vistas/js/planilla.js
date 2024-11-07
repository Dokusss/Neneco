$("#fechaInicioP").change(function () {

    $(".alert").remove();

    var fechaIngresada = new Date($(this).val());
    var fechaActual = new Date();
    fechaActual.setHours(0, 0, 0, 0); // Ajusta la hora al inicio del día

    if (fechaIngresada > fechaActual) {
        $("#fechaInicioP").parent().after('<div class="alert alert-warning" role="alert"> Verifique la fecha ingresada. La fecha no puede ser mayor a la fecha actual. </div>');
        $("#fechaInicioP").val("");
    }
});

$("#fechaInicioP").change(function () {
    var fechaInicio = new Date($(this).val());
    var dia = fechaInicio.getDay(); // 0 (domingo) a 6 (sábado)
    var diasParaSabado = 6 - dia;

    fechaInicio.setDate(fechaInicio.getDate() + diasParaSabado);
    var year = fechaInicio.getFullYear();
    var month = ("0" + (fechaInicio.getMonth() + 1)).slice(-2);
    var day = ("0" + fechaInicio.getDate()).slice(-2);

    var fechaFin = year + "-" + month + "-" + day;
    $("#fechaFinP").val(fechaFin);
});

$(".tablaPlanilla").on("click", ".btnImprimirPlanilla", function () {

    var idPlanilla = $(this).attr("id");
    window.open("extensiones/TCPDF-main/pdf/imprimirPlanilla.php?idPlanilla=" + idPlanilla, "_blank");

})

$(".tablas").on("click", ".btnImprimirBoletaDePago", function () {

    var idEmpleado = $(this).attr("idEmpleado");
    window.open("extensiones/TCPDF-main/pdf/imprimirBoletaDePago.php?idEmpleado=" + idEmpleado, "_blank");

})

$(".tablaPlanilla").on("click", ".btnListaEmpleadosPlanilla", function () {
    var idPlanilla = $(this).attr("idPlanilla");
    var fechaPlanilla = $(this).attr("fechaPlanilla");
    var totalPagado = $(this).attr("totalPagado");
    var estado = $(this).attr("estado");
    window.location.href = "index.php?rutas=planillaempleados&idPlanilla=" + idPlanilla + "&fechaPlanilla=" + fechaPlanilla+ "&totalPagado=" + totalPagado+ "&estado=" + estado;
});

$(".tablaPlanilla").on("click", ".btnActivar", function () {

    var id = $(this).attr("id");
    var estadoPlanilla = $(this).attr("estadoPlanilla");

    if (estadoPlanilla == 1) {
        var datos = new FormData();
        datos.append("activar", id);
        datos.append("estadoPlanilla", estadoPlanilla);

        $.ajax({

            url: "ajax/planilla.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {

            }

        })

        if (estadoPlanilla == 1) {

            $(this).addClass('btn-primary');
            $(this).removeClass('btn-danger');
            $(this).html('Cancelado');
            $(this).attr('estadoPlanilla', 0);

        }
    } else {
        Swal.fire({
            type: 'warning',
            title: "Planilla ya cancelada",
            text: "Esta planilla ya ha sido cancelada y no se puede actualizar el estado.",
            showCancelButton: false,
            confirmButtonColor: "#627d72",
            confirmButtonText: "Aceptar"
        }).then(function (result) {
            if (result.isConfirmed) {
                window.location = "planilla";
            }
        });
    }
})




