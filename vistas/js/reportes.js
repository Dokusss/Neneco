$(".tablaReportesAsistencia").on("click", ".btnReporteAsistencias", function () {

    var fechaInicio = $('#fechaInicioA').val() || null;
    var fechaFin = $('#fechaFinA').val() || null;
    var idEmpleado = $('#idEmpleadoA').val() || null;
    var tipo = $('#tipoA').val() || null;

    switch (tipo) {

        case 'Asistencias':

            if (fechaInicio != null && fechaFin != null && idEmpleado != null) {

                window.open("extensiones/TCPDF-main/pdf/reporteAsistenciasFechasId.php?idEmpleado=" + idEmpleado + "&fechaInicio=" + fechaInicio + "&fechaFin=" + fechaFin, "_blank");

            } else if (fechaInicio != null && fechaFin != null) {

                window.open("extensiones/TCPDF-main/pdf/reporteAsistenciasFechas.php?&fechaInicio=" + fechaInicio + "&fechaFin=" + fechaFin, "_blank");

            } else if (idEmpleado != null) {

                window.open("extensiones/TCPDF-main/pdf/reporteAsistenciasId.php?idEmpleado=" + idEmpleado, "_blank");

            } else {
                window.open("extensiones/TCPDF-main/pdf/reporteAsistencias.php?_blank");
            }

            break;

        case 'Retrasos':

            alert("Reporte de retrasos");

            break;

        case 'Faltas':

            alert("Reporte de faltas");

            break;

        default:
            Swal.fire({
                type: 'warning',
                title: "Seleccione un tipo",
                showCancelButton: false,
                confirmButtonColor: "#627d72",
                confirmButtonText: "Aceptar"
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.location = "reportesasistencias";
                }
            });
    }
});

