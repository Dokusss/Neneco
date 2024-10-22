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
                    }
                }
            })
        }
    })
})


var table = $('.tablasAsistencia').DataTable(); // Supone que ya ha sido inicializado

$("#listarEmpleado").on("submit", function (event) {
    event.preventDefault(); // Evitar el envío del formulario
    var formData = $(this).serialize(); // Recoger los datos del formulario

    $.ajax({
        url: 'ajax/asistencia.ajax.php',
        method: 'POST',
        dataType: 'json',
        data: formData,
        success: function (respuesta) {
            //console.log(respuesta);
            // Destruir la tabla existente y eliminar el contenido del cuerpo de la tabla
            table.clear().destroy();
            $('#example tbody').empty();

            // Agregar filas a la tabla
            $.each(respuesta, function (index, item) {
                var empleado = item.nombre + ' ' + item.apellidop + ' ' + (item.apellidom ? item.apellidom : '');
                var row = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + item.fecha + '</td>' +
                    '<td>' + empleado + '</td>' +
                    '<td>' + item.entrada1 + '</td>' +
                    '<td>' + item.salida1 + '</td>' +
                    '<td>' + item.entrada2 + '</td>' +
                    '<td>' + item.salida2 + '</td>' +
                    '<td>' + item.horas + '</td>' +
                    '<td>' + item.horasextras + '</td>' +
                    '</tr>';
                $('#example tbody').append(row);
            });

            // Re-inicializar el DataTable
            table = $('.tablasAsistencia').DataTable({
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
        }
    });
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









