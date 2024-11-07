<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Reportes</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Reportes</li>
                            <li class="breadcrumb-item active">Reportes de Asistencias</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 tablaReportesAsistencia">
                                <thead>
                                    <tr>
                                        <th colspan="5" style="text: center">REPORTES DE ASISTENCIAS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label for="fechaInicio">Fecha (Inicio)</label>
                                                <input type="date" id="fechaInicioA" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="fechaFin">Fecha (Fin)</label>
                                                <input type="date" id="fechaFinA" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="simpleinput">Empleado</label>
                                                <select class="form-control" id="idEmpleadoA">
                                                    <option value="">Seleccione empleado</option>
                                                    <?php
                                                    $item = null;
                                                    $valor = null;
                                                    $empleado = ModeloEmpleado::mdlMostrarEmpleadosActivos();
                                                    foreach ($empleado as $key => $value) {
                                                        echo '<option value="' . $value["id"] . '">' . $value["ci"] . " " . $value["nombre"] . " " . $value["apellidop"] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="simpleinput">Tipo</label>
                                                <select class="form-control" id="tipoA">
                                                    <option value="Asistencias">Asistencias</option>
                                                    <option value="Retrasos">Retrasos</option>
                                                    <option value="Faltas">Faltas</option>
                                                </select>
                                            </div>
                                        </td>

                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="button"
                                                class="btn btn-info waves-effect waves-light btnReporteAsistencias">
                                                <i class="far fa-file-pdf"></i> Exportar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>