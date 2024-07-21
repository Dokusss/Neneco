<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Planilla</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Planilla</li>
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
                            data-toggle="modal" data-target="#modalGenerarPlanilla">
                            <i class="feather-plus mr-1"></i> Generar planilla
                        </button>

                        <table class="table dt-responsive nowrap tablaPlanilla">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td>1</td>
                                    <td>17-04-2024</td>
                                    <td><button class="btn btn-sm btn-primary btnEditarUsuario rounded-circle mr-1"><i
                                                class="fas fa-file-pdf"></i></button></td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- end row-->

    </div> <!-- container-fluid -->
</div>

<!-- Modal Agregar Cargo-->
<div class="modal fade" id="modalGenerarPlanilla" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Cargo</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Entrada del Nombre -->
                    <div class="form-group">
                        <label for="simpleinput">Nombre del Cargo</label>
                        <input type="text" name="nuevoCargo" id="nuevoCargo" class="form-control nuevoNombre"
                            placeholder="Ingrese en nombre" required>
                    </div>

                    <!-- Entrada del Salario -->
                    <div class="form-group">
                        <label for="simpleinput">Sueldo correspondiente al cargo</label>
                        <input type="number" name="nuevoSueldo" class="form-control" placeholder="Ingrese el sueldo"
                            required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                // $crearCargo = new ControladorCargo();
                // $crearCargo->ctrCrearCargo();
                ?>
            </form>
        </div>
    </div>
</div>