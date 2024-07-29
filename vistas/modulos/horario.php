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
                                    <th>Nombre</th>
                                    <th>Primer turno</th>
                                    <th>Segundo turno</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $item = null;
                                $valor = null;
                                $hora = ControladorHorario::ctrMostrarHorario($item, $valor);
                                foreach ($hora as $key => $hora) {
                                    echo '<tr class="odd" role="row">
                                            <th class="sorting_1">' . ($key + 1) . '</th>  
                                            <td class="text-uppercase">' . $hora["nombre"] . '</td>
                                            <td>' . $hora["entrada1"] . " a " . $hora["salida1"] . '</td>';
                                    if (isset($hora["entrada2"]) && isset($hora["salida2"]) && $hora["entrada2"] != null && $hora["salida2"] != null) {
                                        echo '<td>' . $hora["entrada2"] . " a " . $hora["salida2"] . '</td>';
                                    } else {
                                        echo '<th></th>';
                                    }

                                    echo ' <td>
                                                <div>
                                                    <button class="btn btn-primary btn-sm rounded-circle mr-1 btnEditarHorario"
                                                        id="' . $hora["id"] . '" data-toggle="modal"
                                                        data-target="#modalEditarHorario"><i
                                                            class="fas fa-pencil-alt"></i></button>
                                                    <button class="btn btn-danger btn-sm rounded-circle btnEliminarHorario"
                                                        id="' . $hora["id"] . '"><i class="fa fa-trash"></i></button>
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
<div class="modal fade" id="modalAgregarCargo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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

                    <!-- Entrada del Nombre -->
                    <div class="form-group">
                        <label for="nuevoNombre">Nombre del Horario</label>
                        <input type="text" name="nuevoNombre" id="nuevoNombre" class="form-control"
                            placeholder="Ingrese el nuevo nombre" required>
                    </div>

                    <h6>Primer turno</h6>
                    <!-- Entrada Mañana -->
                    <div class="form-group">
                        <label for="simpleinput">Entrada</label>
                        <input type="text" name="nuevoEntrada1" class="form-control" data-toggle="input-mask"
                            data-mask-format="00:00:00" maxlength="8" placeholder="HH:MM:SS" required>
                    </div>
                    <!-- Salida Mañana -->
                    <div class="form-group">
                        <label for="simpleinput">Salida</label>
                        <input type="text" name="nuevoSalida1" class="form-control" data-toggle="input-mask"
                            data-mask-format="00:00:00" maxlength="8" placeholder="HH:MM:SS" required>
                    </div>

                    <h6>Segundo turno</h6>
                    <!-- Entrada Mañana -->
                    <div class="form-group">
                        <label for="simpleinput">Entrada</label>
                        <input type="text" name="nuevoEntrada2" class="form-control" data-toggle="input-mask"
                            data-mask-format="00:00:00" maxlength="8" placeholder="HH:MM:SS">
                    </div>
                    <!-- Salida Mañana -->
                    <div class="form-group">
                        <label for="simpleinput">Salida</label>
                        <input type="text" name="nuevoSalida2" class="form-control" data-toggle="input-mask"
                            data-mask-format="00:00:00" maxlength="8" placeholder="HH:MM:SS">
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

<!-- Modal Editar Horario-->
<div class="modal fade" id="modalEditarHorario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="fotm" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Cargo</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Entrada del Nombre -->
                    <div class="form-group">
                        <label for="editarNombre">Nombre del Horario</label>
                        <input type="text" name="editarNombre" id="editarNombre" class="form-control" required>
                    </div>

                    <h5>Primer turno</h5>
                    <!-- Entrada Mañana -->
                    <div class="form-group">
                        <label for="simpleinput">Entrada</label>
                        <input type="text" name="editarEntrada1" id="editarEntrada1" class="form-control"
                            data-toggle="input-mask" data-mask-format="00:00:00" maxlength="8" required>
                        <input type="hidden" id="id" name="id">
                    </div>
                    <!-- Salida Mañana -->
                    <div class="form-group">
                        <label for="simpleinput">Salida</label>
                        <input type="text" name="editarSalida1" id="editarSalida1" class="form-control"
                            data-toggle="input-mask" data-mask-format="00:00:00" maxlength="8" required>
                    </div>

                    <h5>Segundo turno</h5>
                    <!-- Entrada Mañana -->
                    <div class="form-group">
                        <label for="simpleinput">Entrada</label>
                        <input type="text" name="editarEntrada2" id="editarEntrada2" class="form-control"
                            data-toggle="input-mask" data-mask-format="00:00:00" maxlength="8" required>
                    </div>
                    <!-- Salida Mañana -->
                    <div class="form-group">
                        <label for="simpleinput">Salida</label>
                        <input type="text" name="editarSalida2" id="editarSalida2" class="form-control"
                            data-toggle="input-mask" data-mask-format="00:00:00" maxlength="8" required>
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