<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Asistencias</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Asistencias</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Sube aquí el archivo con los registros de las asistencias</h3>
                        <form method="post" enctype="multipart/form-data" id="formDatosExcel">
                            <div class="row">
                                <div class="col-xl-10 col-lg-10">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" name="nuevoArchivo" id="nuevoArchivo"
                                                accept=".xls, .xlsx">
                                            <label class="custom-file-label" for="nuevoArchivo">Elegir archivo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2">
                                    <div class="form-group">
                                        <button type="sumbit" class="btn btn-primary waves-effect waves-light"
                                            value="Subir Archivo" id="btnSubir">
                                            <i class="feather-upload mr-1"></i> Subir Archivo
                                        </button>
                                        <!-- <input type="submit" class="btn btn-primary btn-block waves-effect waves-light" value="Subir Archivo" id="btnSubir"> -->
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12 text-center">
                <div class="spinner-border m-4" style="display: none;" id="load">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">

                        <!-- VER REGISTROS DE EMPLEADO -->

                        <form role="form" method="post" id="listarEmpleado">
                            <h5>Ver registros de empleado</h5>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <!-- Entrada del Fecha Inicio -->
                                    <div class="form-group">
                                        <label for="fechaInicio">Fecha Inicio</label>
                                        <input type="date" id="fechaInicio" name="fechaInicio" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <!-- Entrada del Fecha Fin -->
                                    <div class="form-group">
                                        <label for="fechaFin">Fecha Fin</label>
                                        <input type="date" id="fechaFin" name="fechaFin" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4">
                                    <!-- Entrada del Empleado -->
                                    <div class="form-group">
                                        <label for="idEmpleado">Empleado</label>
                                        <select id="idEmpleado" class="form-control" name="idEmpleado" required>
                                            <option value="">Seleccione un empleado</option>
                                            <?php
                                            $item = null;
                                            $valor = null;
                                            $horario = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);
                                            foreach ($horario as $key => $value) {
                                                $nomMayus = mb_strtoupper($value["nombre"], 'UTF-8');
                                                $ap1Mayus = mb_strtoupper($value["apellidop"], 'UTF-8');
                                                $ap2Mayus = mb_strtoupper($value["apellidom"], 'UTF-8');
                                                echo '<option value="' . $value["id"] . '">' . $nomMayus . " " . $ap1Mayus . " " . $ap2Mayus . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-3"></div>
                                <div class="col-xl-2 col-lg-2 col-md-3">
                                    <!-- Boton -->                                   
                                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">
                                            <i class="feather-search mr-1"></i> Mostrar
                                        </button>                                   
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-3">
                                    <!-- Boton -->                                   
                                        <button class="btn btn-primary btn-block waves-effect waves-light" id="exportarEmpleado">
                                            <i class="feather-file mr-1"></i> Exportar
                                        </button>                                  
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-3"></div>
                            </div>
                        </form>

                        <!-- VER REGISTROS -->

                        <!-- <form role="form" method="post" id="listar">
                            <h5>Ver registros</h5>
                            <div class="row">
                                <div class="col-xl-5 col-lg-5">
                                    
                                    <div class="form-group">
                                        <label for="fechaInicio">Fecha Inicio</label>
                                        <input type="date" id="fechaInicio" name="fechaInicio" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-5">
                                    
                                    <div class="form-group">
                                        <label for="fechaFin">Fecha Fin</label>
                                        <input type="date" id="fechaFin" name="fechaFin" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-xl-1 col-lg-2 d-flex align-items-end">
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                                            <i class="feather-search mr-1"></i> Mostrar
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xl-1 col-lg-2 d-flex align-items-end">
                                    
                                    <div class="form-group">
                                        <button class="btn btn-primary waves-effect waves-light ">
                                            <i class="feather-file mr-1"></i> Exportar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form> -->

                        <div>
                            <table class="table dt-responsive nowrap tablasAsistencia" id="example">
                                <thead class="thead-light">
                                    <tr>
                                        <th rowspan="2" class="align-middle">#</th>
                                        <th rowspan="2" class="align-middle">Fecha</th>
                                        <th rowspan="2" class="align-middle">Empleado</th>
                                        <th colspan="2">Mañana</th>
                                        <th colspan="2">Tarde</th>
                                        <th rowspan="2" class="align-middle">Horas trabajadas</th>
                                        <th rowspan="2" class="align-middle">Extras</th>
                                        <th rowspan="2" class="align-middle">Retraso</th>
                                    </tr>
                                    <tr>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $asistencia = ControladorAsistencia::ctrMostrarTodasLasAsistencias($item, $valor);
                                    foreach ($asistencia as $key => $value) {

                                        echo '<tr>
                                    
                                            <th class="sorting_1">' . ($key + 1) . '</th>  
                                            <td>' . $value["fecha"] . '</td>';

                                        $item = "id";
                                        $valor = $value["idempleado"];

                                        $empleado = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);

                                        $nomMayus = mb_strtoupper($empleado["nombre"], 'UTF-8');
                                        $ap1Mayus = mb_strtoupper($empleado["apellidop"], 'UTF-8');
                                        $ap2Mayus = mb_strtoupper($empleado["apellidom"], 'UTF-8');
                                        echo '<td>' . $nomMayus . " " . $ap1Mayus . " " . $ap2Mayus . '</td>
                                    
                                        <td>' . $value["entrada1"] . '</td>
                                            <td>' . $value["salida1"] . '</td>
                                            <td>' . $value["entrada2"] . '</td>
                                            <td>' . $value["salida2"] . '</td>
                                            <td>' . $value["horas"] . '</td>
                                            <td>' . $value["horasextras"] . '</td>
                                            <td>' . $value["retraso"] . '</td>
                                        </tr>';
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="resultModal" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myExtraLargeModalLabel">Resultados</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="resultados">
                    <!-- Aquí se mostrarán los resultados -->
                </div>
            </div>
        </div>
    </div>
</div>