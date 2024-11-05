<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18"></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                            <li class="breadcrumb-item active">Planillas de Pago</li>
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
                        <table class="table dt-responsive nowrap tablas">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Documento</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Cargo</th>
                                    <th>Dias Trabajados</th>
                                    <th>Haber Basico</th>
                                    <th>Horas Extras</th>
                                    <th>Faltas</th>
                                    <th>Anticipos</th>
                                    <th>Total Descuentos</th>
                                    <th>Liquido Pagado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $idPlanilla = $_GET["idPlanilla"];
                                $planilla = ModeloPlanilla::mdlImprimirPlanilla($idPlanilla);
                                foreach ($planilla as $key => $value) {

                                    echo '<tr>
                                        <th font-weight: bold;">' . $value["id"] . '</th> 
                                        <td>' . $value["ci"] . '</td>
                                        <td>' . $value["nombre"] . '</td>
                                        <td>' . $value["apellidop"] . ' ' . $value["apellidom"] . '</td>
                                        <td>' . $value["nombre_cargo"] . '</td>
                                        <td>' . $value["diastrabajados"] . '</td>
                                        <td>' . number_format($value["haberbasico"], 2) . ' bs.</td>
                                        <td>' . number_format($value["horasextras"], 2) . ' bs.</td>
                                        <td>' . $value["faltas"] . '</td>
                                        <td>' . number_format($value["anticipos"], 2) . ' bs.</td>
                                        <td>' . number_format($value["totaldescuentos"], 2) . ' bs.</td>
                                        <td>' . number_format($value["liquidopagable"], 2) . ' bs.</td>
                                        <td>
                                            <div>
                                                <button class="btn btn-info btn-sm rounded-circle mr-1 btnImprimirBoletaDePago"
                                                idEmpleado="' . $value["id"] . '"><i
                                                    class="far fa-file-pdf"></i></button>
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