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
                        <button type="button" class="btn btn-primary waves-effect waves-light card-title" data-toggle="modal" data-target="#modalAgregarHoras">
                            <i class="feather-plus mr-1"></i> Agregar
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
                                    $fecha= date("d-m-Y", strtotime($value["fecha"]));

                                    echo '<tr>
                                            <th class="sorting_1">' . ($key + 1) . '</th> ';

                                    $item = "id";
                                    $valor = $value["idempleado"];

                                    $empleado = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);

                                    $nomMayus = mb_strtoupper($empleado["nombre"], 'UTF-8');
                                    $ap1Mayus = mb_strtoupper($empleado["apellidop"], 'UTF-8');
                                    $ap2Mayus = mb_strtoupper($empleado["apellidom"], 'UTF-8');

                                    echo '<td>' . $nomMayus . " " . $ap1Mayus . " " . $ap2Mayus . '</td>
                                            <td>' . $fecha . '</td>
                                            <td>' . $value["monto"] . " bs." .'</td>
                                            <td>
                                                <div>
                                                    <button class="btn btn-primary btn-sm rounded-circle mr-1 btnEditarHoras"
                                                        id="' . $value["id"] . '" data-toggle="modal"
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
