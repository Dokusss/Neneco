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
                            <i class="feather-plus mr-1"></i> Agregar
                        </button>

                        <table class="table dt-responsive nowrap tablas">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Empleados</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $item = null;
                                $valor = null;

                                // Obtener los detalles de las horas extras
                                $horas = ControladorHoras::ctrMostrarDetalleHoras($item, $valor);

                                foreach ($horas as $key => $value) {
                                    $fecha = date("d-m-Y", strtotime($value["fecha"]));
                                    $empleados = explode(', ', $value["empleados"]); // Dividir la cadena concatenada en un array
                                
                                    echo '<tr>
                                        <th class="sorting_1">' . ($key + 1) . '</th>
                                        <td>' . $fecha . '</td>
                                        <td>';

                                    // Listar los empleados correspondientes a esta hora extra
                                    foreach ($empleados as $empleado) {
                                        echo $empleado . ", ";
                                    }

                                    echo '</td>
                                        <td>
                                            <div>
                                                <button class="btn btn-primary btn-sm rounded-circle mr-1 btnEditarHoras"
                                                    id="' . $value["idhorasextras"] . '" data-toggle="modal"
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
                        <input type="date" name="nuevoFecha" id="nuevoFecha" class="form-control" required>
                    </div>

                    <!-- Entrada del Horario -->
                    <div class="form-group">
                        <label for="nuevoHorario">Horario</label>
                        <select class="form-control" name="nuevoHorario" id="nuevoHorario" required>
                            <option value="">Seleccione el horario</option>
                            <?php

                            $item = null;
                            $valor = null;

                            $Horas = ControladorHorario::ctrMostrarHorario($item, $valor);

                            foreach ($Horas as $key => $value) {

                                echo '<option value="' . $value["id"] . ' ">' . $value["nombre"] . '</option>';
                            }

                            ?>
                        </select>
                    </div>

                    <!-- Entrada del Categoria -->
                    <div class="form-group">
                        <label for="nuevoTipo">Tipo de pago</label>
                        <select class="form-control" name="nuevoTipo" id="nuevoTipo" required>
                            <option value="">Seleccione el tipo</option>
                            <option value="2">x2</option>
                            <option value="3">x3</option>
                        </select>
                    </div>

                    <!-- Entrada Motivo -->
                    <div class="form-group">
                        <label>Empleados</label>
                        <select class="form-control select2-multiple" name="empleados[]" multiple="multiple" required>
                            <?php
                            $item = null;
                            $valor = null;

                            $empleado = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);

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
                        <input type="date" name="editarFecha" id="editarFecha" class="form-control" required>
                        <input type="hidden" name="id" id="id">
                    </div>

                    <!-- Entrada del Horario -->
                    <div class="form-group">
                        <label for="editarHorario">Horario</label>
                        <select class="form-control" name="editarHorario" id="editarHorario" required>
                            <option value="">Seleccione el horario</option>
                            <?php
                            $item = null;
                            $valor = null;
                            $Horas = ControladorHorario::ctrMostrarHorario($item, $valor);
                            foreach ($Horas as $key => $value) {
                                echo '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Entrada del Tipo -->
                    <div class="form-group">
                        <label for="editarTipo">Tipo de pago</label>
                        <select class="form-control" name="editarTipo" id="editarTipo" required>
                            <option value="">Seleccione el tipo</option>
                            <option value="1">x1</option>
                            <option value="2">x2</option>
                            <option value="3">x3</option>
                        </select>
                    </div>

                    <!-- Entrada de Empleados -->
                    <div class="form-group">
                        <label>Empleados</label>
                        <select class="form-control select2-multiple" name="empleados[]" multiple="multiple" required>
                            <?php
                            $item = null;
                            $valor = null;
                            $empleado = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);
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
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $editarHoras = new ControladorHoras();
                $editarHoras->ctrEditarHoras();
                ?>
            </form>
        </div>
    </div>
</div>