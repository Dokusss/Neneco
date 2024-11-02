//CARGAR DATOS
$(document).ready(function () {
    $("#formDatosExcel").on('submit', function (e) {
        e.preventDefault();
        //VALIDAR QUE SE SELECCIONE UN ARCHIVO
        if ($("#nuevoArchivo").get(0).files.length == 0) {

            Swal.fire({
                position: 'center',
                type: "warning",
                title: "Debe seleccionar un archivo (Excel)",
                showConfirmButton: false,
                timer: 2000
            });

        } else {
            //VALIDAR QUE UN ARCHIVO SELECCIONADO TENGA EXTENSION .XLS O .XLSX
            var estensionesPermitidas = [".xls", ".xlsx"];
            var inputFile = $("#nuevoArchivo");
            var exp_reg = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + estensionesPermitidas.join('|') + ")$")
            if (!exp_reg.test(inputFile.val().toLowerCase())) {
                Swal.fire({
                    position: 'center',
                    type: "warning",
                    title: "Debe seleccionar un archivo con extensión .xls o .xlsx",
                    showConfirmButton: false,
                    timer: 2500
                });
                return false;
            }
            var datos = new FormData($(formDatosExcel)[0]);
            $("#btnSubir").prop("disabled", true);
            $("#load").attr("style", "display:inline-block");
            $.ajax({
                url: "ajax/cargar.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    console.log("respuesta", respuesta)
                    if (respuesta > 0) {
                        Swal.fire({
                            type: "success",
                            title: "Se han ingresado " + respuesta + " registros de manera exitosa!",
                            showConfirmButton: true,
                            confirmButtonColor: "#627d72",
                            confirmButtonText: "Cerrar"
                        }).then(function (result) {
                            if (result.value) {
                                window.location = "asistencia";
                            }
                        });
                        $("#btnSubir").prop("disabled", false);
                        $("#load").attr("style", "display:none");
                    } else {
                        Swal.fire({
                            type: "warning",
                            title: "No se pueden insertar los datos",
                            text: "Los registros no se han insertado porque ya existen datos duplicados.",
                            showConfirmButton: true,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Cerrar"
                        }).then(function (result) {
                            if (result.value) {
                                window.location = "asistencia";
                            }
                        });
                        $("#btnSubir").prop("disabled", false);
                        $("#load").attr("style", "display:none");
                    }

                }
            })
        }
    })
})
// Verificar si hay un rango de fechas guardado en localStorage
if (localStorage.getItem("capturarRango2") != null) {
    $("#rangoAsistencias span").html(localStorage.getItem("capturarRango2"));
} else {
    $("#rangoAsistencias span").html('<i class="mdi mdi-calendar"></i> Seleccionar rango');
}
// Inicializar el date range picker
$('#rangoAsistencias').daterangepicker(
    {
        opens: 'left',
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate: moment(),
        locale: {
            format: 'DD-MM-YYYY'
        }
    },
    function (start, end) {
        $('#rangoAsistencias span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
        var fechaInicial = start.format('YYYY-MM-DD');
        var fechaFinal = end.format('YYYY-MM-DD');
        // Guardar el rango de fechas seleccionado en localStorage
        var capturarRango = $("#rangoAsistencias span").html();
        localStorage.setItem("capturarRango2", capturarRango);
        // Mostrar las fechas en la consola
        console.log('Fecha Inicial:', fechaInicial);
        console.log('Fecha Final:', fechaFinal);
        // Redirigir a la página de "asistencia" con los parámetros de fecha
        window.location = "index.php?rutas=asistencia&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
    }
);
// Manejar el evento de cancelar
$('#rangoAsistencias').on('cancel.daterangepicker', function (ev, picker) {
    localStorage.removeItem("capturarRango2");
    localStorage.clear();
    window.location = "asistencia"; // Redirigir a la página de asistencia
});
// Capturar el rango de "Hoy" y mostrar en la consola
$(".daterangepicker .ranges li").on("click", function () {
    var textoHoy = $(this).attr("data-range-key");

    if (textoHoy === "Hoy") {
        var d = new Date();
        var dia = ("0" + d.getDate()).slice(-2);
        var mes = ("0" + (d.getMonth() + 1)).slice(-2);
        var año = d.getFullYear();
        var fechaHoy = año + "-" + mes + "-" + dia;
        console.log("Fecha de hoy capturada:");
        console.log("Fecha Inicial:", fechaHoy);
        console.log("Fecha Final:", fechaHoy);
        localStorage.setItem("capturarRango2", "Hoy");
        window.location = "index.php?rutas=asistencia&fechaInicial=" + fechaHoy + "&fechaFinal=" + fechaHoy;
    }
});
//MOSTRAR LAS ASISTENCIAS DE UN EMPLEADO
$("#formVerEmpleado").on("submit", function (event) {
    // Validación de fechas antes de enviar la solicitud
    var fechaInicio = $('#fechaInicio').val();
    var fechaFin = $('#fechaFin').val();
    var fechaActual = new Date().toISOString().split('T')[0]; // Fecha actual en formato 'YYYY-MM-DD'
    // Elimina cualquier alerta previa
    $('.alert-warning').remove();
    // Verifica si la fecha de inicio está rellena y la fecha fin está vacía
    if (fechaInicio && !fechaFin) {
        $("#fechaFin").parent().after('<div class="alert alert-warning mt-2" role="alert">Por favor, rellene la fecha de fin si ha ingresado una fecha de inicio.</div>');
        $('#fechaFin').focus();
        event.preventDefault(); // Evita el envío del formulario
        return; // Detiene la ejecución del código AJAX
    }
    // Verifica si la fecha de fin es superior a la fecha actual
    if (fechaFin && fechaFin > fechaActual) {
        $("#fechaFin").parent().after('<div class="alert alert-warning mt-2" role="alert">La fecha de fin no puede ser superior a la fecha actual.</div>');
        $('#fechaFin').focus();
        event.preventDefault(); // Evita el envío del formulario
        return; // Detiene la ejecución del código AJAX
    }
    // Si la validación se pasa, procede con el envío de los datos
    event.preventDefault();
    var formData = $(this).serialize();
    console.log("Datos enviados:", formData); // Ver los datos que se enviarán
    $.ajax({
        url: 'ajax/asistencia.ajax.php',
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (respuesta) {
            console.log("Respuesta del servidor:", respuesta); // Ver la respuesta en la consola
            // Cerrar el modal actual
            $('#modalVerEmpleado').modal('hide');
            if (respuesta && respuesta.length > 0) {
                // Obtener el nombre completo y CI del primer elemento de la respuesta para el título
                var empleado = 'Resultados del Empleado: ' + respuesta[0].ci + ' - ' + respuesta[0].nombre + ' ' + respuesta[0].apellidop + ' ' + (respuesta[0].apellidom || '');
                $("#ModalTitulo").text(empleado);
                // Construir la tabla de resultados
                var tableHtml = "<table id='tablaResultados' class='table table-bordered dt-responsive nowrap' width='100%'><thead class='thead-light'><tr>" +
                    "<th rowspan='2' class='align-middle'>#</th>" +
                    "<th rowspan='2' class='align-middle'>Fecha</th>" +
                    "<th colspan='2'>Mañana</th>" +
                    "<th colspan='2'>Tarde</th>" +
                    "<th rowspan='2' class='align-middle'>Horas trabajadas</th>" +
                    "<th rowspan='2' class='align-middle'>Extras</th>" +
                    "<th rowspan='2' class='align-middle'>Retraso</th>" +
                    "</tr><tr>" +
                    "<th>Entrada</th>" +
                    "<th>Salida</th>" +
                    "<th>Entrada</th>" +
                    "<th>Salida</th>" +
                    "</tr></thead><tbody>";
                respuesta.forEach(function (item, index) {
                    tableHtml += "<tr>" +
                        "<td>" + (index + 1) + "</td>" +
                        "<td>" + item.fecha + "</td>" +
                        "<td>" + item.entrada1 + "</td>" +
                        "<td>" + item.salida1 + "</td>";

                    // Verificar si `entrada2` y `salida2` son null para mostrar `00:00:00`
                    if (item.entrada2 === null && item.salida2 === null) {
                        tableHtml += "<td>00:00:00</td><td>00:00:00</td>";
                    } else {
                        tableHtml += "<td>" + (item.entrada2 || "00:00:00") + "</td>" +
                            "<td>" + (item.salida2 || "00:00:00") + "</td>";
                    }

                    tableHtml += "<td>" + item.horas + "</td>" +
                        "<td>" + item.extras + "</td>" +
                        "<td>" + item.retraso + "</td>" +
                        "</tr>";
                });
                tableHtml += "</tbody></table>";
                $("#resultModal .modal-body").html(tableHtml);
                // Inicializar DataTable
                $('#tablaResultados').DataTable({
                    "searching": false,
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sSearch": "Buscar:",
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
                // Mostrar el modal de resultados
                $('#resultModal').modal('show');
            } else {
                $("#ModalTitulo").text("Sin resultados");
                $("#resultModal .modal-body").html("<p>No se encontraron resultados.</p>");
                $('#resultModal').modal('show');
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
            console.log("Respuesta completa del servidor:", xhr.responseText);
            $("#ModalTitulo").text("Error");
            $("#resultModal .modal-body").html("<p>Ocurrió un error al obtener los datos.</p>");
            $('#resultModal').modal('show');
        }
    });
});
//BOTON CERRAR DEL MODAL
$("#btnCerrar").on("click", function () {
    location.reload(); // Recarga la página
});





$("#exportarEmpleado").on("click", function (event) {
    event.preventDefault(); // Evitar el envío del formulario

    // Capturar los valores de los campos del formulario
    var fechaInicio = $("#fechaInicio").val();
    var fechaFin = $("#fechaFin").val();
    var idEmpleado = $("#idEmpleado").val();

    if (!fechaInicio || !fechaFin || !idEmpleado) {
        Swal.fire({
            position: 'center',
            type: "warning",
            title: "Complete todos los campos: Fecha Inicio, Fecha Fin y Empleado.",
            showConfirmButton: false,
            timer: 2500
        });
    } else {
        window.open("extensiones/tcpdf/pdf/reporte-empleado.php?idEmpleado=" + idEmpleado + "&fechaInicio=" + fechaInicio + "&fechaFin=" + fechaFin, "_blank");

        //window.open("extensiones/tcpdf/examples/example_001.php", "_blank");
    }
});









