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
    window.location.href = "index.php?rutas=planillaempleados&idPlanilla=" + idPlanilla;
});




