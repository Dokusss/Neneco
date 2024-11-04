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
    var month = ("0" + (fechaInicio.getMonth() + 1)).slice(-2); // Meses son de 0-11
    var day = ("0" + fechaInicio.getDate()).slice(-2);

    var fechaFin = year + "-" + month + "-" + day;
    $("#fechaFinP").val(fechaFin);
});

$(".tablas").on("click", ".btnImprimirPlanilla", function () {

    var idPlanilla = $(this).attr("id");
    window.open("extensiones/TCPDF-main/pdf/imprimirPlanilla.php?idPlanilla=" + idPlanilla, "_blank");

})

$(".tablas").on("click", ".btnListaEmpleadosPlanilla", function () {
    alert("boton lista");
    var id = $(this).attr("id");
})

