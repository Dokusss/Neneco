<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Cargos</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestion de Personal</li>
                            <li class="breadcrumb-item active">Cargos</li>
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
                            <i class="feather-plus mr-1"></i> Registrar
                        </button>

                        <table class="table dt-responsive nowrap tablas">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $item = null;
                                $valor = null;
                                $cargo = ControladorCargo::ctrMostrarCargo($item, $valor);
                                foreach ($cargo as $key => $value) {
                                    echo '<tr class="odd" role="row">
                                            <th class="sorting_1">' . ($key + 1) . '</th>  
                                            <td class="text-uppercase">' . $value["nombre"] . '</td>
                                            <td>
                                                <div>
                                                    <button class="btn btn-primary btn-sm mr-1 btnEditarCargo"
                                                        id="' . $value["id"] . '" data-toggle="modal"
                                                        data-target="#modalEditarCargo"><i
                                                            class="fas fa-pencil-alt"></i></button>
                                                    <button class="btn btn-danger btn-sm btnEliminarCargo"
                                                        id="' . $value["id"] . '"><i class="fa fa-trash"></i></button>
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

<!-- Modal Agregar Cargo-->
<div class="modal fade" id="modalAgregarCargo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <input type="text" name="nuevoNombre" id="nuevoNombre" class="form-control nuevoNombre"
                            placeholder="Ingrese en nombre" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $crearCargo = new ControladorCargo();
                $crearCargo->ctrCrearCargo();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Cargo-->
<div class="modal fade" id="modalEditarCargo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <label for="simpleinput">Nombre del Cargo</label>
                        <input type="text" name="editarNombre" id="editarNombre" value="" class="form-control nuevoNombre">
                        <input type="hidden" name="id" id="id" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $editarCargo = new ControladorCargo();
                $editarCargo->ctrEditarCargo();
                ?>
            </form>
        </div>
    </div>
</div>

<?php
$borrarCargo = new ControladorCargo();
$borrarCargo->ctrBorrarCargo();
?>