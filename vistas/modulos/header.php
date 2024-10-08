<header id="page-topbar">
    <div class="navbar-header">
        <!-- LOGO -->
        <div class="navbar-brand-box d-flex align-items-left">
            <a href="inicio" class="logo">
                <i class="mdi mdi-album"></i>
                <span>
                    NENECO
                </span>
            </a>

            <button type="button" class="btn btn-sm mr-2 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-sm mr-2 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <div class="dropdown d-inline-block ml-2">
                <button type="button" class="btn header-item waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <?php

                    if ($_SESSION["foto"] != "") {

                        echo '<img src="' . $_SESSION["foto"] . '" class="rounded-circle header-profile-user" alt="Header Avatar">';
                    } else {


                        echo '<img src="vistas/images/users/default.png" class="rounded-circle header-profile-user" alt="Header Avatar">';
                    }


                    ?>

                    <h6 class="d-none d-sm-inline-block ml-1" style="color: #efecf0;"><?php echo $_SESSION["nombre"]; ?></h6>

                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="salir">
                        <span>Salir</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</header>