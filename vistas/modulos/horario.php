<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Horario</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestion de Personal</li>
                            <li class="breadcrumb-item active">Horario</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-1">
            </div>
            <div class="col-10">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary waves-effect waves-light card-title"
                            data-toggle="modal" data-target="#modalAgregarCargo">
                            <i class="feather-plus mr-1"></i> Agregar
                        </button>
                        <table class="table dt-responsive nowrap tablas">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Gestion</th>
                                    <th>Turno Mañana</th>
                                    <th>Turno Tarde</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $item = null;
                                $valor = null;
                                $hora = ControladorHorario::ctrMostrarHorario($item, $valor);
                                foreach ($hora as $key => $value) {
                                    $fecha = date("d-m-Y", strtotime($value["fecha"]));
                                    $entrada1 = date("H:i", strtotime($value["entrada1"]));
                                    $salida1 = date("H:i", strtotime($value["salida1"]));
                                    $entrada2 = date("H:i", strtotime($value["entrada2"]));
                                    $salida2 = date("H:i", strtotime($value["salida2"]));
                                    echo '<tr class="odd" role="row">
                                            <th class="sorting_1">' . ($key + 1) . '</th>  
                                            <td>' . $fecha . '</td>
                                            <td>' . $entrada1 . " / " . $salida1 . '</td>
                                            <td>' . $entrada2 . " / " . $salida2 . '</td>
                                            <td>
                                                <div>
                                                    <button class="btn btn-primary btn-sm mr-1 btnEditarHorario"
                                                        idHorario="' . $value["id"] . '" data-toggle="modal"
                                                        data-target="#modalEditarHorario"><i
                                                            class="fas fa-pencil-alt"></i></button>
                                                    <button class="btn btn-danger btn-sm btnEliminarHorario"
                                                        idHorario="' . $value["id"] . '"><i class="fa fa-trash"></i></button>
                                                </div>  
                                            </td>
                                        </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
            <div class="col-1">
            </div>
        </div>
        <!-- end row-->
    </div> <!-- container-fluid -->
</div>
<!-- Modal Agregar Horario-->
<div class="modal fade" id="modalAgregarCargo" tabindex="-1" role="dialog" aria-labelledby="modalAgregarCargo"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Horario</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Entrada del Fecha -->
                    <div class="form-group">
                        <label for="nuevoFecha">Fecha</label>
                        <input type="date" name="nuevoFecha" class="form-control nuevoFechaHorario" required>
                    </div>
                    <dt>Turno Mañana</dt>
                    <!-- Entrada Mañana -->
                    <div class="form-group">
                        <label for="nuevoEntrada1">Entrada</label>
                        <input type="time" name="nuevoEntrada1" class="form-control" required>
                    </div>
                    <!-- Salida Mañana -->
                    <div class="form-group">
                        <label for="nuevoSalida1">Salida</label>
                        <input type="time" name="nuevoSalida1" class="form-control" required>
                    </div>
                    <dt>Turno Tarde</dt>
                    <!-- Entrada Tarde -->
                    <div class="form-group">
                        <label for="nuevoEntrada2">Entrada</label>
                        <input type="time" name="nuevoEntrada2" class="form-control" required>
                    </div>
                    <!-- Salida Tarde -->
                    <div class="form-group">
                        <label for="nuevoSalida2">Salida</label>
                        <input type="time" name="nuevoSalida2" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $crearHorario = new ControladorHorario();
                $crearHorario->ctrCrearHorario();
                ?>
            </form>
        </div>
    </div>
</div>
<!-- Modal Agregar Horario-->
<div class="modal fade" id="modalEditarHorario" tabindex="-1" role="dialog" aria-labelledby="modalEditarHorario"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Horario</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Entrada del Fecha -->
                    <div class="form-group">
                        <label for="editarFecha">Fecha</label>
                        <input type="date" name="editarFecha" id="editarFecha" class="form-control nuevoFechaHorario"
                            required>
                        <input type="hidden" name="id" id="id" required>
                    </div>
                    <dt>Turno Mañana</dt>
                    <!-- Entrada Mañana -->
                    <div class="form-group">
                        <label for="editarEntrada1">Entrada</label>
                        <input type="time" name="editarEntrada1" id="editarEntrada1" class="form-control" required>
                    </div>
                    <!-- Salida Mañana -->
                    <div class="form-group">
                        <label for="editarSalida1">Salida</label>
                        <input type="time" name="editarSalida1" id="editarSalida1" class="form-control" required>
                    </div>
                    <dt>Turno Tarde</dt>
                    <!-- Entrada Tarde -->
                    <div class="form-group">
                        <label for="editarEntrada2">Entrada</label>
                        <input type="time" name="editarEntrada2" id="editarEntrada2" class="form-control" required>
                    </div>
                    <!-- Salida Tarde -->
                    <div class="form-group">
                        <label for="editarSalida2">Salida</label>
                        <input type="time" name="editarSalida2" id="editarSalida2" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $editarHorario = new ControladorHorario();
                $editarHorario->ctrEditarHorario();
                ?>
            </form>
        </div>
    </div>
</div>
<?php
$borrarHorario = new ControladorHorario();
$borrarHorario->ctrEliminarHorario();
?>