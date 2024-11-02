<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Sistema Neneco</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="MyraStudio" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="vistas/images/favicon.ico">
  <!-- Sweet Alerts css -->
  <link href="vistas/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <link href="vistas/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
  <!-- Plugins css -->
  <link href="vistas/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
  <link href="vistas/plugins/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
  <link href="vistas/plugins/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
  <link href="vistas/plugins/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />
  <link href="vistas/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
  <!-- Dropify css -->
  <link href="vistas/plugins/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
  <!-- App css -->
  <link href="vistas/css/bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="vistas/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="vistas/css/theme.css" rel="stylesheet" type="text/css" />
  <link href="vistas/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
  <!-- jQuery  -->
  <script src="vistas/js/jquery.min.js"></script>
  <script src="vistas/js/bootstrap.bundle.min.js"></script>
  <script src="vistas/js/waves.js"></script>
  <script src="vistas/js/simplebar.min.js"></script>
  <!-- Sweet Alerts Js-->
  <script src="vistas/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Sweet Alerts Js-->
  <script src="vistas/pages/sweet-alert-demo.js"></script>
</head>

<body>
  <?php
  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
    echo '<div id="layout-wrapper">';
    echo '<div class="main-content">';
    include "modulos/header.php";
    include "modulos/nav.php";
    if (isset($_GET["rutas"])) {
      if (
        $_GET["rutas"] == "inicio" ||
        $_GET["rutas"] == "cargo" ||
        $_GET["rutas"] == "empleado" ||
        $_GET["rutas"] == "horario" ||
        $_GET["rutas"] == "asistencia" ||
        $_GET["rutas"] == "usuario" ||
        $_GET["rutas"] == "permisos" ||
        $_GET["rutas"] == "horasextras" ||
        $_GET["rutas"] == "anticipos" ||
        $_GET["rutas"] == "planilla" ||
        $_GET["rutas"] == "feriados" ||
        $_GET["rutas"] == "salir"
      ) {
        include "modulos/" . $_GET["rutas"] . ".php";
      } else {
        include "modulos/404.php";
      }
    } else {
      include "modulos/inicio.php";
    }
    include "modulos/footer.php";
    echo '</div>';
    echo '</div>';
  } else {
    include "modulos/login.php";
  }
  ?>
  <!-- third party js -->
  <script src="vistas/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="vistas/plugins/datatables/dataTables.bootstrap4.js"></script>
  <script src="vistas/plugins/datatables/dataTables.responsive.min.js"></script>
  <script src="vistas/plugins/datatables/responsive.bootstrap4.min.js"></script>
  <script src="vistas/plugins/datatables/dataTables.buttons.min.js"></script>
  <script src="vistas/plugins/datatables/buttons.bootstrap4.min.js"></script>
  <script src="vistas/plugins/datatables/buttons.html5.min.js"></script>
  <script src="vistas/plugins/datatables/buttons.flash.min.js"></script>
  <script src="vistas/plugins/datatables/buttons.print.min.js"></script>
  <script src="vistas/plugins/datatables/dataTables.keyTable.min.js"></script>
  <script src="vistas/plugins/datatables/dataTables.select.min.js"></script>
  <script src="vistas/plugins/datatables/pdfmake.min.js"></script>
  <script src="vistas/plugins/datatables/vfs_fonts.js"></script>
  <!-- third party js ends -->
  <!-- Datatables init -->
  <script src="vistas/pages/datatables-demo.js"></script>
  <!-- Mask Js-->
  <script src="vistas/plugins/jquery-mask/jquery.mask.min.js"></script>
  <!-- Mask Custom Js-->
  <script src="vistas/pages/mask-demo.js"></script>
  <!--dropify-->
  <script src="vistas/plugins/dropify/dropify.min.js"></script>
  <!-- Init js-->
  <script src="vistas/pages/fileuploads-demo.js"></script>
  <!-- Select2-->
  <script src="vistas/plugins/select2/select2.min.js"></script>
  <!-- Daterangepicker-->
  <script src="vistas/plugins/moment/moment.js"></script>
  <script src="vistas/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Toastr-->
  <script src="vistas/plugins/toastr/toastr.min.js"></script>
  <!-- App js -->
  <script src="vistas/js/theme.js"></script>
  <script src="vistas/js/plantilla.js"></script>
  <script src="vistas/js/cargo.js"></script>
  <script src="vistas/js/horario.js"></script>
  <script src="vistas/js/usuarios.js"></script>
  <script src="vistas/js/empleado.js"></script>
  <script src="vistas/js/asistencia.js"></script>
  <script src="vistas/js/permisos.js"></script>
  <script src="vistas/js/horasextras.js"></script>
  <script src="vistas/js/anticipos.js"></script>
  <script src="vistas/js/planilla.js"></script>
</body>

</html>