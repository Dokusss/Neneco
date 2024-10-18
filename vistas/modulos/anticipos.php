<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Anticipos</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestion de Personal</li>
                            <li class="breadcrumb-item active">Anticipos</li>
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
                        <button type="button" class="btn btn-primary waves-effect waves-light card-title"
                            data-toggle="modal" data-target="#modalRegistrarAnticipo">
                            <i class="feather-plus mr-1"></i> Registrar
                        </button>

                        <table class="table dt-responsive nowrap tablas">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Empleado</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $item = null;
                                $valor = null;
                                $anticipos = ControladorAnticipos::ctrMostrarAnticipos($item, $valor);
                                foreach ($anticipos as $key => $value) {
                                    $fecha = date("d-m-Y", strtotime($value["fecha"]));
                                    echo '<tr class="odd" role="row">
                                            <th class="sorting_1">' . ($key + 1) . '</th>';

                                    $item = "id";
                                    $valor = $value["idempleado"];
                                    $empleado = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);

                                    echo '<td class="text-uppercase">' . $empleado["nombre"] . ' ' . $empleado["apellidop"] . ' ' . $empleado["apellidom"] . '</td>
                                            <td>' . $fecha . '</td>
                                            <td>' . $value["monto"] . '</td>
                                            <td>
                                                <div>
                                                    <button class="btn btn-primary btn-sm mr-1 btnEditarAnticipo"
                                                        idAnticipos="' . $value["id"] . '" data-toggle="modal"
                                                        data-target="#modalEditarAnticipo"><i
                                                            class="fas fa-pencil-alt"></i></button>
                                                </div>  
                                            </td>
                                        </tr>';
                                }
                                ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- end row-->

    </div> <!-- container-fluid -->
</div>

<!-- Modal Agregar Anticipo -->
<div class="modal fade" id="modalRegistrarAnticipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Anticipo</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Entrada de Fecha -->
                    <div class="form-group">
                        <label for="nuevoFecha">Fecha</label>
                        <input type="date" name="nuevoFecha" id="nuevoFecha" class="form-control"
                            required>
                    </div>
                    <!-- Entrada del Empleado -->
                    <div class="form-group">
                        <label for="nuevoEmpleado">Empleado</label>
                        <select class="form-control" name="nuevoEmpleado" id="nuevoEmpleado" required>
                            <option value="">Seleccione el empleado</option>
                            <?php
                            $empleado = ModeloEmpleado::mdlMostrarEmpleadosActivos();
                            foreach ($empleado as $key => $value) {
                                echo '<option value="' . $value["id"] . ' ">' . $value["nombre"] . " " . $value["apellidop"] . " " . $value["apellidom"] . '</option>';
                            }

                            ?>
                        </select>
                    </div>
                    <!-- Entrada del Monto -->
                    <div class="form-group">
                        <label for="simpleinput">Monto</label>
                        <input type="number" name="nuevoMonto" id="nuevoMonto" class="form-control" placeholder="Ingrese el monto"
                            min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $crearCargo = new ControladorAnticipos();
                $crearCargo->ctrCrearAnticipos();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Anticipo -->
<div class="modal fade" id="modalEditarAnticipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Anticipo</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Entrada de Fecha -->
                    <div class="form-group">
                        <label for="editarFecha">Fecha</label>
                        <input type="date" id="editarFecha" class="form-control" readonly>
                        <input type="hidden" name="id" id="id">
                    </div>
                    <!-- Entrada del Empleado -->
                    <div class="form-group">
                        <label for="editarEmpleado">Empleado</label>
                        <input class="form-control" id="editarEmpleado" readonly>
                    </div>
                    <!-- Entrada del Monto -->
                    <div class="form-group">
                        <label for="simpleinput">Monto</label>
                        <input type="number" name="editarMonto" id="editarMonto" class="form-control" placeholder="Ingrese el monto"
                            min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $editarCargo = new ControladorAnticipos();
                $editarCargo->ctrEditarAnticipos();
                ?>
            </form>
        </div>
    </div>
</div>