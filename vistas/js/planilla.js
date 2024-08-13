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

$(".tablas").on("click", ".btnReportePlanilla", function () {
	var id = $(this).attr("id");
    window.open("extensiones/tcpdf/pdf/planillas.php?id=" + id,"_blank");
})