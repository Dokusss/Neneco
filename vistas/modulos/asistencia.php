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

                        <button type="button" class="btn btn-primary waves-effect waves-light  mb-3" data-toggle="modal"
                            data-target="#modalVerEmpleado">
                            <i class="mdi mdi-calendar"></i> Ver Asistencias De Empleado
                        </button>



                        <button id="rangoAsistencias" class="btn btn-primary waves-effect waves-light float-right mb-3"
                            data-toggle="date-picker-range" data-target-display="#selectedValue"
                            data-cancel-class="btn-light" style="margin-right: 10px;">
                            <span id="selectedValue">
                                <?php
                                if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {
                                    echo $_GET["fechaInicial"] . " - " . $_GET["fechaFinal"];
                                } else {
                                    echo 'Seleccionar rango';
                                }
                                ?>
                            </span>
                            <i class="mdi mdi-menu-down"></i>
                        </button>


                        <table class="table dt-responsive nowrap tablasAsistencia">
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
                                if (isset($_GET["fechaInicial"])) {

                                    $fechaInicial = $_GET["fechaInicial"];
                                    $fechaFinal = $_GET["fechaFinal"];

                                } else {

                                    $fechaInicial = null;
                                    $fechaFinal = null;

                                }
                                $asistencia = ControladorAsistencia::ctrRangoFechasVentas($fechaInicial, $fechaFinal);
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
                                            ';
                                    if ($value["entrada2"] === null || $value["salida2"] === null) {
                                        echo '<td> 00:00:00 </td>
                                                    <td> 00:00:00 </td>';
                                    } else {
                                        echo '<td>' . $value["entrada2"] . '</td>
                                                    <td>' . $value["salida2"] . '</td>';
                                    }
                                    echo '<td>' . $value["horas"] . '</td>
                                            <td>' . $value["extras"] . '</td>
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

<!-- Modal Ver Empleado-->
<div class="modal fade" id="modalVerEmpleado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formVerEmpleado" role="form">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Cargo</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="simpleinput">Fecha Inicio (Opcional)</label>
                        <input type="date" name="fechaInicio" id="fechaInicio" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="simpleinput">Fecha Fin (Opcional)</label>
                        <input type="date" name="fechaFin" id="fechaFin" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="simpleinput">Empleado</label>
                        <select class="form-control" name="idEmpleado" required>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Ver Lista</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="resultModal" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="ModalTitulo"></h5>
                <button type="button" id="btnCerrar" class="close waves-effect waves-light" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenido del modal -->
            </div>
        </div>
    </div>
</div>