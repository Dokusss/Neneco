<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Empleados</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Empleados</li>
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
                            data-toggle="modal" data-target="#modalAgregarEmpleado">
                            <i class="feather-plus mr-1"></i> Registrar
                        </button>

                        <table class="table dt-responsive nowrap tablas">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Codigo</th>
                                    <th>Cedula</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Estado</th>
                                    <th>Cargo</th>
                                    <th>Direccion</th>
                                    <th>Genero</th>
                                    <th>Telefono</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Fecha de Registro</th>
                                    <th>Sueldo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $item = null;
                                $valor = null;
                                $empleados = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);
                                foreach ($empleados as $key => $value) {
                                    $fechaNac = date("d-m-Y", strtotime($value["fechanac"]));
                                    $fechaReg = date("d-m-Y", strtotime($value["fechareg"]));
                                    echo '<tr>
                                            <th class="sorting_1">' . ($key + 1) . '</th> 
                                            <td>' . $value["id"] . '</td> 
                                            <td>' . $value["ci"] . '</td>
                                            <td class="text-uppercase">' . $value["nombre"] . '</td>
                                            <td class="text-uppercase">' . $value["apellidop"] . ' ' . $value["apellidom"] . '</td>';
                                    if ($value["estado"] != 0) {
                                        echo '<td><button class="btn btn-sm btn-primary btnActivarE" style="width: 90px;" id="' . $value["id"] . '" estadoEmpleado="0">Activo</button></td>';
                                    } else {
                                        echo '<td><button class="btn btn-sm btn-danger btnActivarE" style="width: 90px;" id="' . $value["id"] . '" estadoEmpleado="1">Inactivo</button></td>';
                                    }
                                    $item = "id";
                                    $valor = $value["idcargo"];
                                    $cargo = ControladorCargo::ctrMostrarCargo($item, $valor);
                                    echo '<td class="text-uppercase">' . $cargo["nombre"] . '</td>
                                    <td>' . $value["direccion"] . '</td>
                                    <td>' . $value["genero"] . '</td>';
                                    if ($value["telefono"] != "") {
                                        echo '<td>' . $value["telefono"] . '</td>';
                                    } else {
                                        echo '<td>N/A</td>';
                                    }
                                    echo '
                                            <td>' . $fechaNac . '</td>
                                            <td>' . $fechaReg . '</td>
                                            <td>' . $value["sueldo"] . '</td>
                                            <td>
                                                <div>
                                                    <button class="btn btn-primary btn-sm mr-1 btnEditarEmpleado"
                                                        idEmpleado="' . $value["id"] . '" data-toggle="modal"
                                                        data-target="#modalEditarEmpleado"><i
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
    </div>
</div>

<!-- Modal Agregar Empleado-->
<div class="modal fade" id="modalAgregarEmpleado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Emplado</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <!-- Entrada Codigo -->
                            <div class="form-group">
                                <label for="simpleinput">Codigo</label>
                                <input type="text" name="nuevoCodigo" id="nuevoCodigo" class="form-control"
                                    placeholder="Ingrese el codigo del empleado" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <!-- Entrada Ci. -->
                            <div class="form-group">
                                <label for="simpleinput">Cedula de Identidad</label>
                                <input type="text" name="nuevoCi" id="nuevoCi" class="form-control"
                                    placeholder="Ingrese la cedula de identidad" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <!-- Entrada del Nombre -->
                            <div class="form-group">
                                <label for="simpleinput">Nombre</label>
                                <input type="text" name="nuevoNombre" class="form-control"
                                    placeholder="Ingrese el nombre" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <!-- Entrada del Apellido Paterno -->
                            <div class="form-group">
                                <label for="simpleinput">Apellido Paterno</label>
                                <input type="text" name="nuevoAp1" class="form-control"
                                    placeholder="Ingrese el apellido paterno" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <!-- Entrada del Apellido Materno. -->
                            <div class="form-group">
                                <label for="simpleinput">Apellido Materno</label>
                                <input type="text" name="nuevoAp2" class="form-control"
                                    placeholder="Ingrese el apellido materno">
                            </div>
                        </div>
                        <div class="col-6">
                            <!-- Entrada Direccion. -->
                            <div class="form-group">
                                <label for="simpleinput">Direccion</label>
                                <input type="text" name="nuevoDir" class="form-control"
                                    placeholder="Ingrese la direccion" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <!-- Entrada del Genero -->
                            <div class="form-group">
                                <label for="simpleinput">Genero</label>
                                <select class="form-control" name="nuevoGenero" id="simpleinput" required>
                                    <option value="">Seleccione el genero</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <!-- Entrada de Numero de Telefono -->
                            <div class="form-group">
                                <label for="simpleinput">Telefono</label>
                                <input type="text" name="nuevoTelefono" class="form-control" data-toggle="input-mask"
                                    data-mask-format="99999999" maxlength="8"
                                    placeholder="Ingrese el numero de telefono" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <!-- Entrada de Fecha de Nacimiento -->
                            <div class="form-group">
                                <label for="simpleinput">Fecha de Nacimiento</label>
                                <input type="date" name="nuevoFechaNac" id="nuevoFechaNac" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="col-6">
                            <!-- Entrada del Horario -->
                            <div class="form-group">
                                <label for="simpleinput">Horario</label>
                                <select class="form-control" name="nuevoHorario" required>
                                    <option value="">Seleccione el horario</option>
                                    <?php

                                    // $item = null;
                                    // $valor = null;

                                    // $horario = ControladorHorario::ctrMostrarHorario($item, $valor);

                                    // foreach ($horario as $key => $value) {

                                    //     echo '<option value="' . $value["id"] . ' ">' . $value["nombre"] . '</option>';
                                    // }

                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <!-- Entrada del Cargo -->
                            <div class="form-group">
                                <label for="simpleinput">Cargo</label>
                                <select class="form-control nuevoCargo" name="nuevoCargo" required>
                                    <option value="">Seleccione el cargo</option>
                                    <?php

                                    $item = null;
                                    $valor = null;

                                    $cargo = ControladorCargo::ctrMostrarCargo($item, $valor);

                                    foreach ($cargo as $key => $value) {

                                        echo '<option value="' . $value["id"] . ' ">' . $value["nombre"] . '</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <!-- Entrada del Sueldo -->
                            <div class="form-group">
                                <label for="simpleinput">Sueldo</label>
                                <input type="text" class="form-control mostrarSueldo" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="sumbit" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                // $crearEmpleado = new ControladorEmpleado();
                // $crearEmpleado->ctrCrearEmpleado();
                ?>
            </form>
        </div>
    </div>
</div>

