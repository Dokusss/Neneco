<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Permisos</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestion de Personal</li>
                            <li class="breadcrumb-item active">Permisos y Vacaciones</li>
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
                            data-toggle="modal" data-target="#modalAgregarPermisos">
                            <i class="feather-plus mr-1"></i> Agregar
                        </button>
                        <table class="table dt-responsive nowrap tablas">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Empleado</th>
                                    <th>Fecha de inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Motivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $item = null;
                                $valor = null;
                                $permisos = ControladorPermisos::ctrMostrarPermisos($item, $valor);
                                foreach ($permisos as $key => $value) {
                                    $fechaInicio = date("d-m-Y", strtotime($value["fechainicio"]));
                                    $fechaFin = date("d-m-Y", strtotime($value["fechafin"]));

                                    echo '<tr>
                                            <th class="sorting_1">' . ($key + 1) . '</th> ';
                                    $item = "id";
                                    $valor = $value["idempleado"];
                                    $empleado = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);
                                    echo '<td class="text-uppercase">' . $empleado["nombre"] . ' ' . $empleado["apellidop"] . ' ' . $empleado["apellidom"] . '</td>
                                            <td>' . $fechaInicio . '</td>
                                            <td>' . $fechaFin . '</td>
                                            <td>' . $value["motivo"] . '</td>
                                            <td>
                                                <div>
                                                    <button class="btn btn-primary btn-sm mr-1 btnEditarPermisos"
                                                        idPermiso="' . $value["id"] . '" data-toggle="modal"
                                                        data-target="#modalEditarPermisos"><i
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

<!-- Modal Agregar Permisos-->
<div class="modal fade" id="modalAgregarPermisos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Permisos</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Entrada de Fecha de Inicio -->
                    <div class="form-group">
                        <label for="nuevoFechaInicio">Fecha de Inicio</label>
                        <input type="date" name="nuevoFechaInicio" id="nuevoFechaInicio"
                            class="form-control nuevoFechaInicio" required>
                    </div>
                    <!-- Entrada de Fecha Fin -->
                    <div class="form-group">
                        <label for="nuevoFechaFin">Fecha Fin</label>
                        <input type="date" name="nuevoFechaFin" id="nuevoFechaFin" class="form-control" required>
                    </div>
                    <!-- Entrada Motivo -->
                    <div class="form-group">
                        <label for="nuevoMotivo">Motivo</label>
                        <textarea class="form-control" name="nuevoMotivo" id="nuevoMotivo" required></textarea>
                    </div>
                    <!-- Entrada del Empleado -->
                    <div class="form-group">
                        <label for="nuevoEmpleado">Empleado</label>
                        <select class="form-control" name="nuevoEmpleado" id="nuevoEmpleado" required>
                            <option value="">Seleccione el empleado</option>
                            <?php
                            $item = null;
                            $valor = null;                           
                            $empleado = ModeloEmpleado::mdlMostrarEmpleadosActivos();                          
                            foreach ($empleado as $key => $value) {
                                echo '<option value="' . $value["id"] . ' ">' . $value["nombre"] . " " . $value["apellidop"] . " " . $value["apellidom"] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="sumbit" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $crearPermisos = new ControladorPermisos();
                $crearPermisos->ctrCrearPermisos();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Permisos-->
<div class="modal fade" id="modalEditarPermisos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Permiso</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Entrada del Nombre -->
                    <div class="form-group">
                        <label for="mostrarEmpleado">Nombre del Empleado</label>
                        <input type="text" id="mostrarEmpleado" value="" class="form-control" readonly required>
                        <input type="hidden" name="id" id="id" required>
                    </div>

                    <!-- Entrada de Fecha de Inicio -->
                    <div class="form-group">
                        <label for="editarFechaInicio">Fecha de Inicio</label>
                        <input type="date" name="editarFechaInicio" id="editarFechaInicio"
                            class="form-control nuevoFechaInicio" required>
                    </div>

                    <!-- Entrada de Fecha Fin -->
                    <div class="form-group">
                        <label for="editarFechaFin">Fecha Fin</label>
                        <input type="date" name="editarFechaFin" id="editarFechaFin" class="form-control" required>
                    </div>

                    <!-- Entrada del Categoria -->
                    <div class="form-group">
                        <label for="editarCategoria">Categoria</label>
                        <select class="form-control" name="editarCategoria" id="editarCategoria" required>
                            <option value="">Seleccione el categoria</option>
                            <option value="enfermedad">Permiso por enfermedad</option>
                            <option value="ocasional">Permiso ocasional</option>
                            <option value="maternidad">Permiso de maternidad</option>
                            <option value="compasivo">Permiso compasivo</option>
                            <option value="especial">Permiso especial</option>
                            <option value="vacaciones">Vacaciones</option>
                        </select>
                    </div>

                    <!-- Entrada Motivo -->
                    <div class="form-group">
                        <label for="editarMotivo">Motivo</label>
                        <textarea class="form-control" name="editarMotivo" id="editarMotivo" required></textarea>
                    </div>

                    <!-- Entrada del Empleado -->
                    <!-- <div class="form-group">
                        <label for="editarEmpleado">Empleado</label>
                        <select class="form-control" name="editarEmpleado" id="editarEmpleado" required>
                            <option value="">Seleccione el empleado</option>
                            <?php

                            // $item = null;
                            // $valor = null;
                            
                            // $empleado = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);
                            
                            // foreach ($empleado as $key => $value) {
                            
                            //     echo '<option value="' . $value["id"] . ' ">' . $value["nombre"] . " " . $value["apellido1"] . " " . $value["apellido2"] . '</option>';
                            // }
                            
                            ?>
                        </select>
                    </div> -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="sumbit" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $editarPermisos = new ControladorPermisos();
                $editarPermisos->ctrEditarPermisos();
                ?>
            </form>
        </div>
    </div>
</div>

<?php
$borrarPermisos = new ControladorPermisos();
$borrarPermisos->ctrBorrarPermisos();
?>