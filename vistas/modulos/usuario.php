<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Usuarios</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Usuarios</li>
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
                            data-toggle="modal" data-target="#modalAgregarUsuario">
                            <i class="feather-plus mr-1"></i> Registrar
                        </button>

                        <table class="table dt-responsive nowrap tablas">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Estado</th>
                                    <th>Ultima Vez Conectado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $item = null;
                                $valor = null;
                                $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

                                foreach ($usuarios as $key => $value) {

                                    $nombreMayusculas = mb_strtoupper($value["nombre"], 'UTF-8');

                                    echo '<tr>
                                            <th class="sorting_1">' . ($key + 1) . '</th>';
                                    if ($value["foto"] != "") {
                                        echo '<td><img src="' . $value["foto"] . '" class="rounded-circle" width="45"></td>';
                                    } else {
                                        echo '<td><img class="rounded-circle" src="vistas/images/users/default.png" alt="Generic placeholder image" height="45"></td>';
                                    }
                                    echo '<td>' . $nombreMayusculas . '</td>
                                                  <td>' . $value["usuario"] . '</td>';

                                    if ($value["estado"] != 0) {
                                        echo '<td><button class="btn btn-sm btn-primary btnActivar" id="' . $value["id"] . '" estadoUsuario="0">Activado</button></td>';
                                    } else {
                                        echo '<td><button class="btn btn-sm btn-danger btnActivar" id="' . $value["id"] . '" estadoUsuario="1">Desactivado</button></td>';
                                    }

                                    echo '<td>' . $value["ultimologin"] . '</td>
                                                  <td>
                                                    <div>
                                                        <button class="btn btn-sm btn-primary btnEditarUsuario rounded-circle mr-1" id="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fas fa-pen mdi-lg"></i></button>
                                                        <button class="btn btn-sm btn-danger btnEliminarUsuario rounded-circle mr-1" id="' . $value["id"] . '" fotoUsuario="' . $value["foto"] . '" usuario="' . $value["usuario"] . '"><i class="fas fa-trash mdi-lg"></i></button>
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

<!-- Modal Agregar Usuario-->
<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Usuario</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Entrada del Nombre -->
                    <div class="form-group">
                        <label for="nuevoNombre">Nombre del Usuario</label>
                        <input type="text" name="nuevoNombre" id="nuevoNombre" class="form-control"
                            placeholder="Ingrese el nuevo nombre" required>
                    </div>

                    <!-- Entrada del Usuario -->
                    <div class="form-group">
                        <label for="nuevoUsuario">Usuario</label>
                        <input type="text" name="nuevoUsuario" id="nuevoUsuario" class="form-control"
                            placeholder="Ingrese el nuevo usuario" required>
                    </div>

                    <!-- Entrada de la Contraseña -->
                    <div class="form-group">
                        <label for="nuevoPassword">Contraseña</label>
                        <input type="password" name="nuevoPassword" id="nuevoPassword" class="form-control"
                            placeholder="Ingrese la nueva contraceña" required>
                    </div>

                    <!-- Entrada de la Foto -->
                    <div class="form-group">
                        <label for="nuevaFoto">Foto</label>
                        <input type="file" name="nuevaFoto" id="nuevaFoto" class="dropify nuevaFoto"
                            data-default-file="vistas/images/users/default.png" data-max-file-size="2M" required />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $crearUsuario = new ControladorUsuarios();
                $crearUsuario->ctrCrearUsuario();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Usuario-->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Entrada del Nombre -->
                    <div class="form-group">
                        <label for="editarNombre">Nombre del Usuario</label>
                        <input type="text" name="editarNombre" id="editarNombre" class="form-control"
                            placeholder="Ingrese en nombre" required>
                    </div>

                    <!-- Entrada del Usuario -->
                    <div class="form-group">
                        <label for="editarUsuario">Usuario</label>
                        <input type="text" name="editarUsuario" id="editarUsuario" class="form-control"
                            placeholder="Ingrese en nombre" readonly required>
                    </div>

                    <!-- Entrada de la Contraseña -->
                    <div class="form-group">
                        <label for="editarPassword">Contraseña</label>
                        <input type="password" name="editarPassword" id="editarPassword" class="form-control"
                            placeholder="Ingrese en nombre" required>
                        <input type="hidden" id="passwordActual" name="passwordActual">
                    </div>

                    <!-- Entrada de la Foto -->
                    <div class="form-group">
                        <label for="editarFoto">Foto</label>
                        <input type="file" name="editarFoto" id="editarFoto" class="dropify nuevaFoto"
                            data-default-file="vistas/images/users/default.png" data-max-file-size="2M" />
                        <input type="hidden" name="fotoActual" id="fotoActual">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="success" class="btn btn-primary waves-effect waves-light">Guardar Cambios</button>
                </div>
                <?php
                $editarUsuario = new ControladorUsuarios();
                $editarUsuario->ctrEditarUsuario();
                ?>
            </form>
        </div>
    </div>
</div>

<?php
$borrarUsuario = new ControladorUsuarios();
$borrarUsuario->ctrBorrarUsuario();
?>