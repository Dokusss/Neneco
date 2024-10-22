<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Feriados</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestion de Personal</li>
                            <li class="breadcrumb-item active">Feriados</li>
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
                            data-toggle="modal" data-target="#modalAgregarFeriados">
                            <i class="feather-plus mr-1"></i> Agregar
                        </button>
                        <table class="table dt-responsive nowrap tablas">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $item = null;
                                $valor = null;
                                $feriados = ControladorFeriados::ctrMostrarFeriados($item, $valor);
                                foreach ($feriados as $key => $value) {
                                    $fecha = date("d-m-Y", strtotime($value["fecha"]));

                                    echo '<tr>
                                            <th class="sorting_1">' . ($key + 1) . '</th> 
                                            <td>' . $value["nombre"] . '</td>
                                            <td>' . $fecha . '</td>
                                            <td>
                                                <div>
                                                    <button class="btn btn-primary btn-sm mr-1 btnEditarFeriados"
                                                        idFeriados="' . $value["id"] . '" data-toggle="modal"
                                                        data-target="#modalEditarFeriados"><i
                                                            class="fas fa-pencil-alt"></i></button>
                                                    <button class="btn btn-danger btn-sm btnEliminarFeriados"
                                                        idFeriados="' . $value["id"] . '"><i class="fa fa-trash"></i></button>
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
<div class="modal fade" id="modalAgregarFeriados" tabindex="-1" role="dialog" aria-labelledby="modalAgregarFeriados"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Feriado</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Entrada del Nombre -->
                    <div class="form-group">
                        <label for="simpleinput">Nombre</label>
                        <input type="text" name="nuevoNombre" class="form-control" placeholder="Ingrese el nombre"
                            required>
                    </div>

                    <!-- Entrada de Fecha -->
                    <div class="form-group">
                        <label for="nuevoFecha">Fecha</label>
                        <input type="date" name="nuevoFechaF" id="nuevoFechaF" class="form-control nuevoFecha" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $crearFeriado = new ControladorFeriados();
                $crearFeriado->ctrCrearFeriados();
                ?>
            </form>
        </div>
    </div>
</div>