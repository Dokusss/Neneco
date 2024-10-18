<?php

require_once "../controladores/empleado.controlador.php";
require_once "../modelos/empleado.modelo.php";

class AjaxEmpleado
{

  /*=============================================
  EDITAR EMPLEADO
  =============================================*/
  public $idEmpleado;
  public function ajaxEditarEmpleado()
  {
    $item = "id";
    $valor = $this->idEmpleado;
    $respuesta = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);
    echo json_encode($respuesta);
  }

  /*=============================================
  ACTIVAR EMPLEADO
  =============================================*/
  public $activarEmpleado;
  public $activarId;
  public function ajaxActivarEmpleado()
  {
    $tabla = "empleados";
    $item1 = "estado";
    $valor1 = $this->activarEmpleado;
    $item2 = "id";
    $valor2 = $this->activarId;
    $respuesta = ModeloEmpleado::mdlActualizarEmpleado($tabla, $item1, $valor1, $item2, $valor2);
  }

  /*=============================================
  VALIDAR NO REPETIR CI
  =============================================*/
  public $validarCi;
  public function ajaxValidarCi()
  {
    $item = "ci";
    $valor = $this->validarCi;
    $respuesta = ControladorEmpleado::ctrMostrarEmpleado($item, $valor);
    echo json_encode($respuesta);
  }
}

/*=============================================
EDITAR EMPLEADO
=============================================*/
if (isset($_POST["idEmpleado"])) {
  $editarEmpleado = new AjaxEmpleado();
  $editarEmpleado->idEmpleado = $_POST["idEmpleado"];
  $editarEmpleado->ajaxEditarEmpleado();
}

/*=============================================
ACTIVAR EMPLEADO
=============================================*/

if (isset($_POST["activarEmpleado"])) {
  $activarEmpleado = new AjaxEmpleado();
  $activarEmpleado->activarEmpleado = $_POST["activarEmpleado"];
  $activarEmpleado->activarId = $_POST["activarId"];
  $activarEmpleado->ajaxActivarEmpleado();
}

/*=============================================
VALIDAR NO REPETIR CI
=============================================*/
if (isset($_POST["validarCi"])) {
  $valCi = new AjaxEmpleado();
  $valCi->validarCi = $_POST["validarCi"];
  $valCi->ajaxValidarCi();
}
