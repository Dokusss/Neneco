<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Planilla de pago</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Planilla de pago</li>
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

                        <table class="table dt-responsive nowrap tablas">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $item = null;
                                $valor = null;
                                $empleados = ControladorPlanilla::ctrMostrarPlanilla($item, $valor);
                                foreach ($empleados as $key => $value) {

                                    // Formatear la fecha
                                    $fecha = date("d-m-Y", strtotime($value["fecha"]));

                                    // Obtener el total de liquidopagable para esta planilla
                                    $idPlanilla = $value["id"];
                                    $totalLiquidopagable = ModeloPlanilla::mdlSumarLiquidopagable($idPlanilla);
                                    $totalLiquidopagableFormatted = number_format($totalLiquidopagable['total_liquidopagable'], 2);

                                    echo '<tr>
                                        <th class="sorting_1">' . ($key + 1) . '</th>  
                                        <td>' . $fecha . '</td>';

                                    // Mostrar el total de liquidopagable debajo de la fecha
                                    echo '<td>' . $totalLiquidopagableFormatted . '</td>';

                                    echo '<td>
                                            <div>
                                                <button class="btn btn-info btn-sm rounded-circle mr-1 btnReportePlanilla"
                                                    id="' . $value["id"] . '"><i
                                                        class="far fa-file-pdf"></i></button>
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
        </div>
        <!-- end row -->
    </div>
</div>

<!-- Modal Genera Planilla -->
<div class="modal fade" id="modalGenerarPlanilla" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form role="form" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generar planilla</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Entrada del Nombre -->
                    <div class="form-group">
                        <label for="fechaInicioP">Fecha de inicio</label>
                        <input type="date" id="fechaInicioP" name="fechaInicioP" class="form-control" required>
                    </div>

                    <!-- Entrada del Salario -->
                    <div class="form-group">
                        <label for="fechaFinP">Fecha fin</label>
                        <input type="date" id="fechaFinP" name="fechaFinP" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect waves-light"
                        data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="exporta">
                        <i class="feather-file mr-1"></i> Generar
                    </button>
                </div>
                <?php
                $crearPlanilla = new ControladorPlanilla();
                $crearPlanilla->ctrCrearPlanilla();
                ?>
            </form>
        </div>
    </div>
</div>