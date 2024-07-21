<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center min-vh-100">
                    <div class="w-100 d-block bg-white shadow-lg rounded my-5">
                        <div class="row">
                            <div class="col-lg-5 d-none d-lg-block bg-login rounded-left"></div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                <div class="text-center mb-5">
                                                <a href="inicio" class="text-dark font-size-22 font-family-secondary">
                                                    <i class="mdi mdi-album"></i> <b class="align-middle">NENECO</b>
                                                </a>
                                            </div>
                                    <h1 class="h5 mb-1">Bienvenido de nuevo!</h1>
                                    <p class="text-muted mb-4">Ingrese su Usuario y su Contraceña para acceder al sistema.</p>
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" placeholder="Usuario" name="ingUsuario" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" placeholder="Contraceña" name="ingPassword" required>
                                        </div>
                                        <button type="success" class="btn btn-primary btn-block waves-effect waves-light">Ingresar</button>
                                        <br>
                                        <?php

                                        $login = new ControladorUsuarios();
                                        $login->ctrIngresoUsuario();

                                        ?>

                                    </form>

                                    <!-- <div class="row mt-4">
                                        <div class="col-12 text-center">
                                            <p class="text-muted mb-2"><a href="pages-recoverpw.html" class="text-muted font-weight-medium ml-1">Forgot your password?</a></p>
                                            <p class="text-muted mb-0">Don't have an account? <a href="pages-register.html" class="text-muted font-weight-medium ml-1"><b>Sign Up</b></a></p>
                                        </div>
                                    </div> -->
                                    <!-- end row -->
                                </div> <!-- end .padding-5 -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- end .w-100 -->
                </div> <!-- end .d-flex -->
            </div> <!-- end col-->
        </div> <!-- end row -->
    </div>
    <!-- end container -->
</div>