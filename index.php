<?php
require_once "controladores/controlador.plantilla.php";
require_once "controladores/cargo.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/empleado.controlador.php";
require_once "controladores/horario.controlador.php";
require_once "controladores/asistencia.controlador.php";
require_once "controladores/permisos.controlador.php";
require_once "controladores/horas.controlador.php";
require_once "controladores/anticipos.controlador.php";

require_once "modelos/cargo.modelo.php";
require_once "modelos/usuarios.modelo.php";
require_once "modelos/empleado.modelo.php";
require_once "modelos/horario.modelo.php";
require_once "modelos/asistencia.modelo.php";
require_once "modelos/permisos.modelo.php";
require_once "modelos/horas.modelo.php";
require_once "modelos/anticipos.modelo.php";

 $plantilla = new ControladorPlantilla();
 $plantilla->ctrControlador();

?>