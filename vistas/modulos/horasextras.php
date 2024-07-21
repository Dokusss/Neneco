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
                        <button type="button" class="btn btn-primary waves-effect waves-light card-title" data-toggle="modal" data-target="#modalAgregarHoras">
                            <i class="feather-plus mr-1"></i> Agregar
                        </button>

                        <table class="table dt-responsive nowrap tablas">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Empleado</th>
                                    <th>Fecha</th>
                                    <th>Fecha y Hora Inicial</th>
                                    <th>Fecha y Hora Final</th>
                                    <th>Tipo de Hora Extra</th>
                                    <th>Motivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                // $item = null;
                                // $valor = null;
                                // $horas = ControladorHoras::ctrMostrarHoras($item, $valor);
                                // foreach ($horas as $key => $value) {
                                //     $fecha= date("d-m-Y", strtotime($value["fecha"]));

                                //     echo '<tr>
                                //             <th class="sorting_1">' . ($key + 1) . '</th> ';

                                //     $item = "id";
                                //     $valor = $value["idempleado"];

                                //     $empleado = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);

                                //     $nomMayus = mb_strtoupper($empleado["nombre"], 'UTF-8');
                                //     $ap1Mayus = mb_strtoupper($empleado["apellido1"], 'UTF-8');
                                //     $ap2Mayus = mb_strtoupper($empleado["apellido2"], 'UTF-8');

                                //     echo '<td>' . $nomMayus . " " . $ap1Mayus . " " . $ap2Mayus . '</td>
                                //             <td>' . $fecha . '</td>
                                //             <td>' . $value["horainicio"] . '</td>
                                //             <td>' . $value["horafinal"] . '</td>';

                                //     switch ($value["tipo"]) {
                                //         case "normal":
                                //             echo '<td> Tiempo Extra Normal </td>';
                                //             break;
                                //         case "semana":
                                //             echo '<td> Tiempo Extra de Fin de Semana </td>';
                                //             break;
                                //         case "festivo":
                                //             echo '<td> Tiempo Extra de Día Festivo </td>';
                                //             break;
                                //     }

                                //     echo '<td>' . $value["motivo"] . '</td>
                                //             <td>
                                //                 <div>
                                //                     <button class="btn btn-primary btn-sm rounded-circle mr-1 btnEditarHoras"
                                //                         id="' . $value["id"] . '" data-toggle="modal"
                                //                         data-target="#modalEditarHoras"><i
                                //                             class="fas fa-pencil-alt"></i></button>
                                //                 </div>  
                                //             </td>
                                //         </tr>';
                                // }
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

<!-- Modal Agregar Horario-->
<div class="modal fade" id="modalAgregarHoras" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Horas Extras</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Entrada de Fecha -->
                    <div class="form-group">
                        <label for="nuevoFecha">Fecha</label>
                        <input type="date" name="nuevoFecha" id="nuevoFecha" class="form-control" required>
                    </div>

                    <!-- Fecha Inicial -->
                    <div class="form-group">
                        <label for="simpleinput">Hora inicial</label>
                        <input type="text" name="nuevoHoraInicio" class="form-control" data-toggle="input-mask" data-mask-format="00:00:00" maxlength="8" placeholder="HH:MM:SS" required>
                    </div>

                    <!-- Fecha Fin -->
                    <div class="form-group">
                        <label for="simpleinput">Hora final</label>
                        <input type="text" name="nuevoHoraFinal" class="form-control" data-toggle="input-mask" data-mask-format="00:00:00" maxlength="8" placeholder="HH:MM:SS" required>
                    </div>

                    <!-- Entrada del Categoria -->
                    <div class="form-group">
                        <label for="nuevoTipo">Tipo</label>
                        <select class="form-control" name="nuevoTipo" id="nuevoTipo" required>
                            <option value="">Seleccione el tipo</option>
                            <option value="normal">Tiempo Extra Normal</option>
                            <option value="semana">Tiempo Extra de Fin de Semana</option>
                            <option value="festivo">Tiempo Extra de Día Festivo</option>
                        </select>
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

                            $empleado = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);

                            foreach ($empleado as $key => $value) {

                                echo '<option value="' . $value["id"] . ' ">' . $value["nombre"] . " " . $value["apellido1"] . " " . $value["apellido2"] . '</option>';
                            }

                            ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                // $crearHorario = new ControladorHorario();
                // $crearHorario->ctrCrearHorario();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Horario-->
<div class="modal fade" id="modalEditarHoras" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Horas Extras</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Entrada de Fecha de Nacimiento -->
                    <div class="form-group">
                        <label for="editarFecha">Fecha</label>
                        <input type="date" name="editarFecha" id="editarFecha" class="form-control" required>
                    </div>

                    <!-- Fecha Inicial -->
                    <div class="form-group">
                        <label for="simpleinput">Hora inicial</label>
                        <input type="text" name="editarHoraInicio" class="form-control" data-toggle="input-mask" data-mask-format="00:00:00" maxlength="8" placeholder="HH:MM:SS" required>
                    </div>

                    <!-- Fecha Fin -->
                    <div class="form-group">
                        <label for="simpleinput">Hora final</label>
                        <input type="text" name="editarHoraFin" class="form-control" data-toggle="input-mask" data-mask-format="00:00:00" maxlength="8" placeholder="HH:MM:SS" required>
                    </div>

                    <!-- Entrada del Categoria -->
                    <div class="form-group">
                        <label for="editarTipo">Tipo</label>
                        <select class="form-control" name="editarTipo" id="editarTipo" required>
                            <option value="">Seleccione el tipo</option>
                            <option value="normal">Tiempo Extra Normal</option>
                            <option value="semana">Tiempo Extra de Fin de Semana</option>
                            <option value="festivo">Tiempo Extra de Día Festivo</option>
                        </select>
                    </div>

                    <!-- Entrada Motivo -->
                    <div class="form-group">
                        <label for="editarMotivo">Motivo</label>
                        <textarea class="form-control" name="editarMotivo" id="editarMotivo" required></textarea>
                    </div>

                    <!-- Entrada del Empleado -->
                    <div class="form-group">
                        <label for="editarEmpleado">Empleado</label>
                        <select class="form-control" name="editarEmpleado" id="editarEmpleado" required>
                            <option value="">Seleccione el empleado</option>
                            <?php

                            $item = null;
                            $valor = null;

                            $empleado = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);

                            foreach ($empleado as $key => $value) {

                                echo '<option value="' . $value["id"] . ' ">' . $value["nombre"] . " " . $value["apellido1"] . " " . $value["apellido2"] . '</option>';
                            }

                            ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                // $crearHorario = new ControladorHorario();
                // $crearHorario->ctrCrearHorario();
                ?>
            </form>
        </div>
    </div>
</div>