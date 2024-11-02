<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Horas Extras</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestion de Personal</li>
                            <li class="breadcrumb-item active">Horas Extras</li>
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
                            data-toggle="modal" data-target="#modalAgregarHoras">
                            <i class="feather-plus mr-1"></i> Registrar
                        </button>
                        <table class="table dt-responsive nowrap tablas">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Entrada</th>
                                    <th>Salida</th>
                                    <th>Empleados</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $item = null;
                                $valor = null;
                                $horas = ControladorHoras::ctrMostrarHoras($item, $valor);
                                foreach ($horas as $key => $value) {
                                    $fecha = date("d-m-Y", strtotime($value["fecha"]));
                                    $entrada = date("H:i", strtotime($value["entrada"]));
                                    $salida = date("H:i", strtotime($value["salida"]));
                                    echo '<tr class="odd" role="row">
                                            <th class="sorting_1">' . ($key + 1) . '</th>  
                                            <td>' . $fecha . '</td>
                                            <td>' . $entrada . '</td>
                                            <td>' . $salida . '</td>
                                            <td><button type="button" class="btn btn-info btnModalEmpleados" idHorasExtras="' . $value["id"] . '"
                                                data-toggle="modal" data-target="#modalVerEmpleados">
                                                <i class="fas fa-user-friends"></i></button></td>
                                            <td>
                                                <div>
                                                    <button class="btn btn-primary btn-sm mr-1 btnEditarHoras"
                                                        idHoraExtra="' . $value["id"] . '" data-toggle="modal"
                                                        data-target="#modalEditarHoras"><i
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

<!-- Modal Ver Empleados -->
<div class="modal fade" id="modalVerEmpleados" tabindex="-1" role="dialog" aria-labelledby="modalVerEmpleadosTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVerEmpleadosTitle">Lista de Empleados</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table mb-0" id="tablaEmpleados">
                        <thead class="thead-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect waves-light"
                    data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Horas-->
<div class="modal fade" id="modalAgregarHoras" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Horas Extras</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Entrada de Fecha -->
                    <div class="form-group">
                        <label for="nuevoFecha">Fecha</label>
                        <input type="date" name="nuevoFecha" class="form-control nuevoFechaHorasExtras" required>
                    </div>
                    <!-- Entrada -->
                    <div class="form-group">
                        <label for="nuevoEntrada">Entrada</label>
                        <input type="time" name="nuevoEntrada" class="form-control" required>
                    </div>
                    <!-- Salida -->
                    <div class="form-group">
                        <label for="nuevoSalida">Entrada</label>
                        <input type="time" name="nuevoSalida" class="form-control" required>
                    </div>
                    <!-- Entrada Empleados -->
                    <div class="form-group">
                        <label>Empleados</label>
                        <select class="form-control select2-multiple" name="listaEmpleados[]" multiple="multiple"
                            required>
                            <?php
                            $item = null;
                            $valor = null;
                            $empleado = ModeloEmpleado::mdlMostrarEmpleadosActivos();
                            foreach ($empleado as $key => $value) {
                                echo '<option value="' . $value["id"] . '">' . $value["nombre"] . " " . $value["apellidop"] . " " . $value["apellidom"] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $crearHoras = new ControladorHoras();
                $crearHoras->ctrCrearHoras();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Horas-->
<div class="modal fade" id="modalEditarHoras" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Horas Extras</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Entrada de Fecha -->
                    <div class="form-group">
                        <label for="editarFecha">Fecha</label>
                        <input type="date" name="editarFecha" id="editarFecha"
                            class="form-control nuevoFechaHorasExtras" required>
                        <input type="hidden" name="id" id="id" required>
                    </div>
                    <!-- Entrada -->
                    <div class="form-group">
                        <label for="editarEntrada">Entrada</label>
                        <input type="time" name="editarEntrada" id="editarEntrada" class="form-control" required>
                    </div>
                    <!-- Salida -->
                    <div class="form-group">
                        <label for="editarSalida">Entrada</label>
                        <input type="time" name="editarSalida" id="editarSalida" class="form-control" required>
                    </div>
                    <!-- Entrada Empleados -->
                    <div class="form-group">
                        <label>Empleados</label>
                        <textarea type="text" class="form-control" id="listaEmpleados" readonly></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $editarHoras = new ControladorHoras();
                $editarHoras->ctrEditarHoras();
                ?>
            </form>
        </div>
    </div>
</div>